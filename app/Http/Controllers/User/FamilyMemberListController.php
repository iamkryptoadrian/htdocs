<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyMemberListController extends Controller
{
    // Display family members of the logged-in user
    public function index(Request $request)
    {
        // Default values
        $recordsPerPage = $request->query('show', 20);
        $sortOrder = $request->query('order', 'ASC');
        $sortBy = $request->query('sortBy', 'created_at');
        $searchTerm = $request->query('search');
    
        // Validate sortOrder to prevent SQL injection or errors
        $sortOrder = $sortOrder === 'ASC' ? 'ASC' : 'DESC';
    
        // Start the query
        $query = FamilyMember::where('user_id', Auth::id());
    
        // Apply search term if provided
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', "%{$searchTerm}%")
                      ->orWhere('id', 'like', "%{$searchTerm}%");
            });
        }
    
        // Retrieve family members with pagination and sorting
        $members = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);
    
        // Attach the current query string to the pagination links to maintain state
        $members->appends($request->except('page'));
    
        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $members->lastPage();
        // This array will be passed to the view for generating the "go-to" dropdown options
        $pageRange = range(1, $totalPages);
    
        // Pass necessary data to the view
        return view('user.family.index', [
            'members' => $members,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }
    

    // Update family member details
    public function update(Request $request, FamilyMember $familyMember)
    {
        if ($familyMember->user_id !== Auth::id()) {
            abort(403);
        }
    
        // Validate input data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'date_of_birth' => 'nullable|date',
            'id_number' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);
    
        try {
            // Update family member details
            $familyMember->update($request->all());
            return redirect()->route('family.index')->with('success', 'Member Details updated successfully.');
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Failed to update family member: ' . $e->getMessage());
    
            // Return back to the form with an error message
            return back()->withErrors('An error occurred while updating the member details.')->withInput();
        }
    }

    public function destroy(FamilyMember $familyMember)
    {
        // Check if the family member belongs to the logged-in user
        if ($familyMember->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        try {
            // Attempt to delete the family member
            $familyMember->delete();
            return redirect()->route('family.index')->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error deleting family member: ' . $e->getMessage());
            // Redirect back with an error message
            return back()->with('error', 'Failed to delete the member.');
        }
    }
    
    
}
