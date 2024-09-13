<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Surcharge;
use Illuminate\Support\Carbon;
use App\Models\Package;
use App\Models\BookingSetting;
use Stripe\ApiOperations\All;


class BookingStep2Controller extends Controller
{
    public function index()
    {
        // Retrieve the cookie
        $bookingDataJson = Cookie::get('bookingData2');
        if (!$bookingDataJson) {
            return redirect()->route('search_results')->with('error', 'Please start your booking again.');
        }

        // Decode the JSON data to an array
        $bookingData2 = json_decode($bookingDataJson, true);

        if (empty($bookingData2['check_in_check_out'])) {
            return redirect()->route('search_results')->with('error', 'Please provide check-in and check-out dates.');
        }

        [$checkInDateStr, $checkOutDateStr] = explode(' to ', $bookingData2['check_in_check_out']);
        $checkInDate = Carbon::createFromFormat('Y-m-d', trim($checkInDateStr));
        $checkOutDate = Carbon::createFromFormat('Y-m-d', trim($checkOutDateStr));

        if (!$checkInDate || !$checkOutDate) {
            return redirect()->route('search_results')->with('error', 'Invalid check-in or check-out dates.');
        }

        $dateBasedSurcharges = Surcharge::where('surcharge_type', 'date-based')
            ->where('start_date', '<=', $checkInDate)
            ->where('end_date', '>=', $checkOutDate)
            ->where('is_active', true)
            ->get();

        $dayOfWeek = $checkInDate->dayOfWeek;

        $weeklySurcharges = Surcharge::where('surcharge_type', 'weekly')
            ->where('days_of_week', 'LIKE', '%'.$dayOfWeek.'%')
            ->where('is_active', true)
            ->get();

        $totalSurchargeAmount = $dateBasedSurcharges->sum('amount') + $weeklySurcharges->sum('amount');

        $familyMembers = [];
        if (auth()->check()) {
            $familyMembers = auth()->user()->familyMembers;
        }

        // Fetch the marine fee based on the package ID
        $packageId = $bookingData2['package_id'] ?? null;
        $marineFee = 0;
        $taxAmount = 0;
        $serviceFees = 0;
        if ($packageId) {
            $package = Package::find($packageId);
            if ($package) {
                $marineFee = $package->marine_charges;
                $taxAmount = $package->tax;
                $serviceFees = $package->service_charge;
            }
        }

        $bookingSetting = BookingSetting::first();
        $adultAge = $bookingSetting->adult_age;
        $childrenAge = $bookingSetting->children_age;
        $kidsAge = $bookingSetting->kids_age;
        $toddlerAge = $bookingSetting->Toddlers_age;

        return view('booking2', [
            'bookingData2' => $bookingData2,
            'familyMembers' => $familyMembers,
            'marineFee' => $marineFee,
            'taxAmount' => $taxAmount,
            'adultAge' => $adultAge,
            'childrenAge' => $childrenAge,
            'kidsAge' => $kidsAge,
            'toddlerAge' => $toddlerAge,
            'serviceFees' => $serviceFees,
            'surcharges' => [
                'dateBasedSurcharges' => $dateBasedSurcharges,
                'weeklySurcharges' => $weeklySurcharges,
                'totalSurchargeAmount' => $totalSurchargeAmount
            ]
        ]);
    }

    public function store(Request $request)
    {
        // Log the incoming request data
        //Log::info('Booking Step 1 Data:', $request->all());

        // Basic validation for always-required fields
        $validatedData = $request->validate([
            'nights' => 'required|integer|min:1',
            'check_in_check_out' => 'required|string',
            'package_name' => 'required|string',
            'package_id' => 'required|exists:packages,id',
            'no_of_rooms' => 'required|integer|min:1',
            'total_night_charges' => 'required|numeric',
            'booking_id' => 'required|string',
            'additional_services_total' => 'required',
        ]);

        // Validate included services
        $includedServices = $request->input('included_services', []);
        foreach ($includedServices as $index => $service) {
            $request->validate([
                "included_services.$index.name" => 'required|string',
                "included_services.$index.quantity" => 'required|integer|min:1',
            ]);
        }

        // Validate selected additional services
        $selectedServices = $request->input('additional_services', []);
        foreach ($selectedServices as $index => $service) {
            if (isset($service['selected']) && $service['selected'] == 'on') {
                $request->validate([
                    "additional_services.$index.id" => 'required|integer|exists:services,id',
                    "additional_services.$index.name" => 'required|string',
                    "additional_services.$index.price" => 'required|numeric',
                    "additional_services.$index.quantity" => 'required|integer|min:1',
                ]);
            }
        }

        // Process included services
        $includedServices = collect($includedServices)
            ->mapWithKeys(function ($service, $index) {
                return [
                    $index => [
                        'name' => $service['name'],
                        'quantity' => $service['quantity'],
                    ],
                ];
            })
            ->all();

        // Extract and process only the selected additional services
        $selectedServices = collect($selectedServices)
            ->reject(function ($service) {
                // Reject services that are not selected
                return empty($service['selected']) || $service['selected'] !== 'on';
            })
            ->mapWithKeys(function ($service) {
                // Remove the 'selected' key and keep only necessary details
                return [
                    $service['id'] => [
                        'name' => $service['name'],
                        'quantity' => $service['quantity'],
                        'price' => $service['price'],
                        'id' => $service['id'],
                    ],
                ];
            })
            ->all();

        // Prepare the rest of the booking data
        $newBookingData = [
            'included_services' => $includedServices,
            'nights' => $request->nights,
            'total_night_charges' => $request->total_night_charges,
            'check_in_check_out' => $request->check_in_check_out,
            'package_name' => $request->package_name,
            'package_id' => $request->package_id,
            'no_of_rooms' => $request->no_of_rooms,
            'total_price' => $request->total_night_charges,
            'booking_id' => $request->booking_id,
            'additional_services_total' => $request->additional_services_total,
        ];

        for ($i = 1; $i <= $request->no_of_rooms; $i++) {
            $newBookingData["room_{$i}"] = $request->input("room_{$i}");
            $newBookingData["room_{$i}_price"] = $request->input("room_{$i}_price");
            $newBookingData["room_{$i}_name"] = $request->input("room_{$i}_name");
            $newBookingData["room_{$i}_adults"] = $request->input("room_{$i}_adults");
            $newBookingData["room_{$i}_children"] = $request->input("room_{$i}_children");
            $newBookingData["room_{$i}_kids"] = $request->input("room_{$i}_kids");
            $newBookingData["room_{$i}_toddlers"] = $request->input("room_{$i}_toddlers");
        }

        // Add additional services to the booking data
        $newBookingData['additional_services'] = $selectedServices;

        // Serialize the data to JSON for storing in a cookie
        $bookingData2 = json_encode($newBookingData);

        // Create a cookie that lasts for a specified duration
        $cookie = cookie('bookingData2', $bookingData2, 60);

        return redirect()->route('booking.step2')->withCookie($cookie);
    }

    // Inside BookingStep2Controller
    public function addGuest(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Define validation rules for a single guest, not an array of guests
        $validator = Validator::make($request->all(), [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'phone'          => 'nullable|numeric',
            'email'          => 'nullable|email',
            'date_of_birth'  => 'required|date',
            'id_passport_number' => 'nullable|string',
            'street_address' => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'state'          => 'required|string|max:255',
            'zip'            => 'required|string|max:255',
            'country'        => 'required|string|max:255',
        ]);

        // Check validation
        if ($validator->fails()) {
            // Return validation errors as JSON
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new family member and fill the details
        $familyMember = new FamilyMember([
            'user_id'        => $user->id,
            'first_name'     => $request->input('first_name'),
            'last_name'      => $request->input('last_name'),
            'phone_number'   => $request->input('phone'),
            'email'          => $request->input('email'),
            'date_of_birth'  => $request->input('date_of_birth'),
            'id_number'      => $request->input('id_passport_number'),
            'street_address' => $request->input('street_address'),
            'city'           => $request->input('city'),
            'state'          => $request->input('state'),
            'zip_code'       => $request->input('zip'),
            'country'        => $request->input('country'),
        ]);

        // Save the new family member to the database
        $familyMember->save();

        // Return success response as JSON with the family member data
        return response()->json([
            'success' => true,
            'message' => 'Guest added successfully',
            'familyMember' => [
                'id' => $familyMember->id,
                'first_name' => $familyMember->first_name,
                'last_name' => $familyMember->last_name,
                'age' => \Carbon\Carbon::parse($familyMember->date_of_birth)->age, // Assuming date_of_birth is a Carbon instance
                'date_of_birth' => $familyMember->date_of_birth,
            ],
        ]);
    }

    public function finalize(Request $request)
    {
        // Your existing logic to prepare $FinalBookingData...
        $requestData = $request->except('_token');
        $bookingData2 = $request->cookie('bookingData2');
        $FinalBookingData = [
            'requestData' => $requestData,
            'cookieData' => null,
        ];

        if ($bookingData2) {
            $bookingDataArray = json_decode($bookingData2, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $FinalBookingData['cookieData'] = $bookingDataArray;
            } else {
                Log::error('JSON decoding error:', ['error' => json_last_error_msg()]);
                $FinalBookingData['cookieDataRaw'] = $bookingData2;
            }
        }

        // Serialize the FinalBookingData
        $finalBookingDataJson = json_encode($FinalBookingData);

        // Create a cookie that expires in 15 minutes
        $cookie = cookie('FinalBookingData', $finalBookingDataJson, 15);

        // Attach the cookie to the response
        return redirect()->route('booking.step3')->withCookie($cookie)->with([
            'FinalBookingData' => $FinalBookingData,
        ]);
    }

}
