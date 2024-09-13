<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AgentTransactionController extends Controller
{
    public function index(Request $request)
    {
        // Get the logged-in agent
        $agent = Auth::guard('agent')->user();

        // Default values
        $recordsPerPage = $request->query('show', 20);
        $sortOrder = $request->query('order', 'ASC');
        $sortBy = $request->query('sortBy', 'created_at');
        $searchTerm = $request->query('search');

        // Validate sortOrder to prevent SQL injection or errors
        $sortOrder = $sortOrder === 'ASC' ? 'ASC' : 'DESC';

        // Start the query builder, do not execute get() yet
        $query = AgentTransaction::with('booking');

        // Apply search term if provided
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('customer_name', 'like', "%{$searchTerm}%")
                      ->orWhere('booking_id', 'like', "%{$searchTerm}%");
            });
        }

        // Retrieve transactions with pagination and sorting
        $transactions = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);

        // Attach the current query string to the pagination links to maintain state
        $transactions->appends($request->except('page'));

        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $transactions->lastPage();
        $pageRange = range(1, $totalPages);

        // Pass necessary data to the view
        return view('agent.commissions', [
            'transactions' => $transactions,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
            'agent' => $agent
        ]);
    }
}
