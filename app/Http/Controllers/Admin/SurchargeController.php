<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surcharge;

class SurchargeController extends Controller
{
    public function index(Request $request)
    {
        // Default values for pagination, sorting, and searching
        $recordsPerPage = $request->query('show', 20);
        $sortOrder = $request->query('order', 'DESC');
        $sortBy = $request->query('sortBy', 'created_at');
        $searchTerm = $request->query('search');

        // Validate sortOrder to prevent SQL injection or errors
        $sortOrder = $sortOrder === 'ASC' ? 'ASC' : 'DESC';

        // Start the query
        $query = Surcharge::query();

        // Apply search term if provided
        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%")
                  ->orWhere('amount', 'like', "%{$searchTerm}%");
        }

        // Retrieve surcharges with pagination and sorting
        $surcharges = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);

        // Attach the current query string to the pagination links to maintain state
        $surcharges->appends($request->except('page'));

        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $surcharges->lastPage();
        $pageRange = range(1, $totalPages);

        // Pass necessary data to the view
        return view('admin.surcharge', [
            'surcharges' => $surcharges,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'days_of_week' => 'nullable|array', // Validate as array
            'days_of_week.*' => 'required|integer|between:0,6', // Validate each day of the week as integer between 0 and 6
            'surcharge_type' => 'required|in:date-based,weekly',
            'is_active' => 'required|boolean',
        ]);

        try {
            // Convert days_of_week array to JSON before storing
            $daysOfWeek = $request->has('days_of_week') ? json_encode($request->days_of_week) : null;

            $surcharge = new Surcharge();
            $surcharge->name = $request->name;
            $surcharge->amount = $request->amount;
            $surcharge->start_date = $request->start_date;
            $surcharge->end_date = $request->end_date;
            $surcharge->days_of_week = $daysOfWeek; // Store as JSON string
            $surcharge->surcharge_type = $request->surcharge_type;
            $surcharge->is_active = $request->is_active;
            $surcharge->save();

            return redirect()->route('admin.surcharge.index')->with('success', 'Surcharge added successfully.');
        } catch (\Exception $e) {
            \Log::error('Error adding surcharge:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function update(Request $request, Surcharge $surcharge)
    {
        \Log::info('Incoming Surcharge Update Request:', $request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            // Here we make sure days_of_week is an array of strings and map them to integers
            'days_of_week' => 'nullable|array',
            'days_of_week.*' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'surcharge_type' => 'required|in:date-based,weekly',
            'is_active' => 'required|boolean',
        ]);

        try {
            // Convert day names to their respective integer values
            $daysOfWeekIntegers = array_map(function($day) {
                return date('w', strtotime($day)); // 'Sunday' becomes 0, 'Monday' becomes 1, etc.
            }, $request->days_of_week ?? []);

            $surcharge->fill($validatedData);
            // We store days_of_week as JSON after converting to integers
            $surcharge->days_of_week = json_encode($daysOfWeekIntegers);
            $surcharge->save();

            return redirect()->route('admin.surcharge.index')->with('success', 'Surcharge updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating surcharge:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        }



    public function destroy(Surcharge $surcharge)
    {
        $surcharge->delete();
        return redirect()->route('admin.surcharge.index')->with('success', 'Surcharge Deleted successfully.');;
    }
}
