<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\AgentTransaction;
use App\Models\CashoutTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashoutController extends Controller
{
    public function index(Request $request)
    {
        // Get the logged-in agent
        $agent = Auth::guard('agent')->user();

        // Retrieve the settings and decode the withdraw methods
        $settings = GeneralSetting::first();
        $methods = json_decode($settings->agent_withdraw_method, true) ?? [];

        // Available Commission
        $availableCommission = $agent->agent_wallet_balance;

        // Pending Commission
        $pendingCommission = AgentTransaction::where('agent_code', $agent->agent_code)
            ->where('commission_status', 'pending')
            ->sum('commission_amount');

        // Total Cashout
        $totalCashout = CashoutTransaction::where('agent_code', $agent->agent_code)
            ->where('status', 'approved')
            ->sum('total_amount');

        // Pending Cashout
        $pendingCashout = $agent->pending_cashout;

        // Recent Cashout Transactions
        $recentTransactions = CashoutTransaction::where('agent_code', $agent->agent_code)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('agent.cashout', compact(
            'agent',
            'methods',
            'availableCommission',
            'pendingCommission',
            'totalCashout',
            'pendingCashout',
            'recentTransactions'
        ));
    }


    public function store(Request $request)
    {
        $settings = GeneralSetting::first();
        $methods = collect(json_decode($settings->agent_withdraw_method, true));

        $method = $methods->firstWhere('name', $request->input('request_type'));

        // Get the logged-in agent
        $agent = Auth::guard('agent')->user();

        // Validate the request
        $request->validate([
            'request_type' => 'required|string',
            'details' => 'required|string',
            'amount' => 'required|numeric|min:' . $method['min_withdrawal'],
        ]);

        // Check if the agent has enough balance
        if ($agent->agent_wallet_balance < $request->input('amount')) {
            return redirect()->route('agent.cashout')->with('error', 'Insufficient wallet balance.');
        }

        DB::beginTransaction();

        try {
            // Deduct the amount from the agent's wallet balance
            $agent->agent_wallet_balance -= $request->input('amount');
            // Add the amount to the pending cashout column
            $agent->pending_cashout += $request->input('amount');
            $agent->save();

            // Generate a unique transaction ID
            $transactionId = 'ROA' . strtoupper(uniqid()) . 'A';

            // Create the cashout transaction
            CashoutTransaction::create([
                'trx_id' => $transactionId,
                'cashout_method' => $request->input('request_type'),
                'total_amount' => $request->input('amount'),
                'status' => 'pending',
                'agent_code' => $agent->agent_code,
                'details' => $request->input('details'),
            ]);

            DB::commit();

            return redirect()->route('agent.cashout')->with('success', 'Cashout request submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error message
            Log::error('Error processing cashout request: ' . $e->getMessage(), [
                'agent_id' => $agent->id,
                'request_type' => $request->input('request_type'),
                'amount' => $request->input('amount'),
                'details' => $request->input('details')
            ]);

            return redirect()->route('agent.cashout')->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }


}
