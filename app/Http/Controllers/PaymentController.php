<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Models\BookingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\FamilyMember;
use App\Models\GeneralSetting;
use App\Models\AgentTransaction;
use Carbon\Carbon;


class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {

        // Retrieve and decode the booking data from the cookie
        $bookingDataJson = $request->cookie('FinalBookingData');
        $bookingData = json_decode($bookingDataJson, true);

        if (!$bookingData) {
            Log::error('Booking data not found in the cookie.');
            return redirect()->back()->withErrors('error', 'Booking data is missing. Please start your booking process again.');
        }

        // Manually merge the cookie data into the request data
        $requestData = array_merge($request->all(), $bookingData['requestData'], $bookingData['cookieData']);

        // Log the merged request data
        //Log::info('Merged request data:', $requestData);

        $rules = [
            'netTotal' => 'required|numeric',
            'packageName' => 'required|string',
            'agent_code' => 'nullable|string',
            'mainGuest' => 'required|integer',
            'selectedFamilyMembers' => 'required|array|min:1',
            'packageCharges' => 'required|numeric',
            'couponCode' => 'nullable|string',
            'couponDiscount' => 'nullable|numeric',
            'additionalServicesTotal' => 'nullable|numeric',
            'marineFee' => 'required|numeric',
            'totalSurchargeAmount' => 'required|numeric',
            'subTotal' => 'required|numeric',
            'serviceCharge' => 'required|numeric',
            'tax' => 'required|numeric',
            'included_services' => 'required|array',
            'included_services.*.name' => 'required|string',
            'included_services.*.quantity' => 'required|integer|min:1',
            'additional_services' => 'nullable|array',
            'additional_services.*.id' => 'required|integer|exists:services,id',
            'additional_services.*.name' => 'required|string',
            'additional_services.*.price' => 'required|numeric',
            'additional_services.*.quantity' => 'required|integer|min:1',
            'nights' => 'required|integer|min:1',
            'total_night_charges' => 'required|numeric',
            'check_in_check_out' => 'required|string',
            'package_name' => 'required|string',
            'package_id' => 'required|integer|exists:packages,id',
            'no_of_rooms' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
            'booking_id' => 'required|string',
        ];

        // Conditionally add rules for activity_assignment if it exists in the request data
        if (isset($requestData['activity_assignment'])) {
            $rules['activity_assignment'] = 'array';
            $rules['activity_assignment.*.*.guest'] = 'integer|exists:family_members,id';
            $rules['activity_assignment.*.*.quantity'] = 'integer|min:0';
        }


        for ($i = 1; $i <= $requestData['no_of_rooms']; $i++) {
            $rules["room_{$i}"] = 'required|integer|exists:rooms,id';
            $rules["room_{$i}_price"] = 'required|numeric';
            $rules["room_{$i}_name"] = 'required|string';
            $rules["room_{$i}_adults"] = 'required|integer|min:0';
            $rules["room_{$i}_children"] = 'required|integer|min:0';
            $rules["room_{$i}_kids"] = 'required|integer|min:0';
            $rules["room_{$i}_toddlers"] = 'required|integer|min:0';
        }

        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            Log::info('Validation errors:', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $validatedData = $validator->validated();

        $validatedData['couponCode'] = $validatedData['couponCode'] ?? '';
        $validatedData['couponDiscount'] = $validatedData['couponDiscount'] ?? 0;

        $mainGuestId = $validatedData['mainGuest'];

        // Fetch the main guest details from the family_members table
        $mainGuest = FamilyMember::find($mainGuestId);

        if (!$mainGuest) {
            Log::error('Main guest not found with ID: ' . $mainGuestId);
            return redirect()->back()->withErrors('Main guest not found.')->withInput();
        }

        // Extract check-in and check-out dates from the request
        [$checkIn, $checkOut] = explode(' to ', $validatedData['check_in_check_out']);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create a Stripe Checkout Session first to get the transaction ID
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'myr',
                        'product_data' => [
                            'name' => $validatedData['packageName'] . ' Package Booking',
                        ],
                        'unit_amount' => round($validatedData['netTotal'] * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?booking_id=' . urlencode($validatedData['booking_id']),
                'cancel_url' => route('payment.failure') . '?booking_id=' . urlencode($validatedData['booking_id']),
                'metadata' => [
                    'booking_id' => $validatedData['booking_id'],
                ],
            ]);

            // Collect room details
            $roomsDetails = [];
            $roomGuestDetails = [];
            for ($i = 1; $i <= $validatedData['no_of_rooms']; $i++) {
                $roomsDetails[] = [
                    'room_id' => $validatedData["room_{$i}"],
                    'room_name' => $validatedData["room_{$i}_name"],
                    'room_price' => $validatedData["room_{$i}_price"],
                ];
                $roomGuestDetails[] = [
                    "room_{$i}_adults" => $validatedData["room_{$i}_adults"],
                    "room_{$i}_children" => $validatedData["room_{$i}_children"],
                    "room_{$i}_kids" => $validatedData["room_{$i}_kids"],
                    "room_{$i}_toddlers" => $validatedData["room_{$i}_toddlers"],
                ];
            }


            $agentCommissionPercentage = GeneralSetting::first()->agent_commission;

            // Calculate agent commission
            $netTotal = $validatedData['netTotal'];
            $agentCommission = ($agentCommissionPercentage / 100) * $netTotal;

            // Now create or update the booking with all details including the transaction_id
            $booking = Booking::updateOrCreate(
                ['booking_id' => $validatedData['booking_id']],
                [
                    'user_id' => Auth::id(),
                    'package_id' => $validatedData['package_id'],
                    'package_name' => $validatedData['packageName'],
                    'rooms_details' => json_encode($roomsDetails), // Save room details as JSON
                    'no_of_rooms' => $validatedData['no_of_rooms'],
                    'room_guest_details' => json_encode($roomGuestDetails), // Save room guest details as JSON
                    'check_in_date' => $checkIn,
                    'check_out_date' => $checkOut,
                    'coupon_code' => $validatedData['couponCode'],
                    'discount_amt' => $validatedData['couponDiscount'],
                    'package_charges' => $validatedData['packageCharges'],
                    'main_guest_id' => $mainGuestId,
                    'main_guest_first_name' => $mainGuest->first_name,
                    'main_guest_last_name' => $mainGuest->last_name,
                    'main_guest_email' => $mainGuest->email,
                    'main_guest_phone_number' => $mainGuest->phone_number,
                    'additional_services_total' => $validatedData['additionalServicesTotal'] ?? 0.00,
                    'marine_fee' => $validatedData['marineFee'],
                    'total_surcharge_amount' => $validatedData['totalSurchargeAmount'],
                    'sub_total' => $validatedData['subTotal'],
                    'service_charge' => $validatedData['serviceCharge'],
                    'tax' => $validatedData['tax'],
                    'net_total' => $validatedData['netTotal'],
                    'included_services' => json_encode($validatedData['included_services']),
                    'additional_services' => json_encode($validatedData['additional_services']),
                    'selected_family_members' => json_encode($validatedData['selectedFamilyMembers']),
                    'booking_status' => 'Pending For Payment',
                    'payment_status' => 'Pending',
                    'stripe_session_id' => $session->id,                    
                    'activity_assignment' => isset($validatedData['activity_assignment']) ? json_encode($validatedData['activity_assignment']) : null,
                    'agent_code' => $validatedData['agent_code'],
                    'agent_commission' => $agentCommission,
                ]
            );

            if (!empty($validatedData['agent_code'])) {
                // Check if the transaction record exists for the same booking
                $transaction = AgentTransaction::firstOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'customer_name' => $mainGuest->first_name . ' ' . $mainGuest->last_name,
                        'commission_amount' => $agentCommission,
                        'commission_status' => 'pending',
                        'agent_code' => $validatedData['agent_code'],
                    ]
                );
            }
            

            // Redirect the user to the Stripe Checkout page
            return redirect()->away($session->url);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe API error: ' . $e->getMessage());
            return redirect()->back()->withErrors('error', 'Stripe API error: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General error during payment process: ' . $e->getMessage());
            return redirect()->back()->withErrors('error', 'An error occurred during payment processing. Please try again.');
        }
    }

    // Handle successful payment
    public function success(Request $request)
    {

        $bookingId = $request->query('booking_id');

        // Retrieve booking details from the database
        $booking = Booking::where('booking_id', $bookingId)->first();

        if (!$booking) {
            return redirect('/search_results')->with('error', 'Booking not found.');
        }


        // Calculate nights between check-in and check-out
        $checkInDate = new Carbon($booking->check_in_date);
        $checkOutDate = new Carbon($booking->check_out_date);
        $nights = $checkInDate->diffInDays($checkOutDate);

        // Now you can access the main_image from the related package
        $mainImage = $booking->package->main_image ?? null;

        $selectedMemberIds = $booking->selected_family_members ? json_decode($booking->selected_family_members, true) : [];

        // Initialize an empty array to store family member details
        $memberNames = [];

        // Check if there are any selected member IDs
        if (!empty($selectedMemberIds)) {
            // Convert the IDs to integers if they are stored as strings
            $selectedMemberIds = array_map('intval', $selectedMemberIds);

            // Fetch family members' details based on the selected IDs
            $selectedMembers = FamilyMember::whereIn('id', $selectedMemberIds)->get();

            // Prepare an array to hold details for easy access in the view
            foreach ($selectedMembers as $member) {
                $age = Carbon::parse($member->date_of_birth)->age;

                $memberNames[] = [
                    'firstName' => $member->first_name,
                    'lastName' => $member->last_name,
                    'age' => $age,
                ];
            }
        }

        $roomsDetails = json_decode($booking->rooms_details, true) ?? [];

        // Decode the room_guest_details JSON string into an array and calculate the totals
        $roomGuestDetails = json_decode($booking->room_guest_details, true) ?? [];
        $totalAdults = 0;
        $totalChildren = 0;
        $totalKids = 0;
        $totalToddlers = 0;

        foreach ($roomGuestDetails as $details) {
            foreach ($details as $key => $value) {
                if (strpos($key, 'adults') !== false) {
                    $totalAdults += (int)$value;
                } elseif (strpos($key, 'children') !== false) {
                    $totalChildren += (int)$value;
                } elseif (strpos($key, 'kids') !== false) {
                    $totalKids += (int)$value;
                } elseif (strpos($key, 'toddlers') !== false) {
                    $totalToddlers += (int)$value;
                }
            }
        }

        $totalGuests = $totalAdults + $totalChildren + $totalToddlers + $totalKids;

        // Check if the email has not been sent yet and the booking has a user
        if (!$booking->email_sent && $booking->user && $booking->user->email) {

            $email = new BookingConfirmation($booking, $nights, $mainImage, $memberNames, $roomsDetails, $totalAdults, $totalChildren, $totalToddlers, $totalKids, $totalGuests);
            Mail::to($booking->user->email)->queue($email);

            // Update the booking to mark the email as sent
            $booking->email_sent = true;
            $booking->save();
        }


        // Pass booking details and nights to the view
        return view('booking_success', compact('booking', 'nights', 'mainImage', 'memberNames', 'roomsDetails', 'totalAdults', 'totalChildren', 'totalToddlers', 'totalKids', 'totalGuests'));
    }

    // Handle failed payment
    public function failure(Request $request)
    {
        $bookingId = $request->query('booking_id');
        $booking = Booking::where('booking_id', $bookingId)->first();

        if ($booking) {
            // Check if the booking is already paid
            if ($booking->payment_status === 'Paid') {
                return redirect()->route('payment.success', ['booking_id' => $bookingId]);
            }

            // Update booking payment status to 'Failed' if not already paid
            $booking->update([
                'payment_status' => 'Failed',
                'booking_status' => 'cancelled'
            ]);

            // Check if the check-in date has passed
            $checkInDate = new Carbon($booking->check_in_date);
            $currentDate = Carbon::now()->toDateString();
            $canRetry = $currentDate <= $checkInDate->toDateString();
        } else {
            // Log the error and provide a message to the view if the booking is not found
            //Log::error("Failed to find booking with ID: {$bookingId}");
            $canRetry = false;
        }

        // Extract selected family member IDs, ensuring we have an array
        $selectedMemberIds = $booking->selected_family_members ?? '[]';
        $selectedMemberIds = json_decode($selectedMemberIds, true);

        // Check if the decoding results in an array
        if (!is_array($selectedMemberIds)) {
            Log::error("Failed to decode selectedMemberIds or not an array", ['selectedMemberIds' => $selectedMemberIds]);
            // Handle the error appropriately, maybe by returning or setting a default array
            $selectedMemberIds = [];
        }

        // Fetch family members' details based on the selected IDs
        $selectedMembers = FamilyMember::whereIn('id', $selectedMemberIds)->get();

        $Booking_settings = BookingSetting::first();
        $adultAge = $Booking_settings->adult_age;

        // Prepare an array to hold details for easy access in the view
        $memberNames = [];
        foreach ($selectedMembers as $member) {
            $age = Carbon::parse($member->date_of_birth)->age;

            $memberNames[$member->id] = [
                'id' => $member->id,
                'firstName' => $member->first_name,
                'lastName' => $member->last_name,
                'age' => $age,
            ];
        }

        $includedServices = json_decode($booking->included_services, true);
        $additionalServices = json_decode($booking->additional_services, true);

        // Decode room details and room guest details
        $roomDetails = json_decode($booking->rooms_details, true) ?? [];
        $roomGuestDetails = json_decode($booking->room_guest_details, true) ?? [];

        $rooms = [];
        foreach ($roomDetails as $index => $room) {
            $roomId = $room['room_id'];
            $guestDetails = array_filter($roomGuestDetails, function($guest) use ($roomId) {
                return strpos(array_keys($guest)[0], "room_{$roomId}_") !== false;
            });

            $guestDetails = array_values($guestDetails)[0] ?? [];

            $rooms[] = [
                'room_name' => $room['room_name'],
                'adults' => $guestDetails["room_{$roomId}_adults"] ?? 0,
                'children' => $guestDetails["room_{$roomId}_children"] ?? 0,
                'toddlers' => $guestDetails["room_{$roomId}_toddlers"] ?? 0,
                'kids' => $guestDetails["room_{$roomId}_kids"] ?? 0,
            ];
        }

        // Calculate totals
        $totalAdults = array_sum(array_column($rooms, 'adults'));
        $totalChildren = array_sum(array_column($rooms, 'children'));
        $totalToddlers = array_sum(array_column($rooms, 'toddlers'));
        $totalKids = array_sum(array_column($rooms, 'kids'));
        $totalGuests = $totalAdults + $totalChildren + $totalToddlers + $totalKids;



        // Retrieve the agent_code cookie if it exists
        $agentCode = $request->cookie('agent_code');

        // Pass the booking details and the prepared family members' details to the view
        return view('booking_failed', [
            'booking' => $booking,
            'memberNames' => $memberNames,
            'includedServices' => $includedServices,
            'additionalServices' => $additionalServices,
            'adultAge' => $adultAge,
            'canRetry' => $canRetry,
            'rooms' => $rooms,
            'totalGuests' => $totalGuests,
            'totalAdults' => $totalAdults,
            'totalChildren' => $totalChildren,
            'totalToddlers' => $totalToddlers,
            'totalKids' => $totalKids,
            'agentCode' => $agentCode,
        ])->with('error', 'Payment has been failed, Please try again');
    }

    public function resendConfirmation(Request $request, $bookingId)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please Login to your account.');
        }

        // Use the passed parameter directly
        $booking = Booking::where('booking_id', $bookingId)->first();

        if (!$booking || $booking->user_id !== Auth::id()) {
            return redirect('/')->with('error', 'You are not authorized to view this booking.');
        }

        $checkInDate = new Carbon($booking->check_in_date);
        $checkOutDate = new Carbon($booking->check_out_date);
        $nights = $checkInDate->diffInDays($checkOutDate);
        $mainImage = $booking->package->main_image ?? null;

        $selectedMemberIds = $booking->selected_family_members ? json_decode($booking->selected_family_members, true) : [];
        $memberNames = [];

        if (!empty($selectedMemberIds)) {
            $selectedMemberIds = array_map('intval', $selectedMemberIds);
            $selectedMembers = FamilyMember::whereIn('id', $selectedMemberIds)->get();
            foreach ($selectedMembers as $member) {
                $age = Carbon::parse($member->date_of_birth)->age;
                $memberNames[] = [
                    'firstName' => $member->first_name,
                    'lastName' => $member->last_name,
                    'age' => $age,
                ];
            }
        }

        $roomsDetails = json_decode($booking->rooms_details, true) ?? [];

        // Decode the room_guest_details JSON string into an array and calculate the totals
        $roomGuestDetails = json_decode($booking->room_guest_details, true) ?? [];
        $totalAdults = 0;
        $totalChildren = 0;
        $totalToddlers = 0;
        $totalKids = 0;

        foreach ($roomGuestDetails as $details) {
            foreach ($details as $key => $value) {
                if (strpos($key, 'adults') !== false) {
                    $totalAdults += (int)$value;
                } elseif (strpos($key, 'children') !== false) {
                    $totalChildren += (int)$value;
                } elseif (strpos($key, 'toddlers') !== false) {
                    $totalToddlers += (int)$value;
                } elseif (strpos($key, 'kids') !== false) {
                    $totalKids += (int)$value;
                }
            }
        }

        $totalGuests = 0;
        $totalGuests = $totalAdults + $totalChildren + $totalToddlers + $totalKids;

        //Log::info('Total guests: ' . $totalGuests);

        $email = new BookingConfirmation($booking, $nights, $mainImage, $memberNames, $roomsDetails, $totalAdults, $totalChildren, $totalToddlers, $totalKids, $totalGuests);

        Mail::to($booking->user->email)->queue($email);

        // Pass data to the view
        return redirect()->route('payment.success', ['booking_id' => $booking->booking_id])->with([
            'booking' => $booking,
            'nights' => $nights,
            'mainImage' => $mainImage,
            'memberNames' => $memberNames,
            'roomsDetails' => $roomsDetails,
            'totalAdults' => $totalAdults,
            'totalChildren' => $totalChildren,
            'totalToddlers' => $totalToddlers,
            'totalKids' => $totalKids,
            'totalGuests' => $totalGuests,
            'success' => 'Email Sent Successfully.'
        ]);
    }


}
