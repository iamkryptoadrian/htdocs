<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DepositHistory;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Services\EthereumService;
use App\Models\Transaction;

use Illuminate\Support\Facades\Log;

class TokenTransactionController extends Controller
{
    protected $ethereumService;

    public function __construct(EthereumService $ethereumService)
    {
        $this->ethereumService = $ethereumService;
    }

    public function TokenTransaction(Request $request)
    {
        try {
            //\Log::info('Incoming request data:', $request->all());

            // Validate the request
            $validatedData = $request->validate([
                'transactionHash' => 'required|string',
                'userId' => 'required|integer',
                'amountUSD' => 'required|numeric',
                'amountMMGT' => 'required|numeric'
            ]);

            $transactionHash = $validatedData['transactionHash'];
            $userId = $validatedData['userId'];

            $user = User::find($userId);

            // Retrieve the user from the database
            if (!$user) {
            //    \Log::error('User not found', ['userId' => $userId]);
                return response()->json(['error' => 'User not found'], 404);
            }
            //\Log::info('User retrieved successfully', ['userId' => $userId]);

            // Fetch transaction details using EthereumService
            $transactionDetails = $this->ethereumService->getTransactionDetails($transactionHash);

            if (!$transactionDetails ||
                empty($transactionDetails['smartContractAddress']) ||
                empty($transactionDetails['adminWalletAddress']) ||
                empty($transactionDetails['transactionValue'])) {
                return response()->json(['error' => 'Invalid or incomplete transaction details'], 400);
            }

            \Log::info('Received Transaction Details', $transactionDetails);

            // Access the transaction details directly
            $smartContractAddress = strtolower($transactionDetails['smartContractAddress']);
            $adminWalletAddress = strtolower($transactionDetails['adminWalletAddress']);
            $transactionValue = $transactionDetails['transactionValue'];

            //\Log::info('Checking smart contract address and admin wallet address');

            // Validate admin wallet address and token contract address
            $expectedAdminWalletAddress = strtolower(env('ADMIN_WALLET_ADDRESS'));
            $expectedTokenContractAddress = strtolower(env('TOKEN_ADDRESS'));
            if ($smartContractAddress !== $expectedTokenContractAddress ||
                $adminWalletAddress !== $expectedAdminWalletAddress) {
                return response()->json(['error' => 'Transaction addresses do not match'], 400);
            }

            //\Log::info('Checking if amount is valid');

            // Validate transaction amount
            $amountMMGT = $validatedData['amountMMGT'];

            if ($transactionValue != $amountMMGT) {
                return response()->json(['error' => 'Transaction amount does not match'], 400);
            }

            // Check if transaction is already recorded
            $existingTransaction = DepositHistory::where('transaction_id', $transactionHash)->first();
            //\Log::info('Checking existing transaction', ['existingTransaction' => $existingTransaction]);

            if ($existingTransaction) {
               // \Log::warning('Transaction already recorded', ['transactionId' => $transactionHash]);
                return response()->json(['error' => 'Transaction already recorded'], 400);
            }

            //\Log::info('Recording transaction in database', ['transactionId' => $transactionHash, 'userId' => $userId, 'amountUSD' => $validatedData['amountUSD']]);

            // Record the transaction in the database
            $depositHistory = new DepositHistory();
            $depositHistory->transaction_id = $transactionHash;
            $depositHistory->user_id = $userId;
            $depositHistory->account_id = $user->account_id;
            $depositHistory->deposit_amount = $validatedData['amountUSD'];
            $depositHistory->deposit_method = 'MMGT';
            $depositHistory->transaction_status = 'COMPLETED';
            $depositHistory->save();

            // Record in the transaction table
            Transaction::create([
                'from_user_id' => $userId,
                'to_user_id' => $userId,
                'amount' => $validatedData['amountUSD'],
                'sender_description' => 'Fund Wallet: Balance deducted for addition via MMGT', // Description for the sender
                'receiver_description' => 'Fund Wallet: Balance added via MMGT', // Description for the receiver
                'trx_type' => 'Balance_Deposit',
            ]);

            // Update user's wallet balance
            $user->fund_wallet_balance += $validatedData['amountUSD'];
            $user->save();

            //\Log::info('Transaction recorded successfully', ['transactionId' => $transactionHash]);

            session()->flash('success', 'Transaction recorded successfully');
            return response()->json(['redirectUrl' => route('deposits.index')]);

        } catch (Exception $e) {
            //\Log::error('Transaction failed', ['error' => $e->getMessage(), 'transactionHash' => $transactionHash]);
            session()->flash('error', $e->getMessage());
            return response()->json(['redirectUrl' => route('deposits.index')]);
        }
    }
}
