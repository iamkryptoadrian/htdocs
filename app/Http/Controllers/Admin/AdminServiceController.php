<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Validation\ValidationException;

class AdminServiceController extends Controller
{
    // Display a list of services
    public function index(Request $request)
    {
        // Default values
        $recordsPerPage = $request->query('show', 20);
        $sortOrder = $request->query('order', 'DESC');
        $sortBy = $request->query('sortBy', 'created_at');
        $searchTerm = $request->query('search');

        // Validate sortOrder to prevent SQL injection or errors
        $sortOrder = $sortOrder === 'ASC' ? 'ASC' : 'DESC';

        // Start the query
        $query = Service::query();

        // Apply search term if provided
        if ($searchTerm) {
            $query->where('service_name', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%");
        }

        // Retrieve services with pagination and sorting
        $services = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);

        // Attach the current query string to the pagination links to maintain state
        $services->appends($request->except('page'));

        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $services->lastPage();
        // This array will be passed to the view for generating the "go-to" dropdown options
        $pageRange = range(1, $totalPages);

        // Pass necessary data to the view
        return view('admin.services.index', [
            'services' => $services,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }


    // Store a newly created service in the database
    public function store(Request $request)
    {
        try {
            // Adjust the allowed_selection value before validation
            $allowedSelection = $request->has('allowed_selection') && $request->input('allowed_selection') === 'on' ? true : false;
    
            // Merge the adjusted allowed_selection value into the request
            $validatedData = $request->merge([
                'allowed_selection' => $allowedSelection,
            ])->validate([
                'service_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'image_path' => 'nullable|file|image|max:5120|mimes:jpg,jpeg,png,svg',
                'allowed_selection' => 'boolean',
            ]);
    
            // Create a new service instance with validated data
            $service = new Service([
                'service_name' => $validatedData['service_name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'allowed_selection' => $validatedData['allowed_selection'], // This will now be a boolean
            ]);
    
            // Handle the image upload if a file was provided
            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                $path = $file->store('service_images', 'public');
                $service->image_path = $path;
            }
    
            // Save the new service to the database
            $service->save();
    
            // Redirect back to the services index with a success message
            return Redirect::route('admin.services.index')->with('success', 'Service created successfully.');
    
        } catch (ValidationException $e) {
            // If validation fails, redirect back with errors
            return redirect()->back()->withErrors($e->errors())->withInput();
    
        } catch (\Exception $e) {
            // Handle any other exceptions and redirect back with an error message
            \Log::error($e->getMessage());
            return back()->withErrors($e->getMessage())->withInput();
        }
    }    


    // Update the specified service in the database
    public function update(Request $request, $service_id)
    {
        try {
            // Fetch the service model by ID
            $service = Service::findOrFail($service_id);
    
            // Adjust the allowed_selection value before validation
            $allowedSelection = $request->has('allowed_selection') && $request->input('allowed_selection') === 'on' ? true : false;
    
            // Merge the adjusted allowed_selection value into the request
            $validatedData = $request->merge([
                'allowed_selection' => $allowedSelection,
            ])->validate([
                'service_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'image_path' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:5120',
                'allowed_selection' => 'boolean',
            ]);
    
            // Handle the image file if it's provided
            if ($request->hasFile('image_path')) {
                // Optionally, delete the old image file from storage
                Storage::delete($service->image_path);
                $filePath = $request->file('image_path')->store('service_images', 'public');
                $validatedData['image_path'] = $filePath;
            }
    
            // Update the service model with validated data
            $service->update($validatedData);
    
            // Redirect back to the services index with a success message
            return Redirect::route('admin.services.index')->with('success', 'Service updated successfully.');
    
        } catch (ValidationException $e) {
            // If validation fails, redirect back with errors
            return redirect()->back()->withErrors($e->errors())->withInput();
    
        } catch (\Exception $e) {
            // Handle any other exceptions and redirect back with an error message
            \Log::error($e->getMessage());
            return back()->withErrors('An error occurred while updating the service. Please try again.')->withInput();
        }
    }
    

    // Remove the specified service from the database
    public function destroy($service_id)
    {
        $service = Service::findOrFail($service_id);

        // Check if the service has an image_path and delete the image from storage
        if ($service->image_path) {
            Storage::delete($service->image_path);
        }

        // Delete the service from the database
        $service->delete();

        // Redirect back to the services index with a success message
        return Redirect::route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
