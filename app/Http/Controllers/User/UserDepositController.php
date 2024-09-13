<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\DepositHistory;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Transaction;


class UserDepositController extends Controller
{
    public function index()
    {
        $depositHistories = DepositHistory::with('user')
        ->where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
        return view('user.deposit.index', compact('depositHistories'));
    }

    //show mmgt depost form page
    public function index_mmgt()
    {
        try {
            $settings = GeneralSetting::firstOrFail();

            if (!$settings->deposit_enabled) {
                return back()->withErrors(['deposit_disabled' => 'Deposit is currently disabled.']);
            }

            return view('user.deposit.mmgt_deposit', ['settings' => $settings]);
        } catch (Exception $e) {

            return back()->withErrors(['error' => 'An error occurred while fetching deposit settings.']);
        }
    }


    public function index_coinbase()
    {
        try {
            $settings = GeneralSetting::firstOrFail();

            if (!$settings->deposit_enabled) {
                return back()->withErrors(['deposit_disabled' => 'Deposit is currently disabled.']);
            }

            return view('user.deposit.coinbase_deposit', ['settings' => $settings]);
        } catch (Exception $e) {

            return back()->withErrors(['error' => 'An error occurred while fetching deposit settings.']);
        }
    }


    //COINBASE COMMERCE DEPOSIT HANDLING
    public function createCharge(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1', // Minimum deposit amount is $1
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the sanitized amount
        $amount = $request->input('amount');

        try {
            // Create a new Guzzle HTTP client
            $client = new Client();

            // Prepare the charge data for the Coinbase request
            $chargeData = [
                'name' => 'Deposit',
                'description' => 'Fund Deposit',
                'local_price' => [
                    'amount' => $amount,
                    'currency' => 'USD',
                ],
                'pricing_type' => 'fixed_price',
                'redirect_url' => route('deposits.index'),
                'cancel_url' => route('deposits.index'),
            ];

            // Send the POST request to Coinbase Commerce
            $response = $client->post('https://api.commerce.coinbase.com/charges', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-CC-Api-Key' => env('COINBASE_COMMERCE_APIKEY'),
                    'X-CC-Version' => '2018-03-22',
                ],
                'json' => $chargeData
            ]);

            // Decode the JSON response
            $charge = json_decode($response->getBody()->getContents(), true);

            // Check if the charge ID is set in the response
            if (!isset($charge['data']['id'])) {
                return back()->withErrors(['error' => 'Failed to create charge with Coinbase.']);
            }

            // Get the Coinbase transaction ID
            $coinbaseTransactionId = $charge['data']['id'];

            // Save the transaction to deposit_history with systemTrxId
            $user = Auth::user();
            $user->depositHistory()->create([
                'transaction_id' => $coinbaseTransactionId,
                'account_id' => $user->account_id,
                'deposit_amount' => $amount,
                'deposit_method' => 'Coinbase',
                'transaction_status' => 'INITIATED',
            ]);

            // Redirect to the Coinbase charge page
            return redirect($charge['data']['hosted_url']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    //hadle response from coinbase
    public function handleCoinbaseWebhook(Request $request)
    {
        // Retrieve the request's body and parse it as JSON
        $payload = $request->getContent();

        $data = json_decode($payload, true);

        $signature = $request->header('X-CC-Webhook-Signature');
        $secret = env('COINBASE_COMMERCE_WEBHOOK_SECRET');
        if (!$this->isSignatureValid($payload, $signature, $secret)) {
            \Log::warning('Invalid signature detected.');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Check if 'type' key exists in the payload
        if (!isset($data['event']['type'])) {
            \Log::error('Webhook received without a type field.');
            return response()->json(['message' => 'No type field in payload'], 400);
        }

        // Extract the event type
        $eventType = $data['event']['type'];

        // Handle different event types
        switch ($eventType) {
            case 'charge:confirmed':
                $this->handleChargeConfirmed($data);
                break;

            case 'charge:pending':
                $this->handleChargePending($data);
                break;

            case 'charge:failed':
                $this->handleChargeFailed($data);
                break;

            case 'charge:resolved':
                $this->handleChargeResolved($data);
                break;

            case 'charge:delayed':
                $this->handleChargeDelayed($data);
                break;

            case 'charge:created':
                $this->handleChargeReceived($data);
                break;

            default:
                \Log::info('Received unhandled event type: ' . $eventType);
        }

        return response()->json(['message' => 'Webhook received successfully']);
    }


    protected function handleChargeReceived($data) {

        // Log the received data
        Log::info("Accessing data key", ['event_data' => $data['event']['data'] ?? 'Not found']);

        // Check if 'data' key exists in the 'event' array
        if (isset($data['event']) && isset($data['event']['data'])) {
            $eventData = $data['event']['data']; // Correct variable usage
            // Now $eventData contains the 'data' array.

            // Extract transaction_id from the webhook data
            $coinbaseTransactionId = $eventData['id']; // Use $eventData instead of $data
            Log::info('Received id: ' . $coinbaseTransactionId);

            // Retrieve the transaction from your deposit_history table
            $transaction = DepositHistory::where('transaction_id', $coinbaseTransactionId)->first();

            if (!$transaction) {
                // Transaction not found, log error or handle it
                Log::error("Transaction not found: Coinbase Transaction ID {$coinbaseTransactionId}");
                return;
            }

            // Update the transaction status to 'PENDING'
            $transaction->update(['transaction_status' => 'INITIATED']);
        } else {
            Log::error("Data key not found in payload");
        }
    }


    // Implement the event-specific handling methods
    protected function handleChargeConfirmed($data) {
        // Extract transaction_id from the webhook data
        $coinbaseTransactionId = $data['event']['data']['id'] ?? null;

        // Retrieve the transaction from your deposit_history table
        $transaction = DepositHistory::where('transaction_id', $coinbaseTransactionId)->first();

        if (!$transaction) {
            // Transaction not found, log error or handle it
            Log::error("Transaction not found: Coinbase Transaction ID {$coinbaseTransactionId}");
            return;
        }

        // Update the transaction status to 'COMPLETED'
        $transaction->update(['transaction_status' => 'COMPLETED']);

        // Update user's fund_wallet_balance
        $user = $transaction->user; // Accessing the user associated with this transaction
        if ($user) {
            $amount = $transaction->deposit_amount; // Assuming you have this field in your DepositHistory
            $user->increment('fund_wallet_balance', $amount);

            Transaction::create([
                'from_user_id' => $user->id,
                'to_user_id' => $user->id,
                'amount' => $amount,
                'sender_description' => 'Fund Wallet: Balance deducted for deposit using Coinbase', // Description for the sender
                'receiver_description' => 'Fund Wallet: Balance added via deposit using Coinbase', // Description for the receiver
                'trx_type' => 'Balance_Deposit',
            ]);

        } else {
            // Handle case where user is not found
            Log::error("User not found for transaction: {$coinbaseTransactionId}");
        }
    }

    protected function handleChargePending($data) {
        // Extract transaction_id from the webhook data
        $coinbaseTransactionId = $data['event']['data']['id'] ?? null;

        // Retrieve the transaction from your deposit_history table
        $transaction = DepositHistory::where('transaction_id', $coinbaseTransactionId)->first();

        if (!$transaction) {
            // Transaction not found, log error or handle it
            //Log::error("Transaction not found: Coinbase Transaction ID {$coinbaseTransactionId}");
            return;
        }

        // Update the transaction status to 'PENDING'
        $transaction->update(['transaction_status' => 'PENDING']);
    }

    protected function handleChargeFailed($data) {
        Log::info("handleChargeFailed data: ", $data);

        $coinbaseTransactionId = $data['event']['data']['id'] ?? null;

        if (!$coinbaseTransactionId) {
            //Log::error("Data key not found in payload or Transaction ID missing");
            return;
        }


        // Retrieve the transaction from your deposit_history table
        $transaction = DepositHistory::where('transaction_id', $coinbaseTransactionId)->first();

        if (!$transaction) {
            //Log::error("Transaction not found: Coinbase Transaction ID {$coinbaseTransactionId}");
            return;
        }

        // Update the transaction status to 'FAILED'
        $transaction->update(['transaction_status' => 'FAILED']);
    }


    protected function handleChargeResolved($data) {
        // Extract transaction_id from the webhook data
        $coinbaseTransactionId = $data['event']['data']['id'] ?? null;

        // Retrieve the transaction from your deposit_history table
        $transaction = DepositHistory::where('transaction_id', $coinbaseTransactionId)->first();

        if (!$transaction) {
            // Transaction not found, log error or handle it
            //Log::error("Transaction not found: Coinbase Transaction ID {$coinbaseTransactionId}");
            return;
        }

        // Update the transaction status to 'COMPLETED'
        $transaction->update(['transaction_status' => 'COMPLETED']);

        // Update user's fund_wallet_balance
        $user = $transaction->user; // Accessing the user associated with this transaction
        if ($user) {
            $amount = $transaction->deposit_amount; // Assuming you have this field in your DepositHistory
            $user->increment('fund_wallet_balance', $amount);

            Transaction::create([
                'from_user_id' => $user->id,
                'to_user_id' => $user->id,
                'amount' => $amount,
                'sender_description' => 'Fund Wallet: Balance deducted for deposit using Coinbase', // Description for the sender
                'receiver_description' => 'Fund Wallet: Balance added via deposit using Coinbase', // Description for the receiver
                'trx_type' => 'Balance_Deposit',
            ]);

        } else {
            // Handle case where user is not found
            //Log::error("User not found for transaction: {$coinbaseTransactionId}");
        }
    }


    protected function handleChargeDelayed($data) {
        // Extract transaction_id from the webhook data
        $coinbaseTransactionId = $data['event']['data']['id'] ?? null;

        // Retrieve the transaction from your deposit_history table
        $transaction = DepositHistory::where('transaction_id', $coinbaseTransactionId)->first();

        if (!$transaction) {
            // Transaction not found, log error or handle it
            //Log::error("Transaction not found: Coinbase Transaction ID {$coinbaseTransactionId}");
            return;
        }

        // Update the transaction status to 'DELAYED'
        $transaction->update(['transaction_status' => 'DELAYED']);
    }

    // Function to verify signature
    protected function isSignatureValid($payload, $signature, $secret)
    {
        // Compute the HMAC signature
        $computedSignature = hash_hmac('sha256', $payload, $secret);


        if (is_null($signature)) {
            // If the signature is null, log this information and return false
            //Log::warning("Null signature received in webhook.");
            return false;
        }

        return hash_equals($computedSignature, $signature);
    }



}
