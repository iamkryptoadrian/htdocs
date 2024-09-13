<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class AdminPackageController extends Controller
{

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
        $query = Package::query();

        // Apply search term if provided
        if ($searchTerm) {
            $query->where('package_name', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%");
        }

        // Retrieve rooms with pagination and sorting
        $packages = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);


        // Attach the current query string to the pagination links to maintain state
        $packages->appends($request->except('page'));


        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $packages->lastPage();
        // This array will be passed to the view for generating the "go-to" dropdown options
        $pageRange = range(1, $totalPages);

        // Pass necessary data to the view
        return view('admin.packages.index', [
            'packages' => $packages,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function create()
    {
        $rooms = Room::all();
        $services = Service::all();
        return view('admin.packages.create', compact('rooms', 'services'));
    }


    public function edit($package_id)
    {
        try {
            // Find the package by its id or fail with a 404 response
            $package = Package::findOrFail($package_id);
            $rooms = Room::all();
            $services = Service::all();

            // Decode JSON fields to arrays for the form
            $durationArray = json_decode($package->duration, true);
            $roomsArray = json_decode($package->rooms, true);
            $servicesArray = json_decode($package->services, true);
            $addonServicesArray = json_decode($package->addon_services_available, true);

            // Prepare rooms and services data
            $selectedRooms = collect($roomsArray)->keyBy('id')->mapWithKeys(function ($item) {
                return [$item['id'] => $item['prices']];
            });

            $selectedServices = collect($servicesArray)->keyBy('id')->mapWithKeys(function ($item) {
                return [$item['id'] => ['quantity' => $item['quantity'] ?? 1]]; // Default quantity to 1 if not set
            });

            $selectedAddonServices = collect($addonServicesArray)->pluck('id')->all();

            // Retrieve all rooms and services, and mark selected ones
            $rooms = $rooms->map(function ($room) use ($selectedRooms) {
                $room->selected = $selectedRooms->has($room->id);
                $room->prices = $selectedRooms->has($room->id) ? $selectedRooms[$room->id] : [];
                return $room;
            });

            $services = $services->map(function ($service) use ($selectedServices) {
                $service->selected = $selectedServices->has($service->id);
                $service->quantity = $selectedServices->has($service->id) ? $selectedServices[$service->id]['quantity'] : 1; // Default to 1 if not set
                return $service;
            });

            // Display the edit form and pass the package and additional data
            return view('admin.packages.edit', compact('package', 'rooms', 'services', 'durationArray', 'selectedAddonServices'));
        } catch (\Exception $e) {
            Log::error('Error accessing the edit form for package: ' . $e->getMessage());
            return redirect()->route('admin.packages.index')->with('error', 'Error accessing the edit form.');
        }
    }



    // Store a newly created package in the database
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'package_name' => 'required|string|max:255',
                'duration.days.*' => 'required|integer|min:1',
                'duration.nights.*' => 'required|integer|min:1',
                'short_description' => 'required|string|max:255',
                'long_description' => 'required|string',
                'main_image' => 'required|image',
                'other_images.*' => 'image',
                'service_charge' => 'required|numeric',
                'tax' => 'required|numeric',
                'marine_charges' => 'required|numeric',
                'services.*.selected' => 'sometimes|accepted',
                'services.*.quantity' => 'required_with:services.*.selected|integer|min:1',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ', $e->errors());
            return back()->withErrors($e->validator)->withInput()->with('error', 'Validation failed. Please check the form and try again.');
        }

        try {
            $package = new Package();
            $package->package_name = $request->package_name;
            $package->short_description = $request->short_description;
            $package->long_description = $request->long_description;
            $package->marine_charges = $request->marine_charges;

            if ($request->hasFile('main_image')) {
                $package->main_image = $request->file('main_image')->store('package_images', 'public');
            }

            $images = [];
            if ($request->hasFile('other_images')) {
                foreach ($request->file('other_images') as $image) {
                    $images[] = $image->store('package_images', 'public');
                }
            }
            $package->other_images = json_encode($images);
            $package->service_charge = $request->service_charge;
            $package->tax = $request->tax;

            // Handling the durations
            $durationDays = $request->input('duration.days', []);
            $durationNights = $request->input('duration.nights', []);
            $durations = [];
            foreach ($durationDays as $index => $day) {
                if (isset($durationNights[$index])) {
                    $durations[] = ['days' => $day, 'nights' => $durationNights[$index]];
                }
            }
            $package->duration = json_encode($durations);

            // Processing rooms
            $roomsData = [];
            foreach ($request->input('rooms', []) as $id => $room) {
                if (isset($room['selected'])) {
                    $prices = [];
                    foreach ($room as $key => $value) {
                        if (strpos($key, 'price_for_') === 0 && $value !== null && $value !== '') {
                            $prices[$key] = $value;
                        }
                    }
                    if (!empty($prices)) {
                        $roomsData[] = [
                            'id' => $id,
                            'prices' => $prices
                        ];
                    }
                }
            }

            $servicesData = [];
            foreach ($request->input('services', []) as $id => $service) {
                if (isset($service['quantity'])) {
                    $servicesData[] = [
                        'id' => $id,
                        'quantity' => $service['quantity'],
                    ];
                }
            }

            // Processing add-on services
            $addonServices = [];
            $allServices = Service::all(); // Retrieve all services to find names
            foreach ($request->input('addon_services', []) as $serviceId) {
                $service = $allServices->firstWhere('id', $serviceId);
                if ($service) {
                    $addonServices[] = [
                        'id' => $serviceId,
                        'name' => $service->service_name,
                    ];
                }
            }

            $package->rooms = json_encode($roomsData);
            $package->services = json_encode($servicesData);
            $package->addon_services_available = json_encode($addonServices);

            // Find the lowest room price
            $lowestRoomPrice = collect($roomsData)->flatMap(function($room) {
                return array_values($room['prices']);
            })->min();

            // Set the initial package price as the lowest room price
            $package->package_initial_price = $lowestRoomPrice;

            $package->save();

            return redirect()->route('admin.packages.index')->with('success', 'Package added successfully.');
        } catch (\Exception $e) {
            Log::error('Error adding package: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error adding package.');
        }
    }




    // Update the specified package in the database
    public function update(Request $request, Package $package)
    {
        $mainValidationRules = [
            'package_name' => 'required|string|max:255',
            'duration.days.*' => 'required|integer|min:1',
            'duration.nights.*' => 'required|integer|min:1',
            'short_description' => 'required|string|max:255',
            'long_description' => 'required|string',
            'main_image' => 'sometimes|image',
            'other_images.*' => 'image',
            'service_charge' => 'required|numeric',
            'tax' => 'required|numeric',
            'marine_charges' => 'required|numeric',
            'services.*.selected' => 'sometimes|accepted',
            'services.*.quantity' => 'required_with:services.*.selected|integer|min:1',
        ];

        // Dynamically generate validation rules for selected rooms
        $roomValidationRules = [];
        foreach ($request->input('rooms', []) as $id => $room) {
            if (isset($room['selected']) && $room['selected'] === 'on') {
                for ($i = 1; $i <= 10; $i++) { // Assuming 10 is the maximum number of guests for any room
                    $roomValidationRules["rooms.$id.price_for_$i"] = 'nullable|numeric';
                }
            }
        }

        // Merge room validation rules with main validation rules and validate
        $validationRules = array_merge($mainValidationRules, $roomValidationRules);
        $request->validate($validationRules);

        try {
            $package->package_name = $request->package_name;
            $package->service_charge = $request->service_charge;
            $package->tax = $request->tax;
            $package->short_description = $request->short_description;
            $package->long_description = $request->long_description;
            $package->marine_charges = $request->marine_charges;

            // Handle main image upload
            if ($request->hasFile('main_image')) {
                Storage::delete($package->main_image);
                $package->main_image = $request->file('main_image')->store('package_images', 'public');
            }

            // Handle other images upload and append to existing ones
            $existingImages = $package->other_images ? json_decode($package->other_images, true) : [];
            if ($request->hasFile('other_images')) {
                foreach ($request->file('other_images') as $image) {
                    $existingImages[] = $image->store('package_images', 'public');
                }
                $package->other_images = json_encode($existingImages);
            }

            // Set initial package price based on the lowest room price
            $initialPrices = [];
            foreach ($request->input('rooms', []) as $id => $room) {
                for ($i = 1; $i <= 10; $i++) {
                    if (!empty($room["price_for_$i"])) {
                        $initialPrices[] = $room["price_for_$i"];
                    }
                }
            }
            $package->package_initial_price = !empty($initialPrices) ? min($initialPrices) : 0;

            // Handle Durations
            $durations = collect($request->input('duration.days', []))
                ->zip($request->input('duration.nights', []))
                ->map(function ($pair) {
                    return ['days' => $pair[0], 'nights' => $pair[1]];
                })->all();
            $package->duration = json_encode($durations);

            // Processing rooms and services
            $roomsData = [];
            foreach ($request->input('rooms', []) as $id => $room) {
                if (isset($room['selected']) && $room['selected'] === 'on') {
                    $prices = [];
                    for ($i = 1; $i <= 10; $i++) {
                        if (!empty($room["price_for_$i"])) {
                            $prices["price_for_$i"] = $room["price_for_$i"];
                        }
                    }
                    if (!empty($prices)) {
                        $roomsData[] = [
                            'id' => $id,
                            'prices' => $prices,
                        ];
                    }
                }
            }

            $servicesData = [];
            foreach ($request->input('services', []) as $id => $service) {
                if (isset($service['quantity'])) {
                    $servicesData[] = [
                        'id' => $id,
                        'quantity' => $service['quantity'],
                    ];
                }
            }

            // Processing add-on services
            $addonServices = [];
            $allServices = Service::all(); // Retrieve all services to find names
            foreach ($request->input('addon_services', []) as $serviceId) {
                $service = $allServices->firstWhere('id', $serviceId);
                if ($service) {
                    $addonServices[] = [
                        'id' => $serviceId,
                        'name' => $service->service_name,
                    ];
                }
            }

            $package->rooms = json_encode($roomsData);
            $package->services = json_encode($servicesData);
            $package->addon_services_available = json_encode($addonServices);

            $package->save();

            return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
        } catch (\Exception $e) {
            Log::error("Error updating package: {$e->getMessage()}");
            return back()->withInput()->with('error', "Error updating package: {$e->getMessage()}");
        }
    }



    // Remove the specified package from the database
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }

    public function deleteImage(Request $request, Package $package)
    {
        if ($package->main_image) {
            // Delete the image from storage
            Storage::delete($package->main_image);

            // Update the package's main_image column
            $package->main_image = null;
            $package->save();

            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }

    public function deleteOtherImage(Request $request, Package $package)
    {
        $index = $request->input('index');
        $otherImages = json_decode($package->other_images, true);

        if(isset($otherImages[$index])) {
            Storage::delete($otherImages[$index]);
            unset($otherImages[$index]);
            $package->other_images = json_encode(array_values($otherImages)); // Reindex array and save
            $package->save();

            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }

}
