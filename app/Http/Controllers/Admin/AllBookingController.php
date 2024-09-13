<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdultDocument;
use App\Models\BookingSetting;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\FamilyMember;
use Carbon\Carbon;
use App\Models\BookingNote;
use Illuminate\Support\Facades\Storage;
class AllBookingController extends Controller
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
        $query = Booking::query();

        // Apply search term if provided
        if ($searchTerm) {
            $query->where('booking_id', 'like', "%{$searchTerm}%")
            ->orWhere('id', 'like', "%{$searchTerm}%");
        }

        // Retrieve bookings with pagination and sorting
        $bookings = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);

        // Attach the current query string to the pagination links to maintain state
        $bookings->appends($request->except('page'));

        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $bookings->lastPage();
        $pageRange = range(1, $totalPages);

        $statusClasses = [
            'Pending For Payment' => 'text-pending_payment',
            'confirmed'           => 'text-confirmed',
            'cancelled'           => 'text-cancelled',
            'completed'           => 'text-completed',
            'Active'              => 'text-active'
        ];

        // Pass necessary data to the view
        return view('admin.booking_list.index', [
            'bookings' => $bookings,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
            'statusClasses' => $statusClasses,
        ]);
    }

    public function viewBooking($booking_id) {
        $statusClasses = [
            'Pending For Payment' => 'text-pending_payment',
            'confirmed'           => 'text-confirmed',
            'cancelled'           => 'text-cancelled',
            'completed'           => 'text-completed',
            'Active'              => 'text-active'
        ];

        try {
            $booking = Booking::with(['notes' => function($query) {
                $query->where('note_type', 'private');  // Only load private notes
            }])->where('booking_id', $booking_id)->firstOrFail();


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


        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $documents = AdultDocument::where('booking_id', $booking->id)->get();


        // Retrieve all messages associated with the booking
        $messages = BookingNote::where('booking_id', $booking->id)
                                ->where('note_type', 'customer')
                                ->get();


        //fetch all services
        $services = Service::all();

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


        // Decode the activity_assignment field
        $activityAssignments = json_decode($booking->activity_assignment, true);


        $activityDetails = [];

        if ($activityAssignments) {
            foreach ($activityAssignments as $service => $assignments) {
                foreach ($assignments as $assignment) {
                    $guest = FamilyMember::find($assignment['guest']);
                    if ($guest) {
                        $guestName = $guest->first_name . ' ' . $guest->last_name;
                        if (!isset($activityDetails[$guestName])) {
                            $activityDetails[$guestName] = [];
                        }
                        if (isset($activityDetails[$guestName][$service])) {
                            $activityDetails[$guestName][$service] += (int)$assignment['quantity'];
                        } else {
                            $activityDetails[$guestName][$service] = (int)$assignment['quantity'];
                        }
                    }
                }
            }
        }

        // Filter out activities with 0 quantity
        foreach ($activityDetails as $guestName => $services) {
            foreach ($services as $service => $quantity) {
                if ($quantity == 0) {
                    unset($activityDetails[$guestName][$service]);
                }
            }
            if (empty($activityDetails[$guestName])) {
                unset($activityDetails[$guestName]);
            }
        }

        // Pass the messages to the view
        return view('admin.booking_list.view', compact('booking', 'statusClasses', 'adults', 'children', 'kids', 'documents', 'messages', 'services', 'roomDetails', 'roomGuestDetails', 'totalRooms', 'totalAdults', 'totalChildren', 'totalToddlers', 'totalKids', 'totalGuests', 'activityDetails'));

    }


    public function replyMessage(Request $request, $booking_id) {
        // Validate the request content
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        try {
            // Attempt to find the booking and create a new message
            $booking = Booking::where('booking_id', $booking_id)->first();

            BookingNote::create([
                'booking_id' => $booking->id,
                'author_id' => auth()->id(),
                'note_type' => 'customer',
                'content' => $request->content,
                'author_type' => 'admin',
            ]);

            // If successful, redirect back with a success message
            return redirect()->back()->with('success', 'Reply sent successfully.');
        } catch (\Exception $e) {
            // Log the error message
            \Log::error("Failed to send reply: " . $e->getMessage());
            // Redirect back with an error message if something goes wrong
            return redirect()->back()->withErrors('Failed to send reply. Please try again.');
        }
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'booking_status' => 'required|in:Pending For Payment,confirmed,cancelled,completed,Active',
            'payment_status' => 'required|in:Pending,Failed,Paid',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->booking_status = $request->booking_status;
        $booking->payment_status = $request->payment_status;
        $booking->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
