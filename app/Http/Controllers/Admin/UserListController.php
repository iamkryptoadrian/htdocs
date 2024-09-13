<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Barryvdh\DomPDF\PDF;


class UserListController extends Controller
{

    // Display all users
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
        $query = User::query();
    
        // Apply search term if provided
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%")
                      ->orWhere('id', 'like', "%{$searchTerm}%");
            });
        }
    
        // Retrieve users with pagination and sorting
        $users = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);
    
        // Attach the current query string to the pagination links to maintain state
        $users->appends($request->except('page'));
    
        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $users->lastPage();
        // This array will be passed to the view for generating the "go-to" dropdown options
        $pageRange = range(1, $totalPages);
    
        // Pass necessary data to the view
        return view('admin.userlist', [
            'users' => $users,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }
    

    // Export Data (Excel)
    public function exportData(Request $request)
    {
        $query = User::query();

        // Apply filters if present
        if ($request->filter_field && $request->filter_value) {
            if ($request->filter_field == 'active_id') {
                $query->where('status', 1);
            } elseif ($request->filter_field == 'inactive_id') {
                $query->where('status', 0);
            } else {
                $query->where($request->filter_field, 'like', '%' . $request->filter_value . '%');
            }
            if ($request ->filter_field == 'IsActive') {
                $query->where('IsActive', 1);
            }
        }

        $users = $query->get(['name', 'account_id', 'email', 'status', 'sponsor_id', 'self_investment', 'IsActive']); // Specify only the columns you need

        // Export to Excel
        return Excel::download(new UsersExport($users), 'userlist.xlsx');
    }


    //BAN USER
    public function banUser(User $user)
    {
        if (Auth::guard('admin')->check()) {
            // The user is authenticated
            $adminUser = Auth::guard('admin')->user();

            // Check if the admin user has permission to ban/unban users (you can add your own logic here)

            // Update the user's status (toggle between 0 and 1)
            $user->update(['status' => $user->status === 1 ? 0 : 1]);

            // Return a success message based on the new status
            $message = $user->status === 1 ? 'User has been unbanned.' : 'User has been banned.';
            return redirect()->route('admin.userlist')->with('success', $message);
        } else {
            // The admin user is not authenticated, handle this case (e.g., redirect them to the login page)
            return redirect()->route('admin.login')->with('error', 'You must be logged in as an admin to perform this action.');
        }
    }

}
