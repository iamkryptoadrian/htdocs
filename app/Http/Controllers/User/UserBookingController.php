<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Models\AdultDocument;
use App\Models\BookingNote;
use App\Models\BookingSetting;
use App\Models\FamilyMember;
use App\Models\Package;
use App\Models\Service;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeCheckoutSession;

class UserBookingController extends Controller
{
    public function show($bookingId)
    {
        $statusClasses = [
            'Pending For Payment' => 'text-pending_payment',
            'confirmed'           => 'text-confirmed',
            'cancelled'           => 'text-cancelled',
            'completed'           => 'text-completed',
            'Active'              => 'text-active'
        ];

        $booking = Booking::where('booking_id', $bookingId)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        $memberIDs = json_decode($booking->selected_family_members);
        $familyMembers = FamilyMember::findMany($memberIDs);

        // Retrieve the booking settings
        $bookingSettings = BookingSetting::first();

        $adultAge = intval(str_replace('+', '', $bookingSettings->adult_age));
        $childrenAgeRange = explode('-', $bookingSettings->children_age);
        $kidsAgeRange = explode('-', $bookingSettings->kids_age);
        $toddlersAgeRange = explode('-', $bookingSettings->Toddlers_age);

        $adults = collect();
        $children = collect();
        $kids = collect();
        $toddlers = collect();

        foreach ($familyMembers as $member) {
            $age = Carbon::parse($member->date_of_birth)->age;

            if ($age >= $adultAge) {
                $adults->push($member);
            } elseif ($age >= intval($childrenAgeRange[0]) && $age <= intval($childrenAgeRange[1])) {
                $children->push($member);
            } elseif ($age >= intval($kidsAgeRange[0]) && $age <= intval($kidsAgeRange[1])) {
                $kids->push($member);
            } elseif ($age >= intval($toddlersAgeRange[0]) && $age <= intval($toddlersAgeRange[1])) {
                $toddlers->push($member);
            }
        }

        // Retrieve all document records for the booking
        $documents = AdultDocument::where('booking_id', $booking->id)->get();

        // Create a mapping of member_id to both ID document paths and scuba diving license document paths
        $documentsMap = $documents->mapWithKeys(function ($doc) {
            return [$doc->member_id => [
                'id_path' => $doc->id_document_path,
                'license_path' => $doc->license_document_path
            ]];
        });

        // Retrieve customer messages associated with the booking
        $messages = BookingNote::where('booking_id', $booking->id)
                                ->where('note_type', 'customer')
                                ->get();

        // Fetch package details
        $package = Package::find($booking->package_id);
        $addonServices = json_decode($package->addon_services_available, true);

        // Fetch services details based on addon services IDs
        $addonServiceIds = array_column($addonServices, 'id');
        $services = Service::whereIn('id', $addonServiceIds)->get();

        // Map services with their prices
        $addonServicesWithPrice = array_map(function($addonService) use ($services) {
            $service = $services->firstWhere('id', $addonService['id']);
            return [
                'id' => $service->id,
                'name' => $service->service_name,
                'price' => $service->price
            ];
        }, $addonServices);

        $roomDetails = json_decode($booking->rooms_details, true);
        $roomGuestDetails = json_decode($booking->room_guest_details, true);

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

        $totalRooms = count($roomDetails);

        return view('user.booking.show', compact('booking', 'statusClasses', 'adults', 'children', 'kids', 'documentsMap', 'messages', 'addonServicesWithPrice', 'roomDetails', 'roomGuestDetails', 'totalRooms', 'totalAdults', 'totalChildren', 'totalToddlers', 'totalKids', 'totalGuests'));
    }

    public function uploadIdDocuments(Request $request, $bookingId)
    {
        $booking = Booking::where('booking_id', $bookingId)->firstOrFail();

        // Define the base path for document storage within the "storage/app/public" directory
        $basePath = 'booking_documents/' . $booking->booking_id;

        // Loop over each file in the request
        foreach ($request->allFiles() as $fileKey => $file) {
            if ($request->hasFile($fileKey)) {
                // Validate the file
                $validatedData = $request->validate([
                    $fileKey => 'file|max:5120|mimes:jpg,jpeg,png', // Max 5MB and specified types
                ]);

                // Extract member ID from the input name
                $memberId = intval(preg_replace('/[^0-9]/', '', $fileKey));

                // Retrieve the original filename
                $originalName = $file->getClientOriginalName();

                // Compute the full path within the "public" disk without the 'public/' prefix
                $fullPath = $basePath . '/' . $originalName;

                // Check if the file already exists
                if (Storage::disk('public')->exists($fullPath)) {
                    // Append a unique ID to the filename if it already exists
                    $originalName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $fullPath = $basePath . '/' . $originalName;
                }

                // Store the file with the original or modified name
                $file->storeAs('public/' . $basePath, $originalName);

                // Determine the type of document based on the prefix
                $type = null;
                if (strpos($fileKey, 'idDocument') !== false) {
                    $type = 'id_document_path';
                } elseif (strpos($fileKey, 'licenseDocument') !== false) {
                    $type = 'license_document_path';
                } elseif (strpos($fileKey, 'otherDocument') !== false) {
                    $type = 'other_document_path';
                }

                // Check if a document record already exists for the member and type
                $adultDocument = AdultDocument::where('member_id', $memberId)
                                              ->where('booking_id', $booking->id)
                                              ->first();

                // If a record exists, update it, otherwise create a new one
                if ($adultDocument) {
                    // Delete old file if it exists
                    Storage::disk('public')->delete($adultDocument->{$type});

                    // Update the record with the new file name
                    $adultDocument->{$type} = $fullPath;
                    $adultDocument->save();
                } else {
                    // Create a new record with the file path
                    AdultDocument::create([
                        'member_id' => $memberId,
                        'booking_id' => $booking->id,
                        $type => $fullPath,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Documents uploaded successfully.');
    }

    public function uploadScubaDivingDocuments(Request $request, $bookingId)
    {
        $booking = Booking::where('booking_id', $bookingId)->firstOrFail();
        $basePath = 'scuba_documents/' . $booking->booking_id;

        foreach ($request->allFiles() as $fileKey => $file) {
            if ($request->hasFile($fileKey)) {
                $validatedData = $request->validate([
                    $fileKey => 'file|max:5120|mimes:jpg,jpeg,png', // Max 5MB and specified types
                ]);

                // Extract member ID from hidden input instead of file name
                $memberId = $request->input('memberId' . intval(preg_replace('/[^0-9]/', '', $fileKey)));

                $originalName = $file->getClientOriginalName();
                $fullPath = $basePath . '/' . $originalName;

                if (Storage::disk('public')->exists($fullPath)) {
                    $originalName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $fullPath = $basePath . '/' . $originalName;
                }

                $file->storeAs('public/' . $basePath, $originalName);

                $type = 'license_document_path';
                $adultDocument = AdultDocument::where('member_id', $memberId)
                                              ->where('booking_id', $booking->id)
                                              ->first();

                    if ($adultDocument) {
                        if (!empty($adultDocument->{$type})) { // Check if the path is not empty
                            Storage::disk('public')->delete($adultDocument->{$type});
                        }
                        $adultDocument->{$type} = $fullPath;
                        $adultDocument->save();
                    } else {
                    AdultDocument::create([
                        'member_id' => $memberId,
                        'booking_id' => $booking->id,
                        $type => $fullPath,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Scuba diving documents uploaded successfully.');
    }

    public function postMessage(Request $request, $bookingId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',  // Validate the message content
        ]);

        $booking = Booking::where('booking_id', $bookingId)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();  // Ensure the booking belongs to the logged user

        $message = new BookingNote([
            'booking_id' => $booking->id,
            'author_id' => auth()->id(),
            'note_type' => 'customer',
            'content' => $request->content,
            'author_type' => 'customer'  // Assuming this is implemented as per earlier discussion
        ]);

        $message->save();

        return back()->with('success', 'Message has been sent successfully.');
    }

    public function resendBookingConfirmation(Request $request, $bookingId)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please Login to your account.');
        }

        // Use the passed parameter directly
        $booking = Booking::where('booking_id', $bookingId)->first();


        if ($booking->user_id !== Auth::id()) {
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
        $totalInfants = 0;

        foreach ($roomGuestDetails as $details) {
            foreach ($details as $key => $value) {
                if (strpos($key, 'adults') !== false) {
                    $totalAdults += (int)$value;
                } elseif (strpos($key, 'children') !== false) {
                    $totalChildren += (int)$value;
                } elseif (strpos($key, 'toddlers') !== false) {
                    $totalToddlers += (int)$value;
                } elseif (strpos($key, 'infants') !== false) {
                    $totalInfants += (int)$value;
                }
            }
        }

        $totalGuests = 0;
        $totalGuests = $totalAdults + $totalChildren + $totalToddlers + $totalInfants;

        //Log::info('Total guests: ' . $totalGuests);

        $email = new BookingConfirmation($booking, $nights, $mainImage, $memberNames, $roomsDetails, $totalAdults, $totalChildren, $totalToddlers, $totalInfants, $totalGuests);

        Mail::to($booking->user->email)->queue($email);
        // Use redirect to avoid resubmission issues
        return redirect()->route('booking.show', ['booking' => $booking->booking_id])->with([
            'success' => 'Email Sent Successfully.'
        ]);
    }

    public function retryBookingPayment(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        // Check if the user is allowed to retry payment
        if (!in_array($booking->payment_status, ['Failed', 'Pending']) || $booking->check_in_date->isFuture() === false) {
            //Log::info("Payment retry not applicable for Booking ID: {$bookingId}");
            return back()->withErrors(['msg' => 'Payment retry is not applicable.']);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeCheckoutSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Booking #' . $booking->booking_id,
                        ],
                        'unit_amount' => $booking->net_total * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('retrybooking.success', $booking->id),
                'cancel_url' => route('retrybooking.cancel', $booking->id),
            ]);

            $booking->update(['stripe_session_id' => $session->id]);

            return redirect()->to($session->url);
        } catch (\Exception $e) {
            Log::error("Stripe payment failed for Booking ID: {$bookingId}, Error: {$e->getMessage()}");
            return back()->withErrors(['msg' => 'Payment failed: ' . $e->getMessage()]);
        }
    }

    public function retrysuccess(Request $request, $bookingId)
    {
        // Logic to handle successful payment
        $booking = Booking::find($bookingId);

        if (!$booking) {
            // No booking found with the provided ID or there was some other error
            Log::error("Booking ID not found: {$bookingId}");
            return back()->withErrors(['msg' => 'The booking could not be found.']);
        }

        // Log successful payment information
        //Log::info("Payment successful for Booking ID: {$bookingId}");

        // Update booking status to Paid
        $booking->update(['payment_status' => 'Paid']);
        $booking->update(['booking_status' => 'confirmed']);

        return redirect()->to(route('booking.show', ['booking' => $booking->booking_id]))->with('success', 'Payment successful!');
    }

    public function retrycancel(Request $request, $bookingId)
    {
        $booking = Booking::find($bookingId);

        if (!$booking) {
            //Log::error("Booking ID not found: {$bookingId}");
            return back()->withErrors(['msg' => 'Booking not found.']);
        }

        // Log payment cancellation
        //Log::warning("Payment cancelled for Booking ID: {$bookingId}");

        return redirect()->to(route('booking.show', ['booking' => $booking->booking_id]))->withErrors(['msg' => 'Payment cancelled.']);
    }

    public function addAdditionalServices(Request $request, $booking_id) {

        try {

            $request->validate([
                'services' => 'required|array',
                'services.*.id' => 'required|exists:services,id',
                'services.*.quantity' => 'required|integer|min:1',
                'totalCost' => 'required|numeric'
            ]);

            // Store the relevant request data in session
            session([
                'additionalservices_data' => [
                    'services' => $request->services,
                    'totalCost' => $request->totalCost,
                    'booking_id' => $booking_id
                ]
            ]);

            $totalToPay = $request->totalCost * 100;  // Stripe requires the amount in cents

            // Initialize Stripe
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create Stripe Checkout session
            $session = StripeCheckoutSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'myr',
                        'product_data' => [
                            'name' => 'Additional Booking Services',
                        ],
                        'unit_amount' => $totalToPay,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('service.payment.success', ['booking_id' => $booking_id]),
                'cancel_url' => route('service.payment.cancel', ['booking_id' => $booking_id]),
            ]);

            return redirect()->to($session->url);

        } catch (\Exception $e) {
            Log::error('Error encountered in addAdditionalServices:', [
                'exception' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Error adding additional services: ' . $e->getMessage());
        }
    }

    public function ServicepaymentSuccess(Request $request, $booking_id)
    {
        DB::beginTransaction();
        try {
            //Log::info('Starting payment success handling for booking ID: ' . $booking_id);

            // Retrieve session data
            $sessionData = session('additionalservices_data');
            if (!$sessionData) {
                //Log::error('Session data not found for booking ID: ' . $booking_id);
                return redirect()->route('booking.show')->with('error', 'Failed to add service.');
            }

            //Log::info('Session data retrieved', ['Session Data' => $sessionData]);

            // Fetch the booking
            $booking = Booking::where('booking_id', $booking_id)->firstOrFail();
            //Log::info('Booking fetched successfully', ['Booking' => $booking]);

            // Decode the previously stored services and reapply them
            $additionalServices = json_decode($booking->additional_services, true) ?? [];
            foreach ($sessionData['services'] as $service) {
                if (isset($additionalServices[$service['id']])) {
                    $additionalServices[$service['id']]['quantity'] += $service['quantity'];
                } else {
                    $additionalServices[$service['id']] = [
                        'name' => $service['name'],
                        'quantity' => $service['quantity'],
                        'price' => $service['price'],
                        'id' => $service['id']
                    ];
                }
            }

            //Log::info('Updated services array', ['Additional Services' => $additionalServices]);

            // Recalculate the totals based on the session data
            $booking->additional_services = json_encode($additionalServices);
            $additionalServicesTotal = collect($additionalServices)->sum(function ($service) {
                return $service['quantity'] * $service['price'];
            });
            $booking->additional_services_total = $additionalServicesTotal;

            //Log::info('Totals recalculated', ['Additional Services Total' => $additionalServicesTotal]);

            $package = Package::findOrFail($booking->package_id);
            $serviceChargePercentage = $package->service_charge;
            $taxPercentage = $package->tax;

            // Retrieve existing values
            $packageCharges = $booking->package_charges;
            $marineFee = $booking->marine_fee;
            $totalSurchargeAmount = $booking->total_surcharge_amount;

            // Calculate coupon discount if applicable
            $couponDiscount = $booking->coupon_code ? $booking->discount_amt : 0;

            // Calculate new totals
            $subTotal = $packageCharges + $additionalServicesTotal + $marineFee + $totalSurchargeAmount - $couponDiscount;
            $booking->sub_total = $subTotal;
            $booking->service_charge = ($subTotal * $serviceChargePercentage) / 100;
            $booking->tax = ($subTotal * $taxPercentage) / 100;
            $booking->net_total = $subTotal + $booking->service_charge + $booking->tax;
            $booking->discount_amt = $couponDiscount;

            //Log::info('Final booking details before saving', ['Booking' => $booking]);

            $booking->save();

            DB::commit();

            //Log::info('Booking saved and transaction committed', ['Booking ID' => $booking_id]);

            // Clear session data to prevent reuse
            session()->forget('additionalservices_data');

            return redirect()->route('booking.show', $booking_id)->with('success', 'Service Added Successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Success Handling Error:', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);

            return redirect()->route('booking.show', $booking_id)->with('error', 'An error occurred while finalizing the payment.');
        }
    }

    public function ServicepaymentCancel(Request $request, $booking_id)
    {
        return redirect()->route('booking.show', $booking_id)->with('error', 'Payment Failed');
    }

}
