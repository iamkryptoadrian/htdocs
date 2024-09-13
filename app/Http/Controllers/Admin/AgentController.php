<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CashoutTransaction;


class AgentController extends Controller
{

    // Display all Agents
    public function index(Request $request)
    {
        // Default values
        $recordsPerPage = $request->query('show', 20);
        $sortOrder = $request->query('order', 'ASC');
        $sortBy = $request->query('sortBy', 'created_at');
        $searchTerm = $request->query('search');

        // Validate sortOrder to prevent SQL injection or errors
        $sortOrder = $sortOrder === 'ASC' ? 'ASC' : 'DESC';

        // Start the query builder, do not execute get() yet
        $query = Agent::query();

        // Apply search term if provided
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%")
                      ->orWhere('id', 'like', "%{$searchTerm}%");
            });
        }

        // Retrieve Agents with pagination and sorting
        $agents = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);

        // Attach the current query string to the pagination links to maintain state
        $agents->appends($request->except('page'));

        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $agents->lastPage();
        // This array will be passed to the view for generating the "go-to" dropdown options
        $pageRange = range(1, $totalPages);

        // Pass necessary data to the view
        return view('admin.agentlist', [
            'agents' => $agents,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }

    //BAN Agent
    public function banAgent(Agent $agent)
    {
        if (Auth::guard('admin')->check()) {
            // The admin user is authenticated
            $adminUser = Auth::guard('admin')->user();

            // Check if the admin user has permission to ban/unban users (you can add your own logic here)

            // Update the agent's account status (toggle between 'active' and 'banned')
            $newStatus = $agent->account_status === 'active' ? 'banned' : 'active';
            $agent->update(['account_status' => $newStatus]);

            // Return a success message based on the new status
            $message = $newStatus === 'active' ? 'Agent has been unbanned.' : 'Agent has been banned.';
            return redirect()->route('admin.agentlist')->with('success', $message);
        } else {
            // The admin user is not authenticated, handle this case (e.g., redirect them to the login page)
            return redirect()->route('admin.login')->with('error', 'You must be logged in as an admin to perform this action.');
        }
    }

    public function viewCashoutRequests(Request $request)
    {
        // Default values
        $recordsPerPage = $request->query('show', 20);
        $sortOrder = $request->query('order', 'DESC');
        $sortBy = $request->query('sortBy', 'created_at');
        $searchTerm = $request->query('search');

        // Validate sortOrder to prevent SQL injection or errors
        $sortOrder = $sortOrder === 'ASC' ? 'ASC' : 'DESC';

        // Start the query builder, do not execute get() yet
        $query = CashoutTransaction::query();

        // Apply search term if provided
        if ($searchTerm) {
            $query->where('trx_id', 'like', "%{$searchTerm}%");
        }

        // Retrieve cashout requests with pagination and sorting
        $cashoutRequests = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);

        // Attach the current query string to the pagination links to maintain state
        $cashoutRequests->appends($request->except('page'));

        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $cashoutRequests->lastPage();
        // This array will be passed to the view for generating the "go-to" dropdown options
        $pageRange = range(1, $totalPages);

        // Pass necessary data to the view
        return view('admin.agent_cashout', [
            'cashoutRequests' => $cashoutRequests,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }



    public function approveCashoutRequest(Request $request, $id)
    {
        $cashout = CashoutTransaction::findOrFail($id);
        $agent = Agent::where('agent_code', $cashout->agent_code)->firstOrFail();

        // Deduct the amount from the agent's pending cashout
        $agent->pending_cashout -= $cashout->total_amount;
        $agent->save();

        // Update the cashout transaction status
        $cashout->status = 'approved';
        $cashout->save();

        return redirect()->route('admin.agent_cashout')->with('success', 'Cashout approved successfully.');
    }

    public function rejectCashoutRequest(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $cashout = CashoutTransaction::findOrFail($id);
        $agent = Agent::where('agent_code', $cashout->agent_code)->firstOrFail();

        // Add the amount back to the agent's wallet balance
        $agent->agent_wallet_balance += $cashout->total_amount;
        // Deduct the amount from the agent's pending cashout
        $agent->pending_cashout -= $cashout->total_amount;
        $agent->save();

        // Update the cashout transaction status and add the rejection reason
        $cashout->status = 'rejected';
        $cashout->rejection_reason = $request->input('rejection_reason');
        $cashout->save();

        return redirect()->route('admin.agent_cashout')->with('success', 'Cashout rejected successfully.');
    }
}
