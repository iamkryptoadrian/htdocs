<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Db;
use Illuminate\Support\Facades\Cookie;
use App\Models\Package;
use App\Models\Room;
use App\Models\Service;
use App\Models\Booking;
use App\Models\BookingSetting;

class BookingStep1Controller extends Controller
{
    public function showSummary(Request $request)
    {
        // Retrieve booking data from cookie
        $bookingDataJson = $request->cookie('bookingData');

        // Check if booking data exists in cookies
        if (!$bookingDataJson) {
            // Redirect if no booking data is found in cookies
            return redirect()->route('search_results')->with('error','Booking Session Timeout');
        }

        // Decode the booking data from JSON format
        $bookingData = json_decode($bookingDataJson, true);

        // Fetch the package and room details from the database
        $package = Package::find($bookingData['package_id']);

        // without replacing the original package_id and select_room
        $bookingData['package_name'] = $package ? $package->package_name : 'Package not found';

        // Decode services data and extract the IDs
        $servicesData = json_decode($package->services, true);
        $serviceIds = collect($servicesData)->pluck('id')->all();

        // Inside the map function, log each service's details
        $includedServicesWithDetails = Service::whereIn('id', $serviceIds)
            ->get()
            ->map(function ($service) use ($servicesData) {
                $serviceData = collect($servicesData)->firstWhere('id', $service->id);
                $quantity = $serviceData['quantity'] ?? 0;
                return [
                    'name' => $service->service_name,
                    'quantity' => $quantity,
                ];
            });

        // Fetch add-on services
        $addonServicesData = json_decode($package->addon_services_available, true);
        $addonServiceIds = collect($addonServicesData)->pluck('id')->all();

        $addonServices = Service::whereIn('id', $addonServiceIds)->get()->map(function ($service) {
            return [
                'id' => $service->id,
                'service_name' => $service->service_name,
                'price' => $service->price,
                'image_path' => $service->image_path,
            ];
        });

        // Fetch all services
        $allServices = Service::all()->map(function ($service) {
            return [
                'id' => $service->id,
                'service_name' => $service->service_name,
                'price' => $service->price,
                'image_path' => $service->image_path,
            ];
        });

        // Pass the booking data and number of nights to the view
        return view('booking1', compact(
            'bookingData',
            'includedServicesWithDetails',
            'allServices',
            'addonServices',
        ));
    }

    public function roomsIndex(Request $request)
    {
        // Retrieve session data
        $sessionData = session('preBookingData');

        if (!$sessionData) {
            // Redirect if no booking data is found in cookies
            return redirect()->route('search_results')->with('error','Booking Session Timeout');
        }

        // Extract room and guest details from session data
        $roomGuestDetails = [];
        $totalRooms = $sessionData['no_of_rooms'];

        for ($i = 1; $i <= $totalRooms; $i++) {
            $totalGuests = (int)$sessionData["room_{$i}_adults"] +
                           (int)$sessionData["room_{$i}_children"] +
                           (int)$sessionData["room_{$i}_kids"] +
                           (int)$sessionData["room_{$i}_toddlers"];
                           //to enable count of toddlers in total guest

            $roomGuestDetails[$i] = $totalGuests;
        }

        // Fetch the package details and decode the rooms column
        $package = Package::findOrFail($sessionData['package_id']);
        $rooms = json_decode($package->rooms, true);

        // Fetch available rooms for each room guest requirement
        $availableRooms = [];
        foreach ($roomGuestDetails as $roomNumber => $guests) {
            $suitableRooms = [];
            foreach ($rooms as $room) {
                if (array_key_exists("price_for_$guests", $room['prices'])) {
                    $roomModel = Room::find($room['id']);
                    if ($roomModel) {
                        $roomModel->price = $room['prices']["price_for_$guests"];
                        $suitableRooms[] = $roomModel;
                    }
                }
            }
            $availableRooms[$roomNumber] = $suitableRooms;
        }

        // Parsing the check-in and check-out dates
        $checkInCheckOut = explode(' to ', $sessionData['check_in_check_out']);
        $checkIn = new \DateTime($checkInCheckOut[0]);
        $checkOut = new \DateTime($checkInCheckOut[1]);
        $difference = $checkIn->diff($checkOut);
        $nights = $difference->days;

        $bookingSettings = BookingSetting::first();

        // Pass data to the view
        return view('booking_rooms', compact('availableRooms', 'totalRooms', 'sessionData', 'nights', 'bookingSettings'));
    }

    public function preRoomSelection(Request $request)
    {
        //Log::info('preRoomSelection request data:', $request->all());

        // Validate the initial data
        $validatedData = $request->validate([
            'check_in_check_out' => 'required|string',
            'package_id' => 'required|exists:packages,id',
            'no_of_rooms' => 'required|integer|min:1',
        ]);

        // Generate dynamic validation rules for each room
        $roomValidationRules = [];
        $noOfRooms = $request->input('no_of_rooms');

        for ($i = 1; $i <= $noOfRooms; $i++) {
            $roomValidationRules["room_{$i}_adults"] = 'required|integer|min:1';
            $roomValidationRules["room_{$i}_children"] = 'nullable|integer|min:0';
            $roomValidationRules["room_{$i}_kids"] = 'nullable|integer|min:0';
            $roomValidationRules["room_{$i}_toddlers"] = 'nullable|integer|min:0';
        }

        // Validate the room-specific data
        $validatedRoomData = $request->validate($roomValidationRules);

        // Merge the initial validated data with the validated room-specific data
        $validatedData = array_merge($validatedData, $validatedRoomData);

        // Store the validated data in the session
        session(['preBookingData' => $validatedData]);

        // Redirect to the room selection page
        return redirect()->route('booking.roomsIndex');
    }

    public function store(Request $request)
    {
        // Log all the incoming request data
        //Log::info('Store request data:', $request->all());

        // Basic validation
        $basicValidationRules = [
            'check_in_check_out' => 'required|string',
            'package_id' => 'required|exists:packages,id',
            'no_of_rooms' => 'required|integer|min:1',
            'no_of_nights' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
        ];

        // Dynamic validation rules
        $dynamicValidationRules = [];
        $noOfRooms = $request->input('no_of_rooms');

        for ($i = 1; $i <= $noOfRooms; $i++) {
            $dynamicValidationRules["room_{$i}"] = 'required|integer|exists:rooms,id';
            $dynamicValidationRules["room_{$i}_price"] = 'required|numeric';
            $dynamicValidationRules["room_{$i}_name"] = 'required|string';
            $dynamicValidationRules["room_{$i}_adults"] = 'required|integer|min:1';
            $dynamicValidationRules["room_{$i}_children"] = 'nullable|integer|min:0';
            $dynamicValidationRules["room_{$i}_kids"] = 'nullable|integer|min:0';
            $dynamicValidationRules["room_{$i}_toddlers"] = 'nullable|integer|min:0';
        }

        // Combine basic and dynamic validation rules
        $validationRules = array_merge($basicValidationRules, $dynamicValidationRules);

        // Validate the incoming request data
        $validatedData = $request->validate($validationRules);

        // Generate a unique booking ID
        $bookingId = $this->generateUniqueBookingId();

        // Add the booking ID to the validated data array
        $validatedData['booking_id'] = $bookingId;

        // Convert the validated data array, including the booking ID and room details, to a JSON string
        $bookingDataJson = json_encode($validatedData);

        // Create a cookie that expires in 10 minutes with the booking data
        $cookie = cookie('bookingData', $bookingDataJson, 10);

        // Clear the session data
        session()->forget('preBookingData');

        // Redirect to the booking summary page with the cookie attached
        return redirect()->route('booking.summary')->cookie($cookie);
    }

    protected function generateUniqueBookingId()
    {
        $prefix = 'ROCK';
        $lastBooking = Booking::orderBy('created_at', 'desc')->first();

        if ($lastBooking && preg_match('/^ROCK(\d+)$/', $lastBooking->booking_id, $matches)) {
            $number = (int) $matches[1] + 1;
        } else {
            $number = 1;
        }

        $newBookingId = $prefix . sprintf('%03d', $number);

        // Ensure uniqueness
        while (Booking::where('booking_id', $newBookingId)->exists()) {
            $number++;
            $newBookingId = $prefix . sprintf('%03d', $number);
        }

        return $newBookingId;
    }

}
