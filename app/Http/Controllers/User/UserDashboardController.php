<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\FamilyMember;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $bookings = Booking::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    
        // Retrieve and decode the ports data
        $bookingSettings = BookingSetting::first();
        $ports = $bookingSettings && $bookingSettings->ports 
            ? json_decode($bookingSettings->ports, true)
            : [];

        $defaultPort = $bookingSettings->default_port ?? [];

        // Prepare guest details and port details for each booking
        $bookings->each(function ($booking) use ($ports, $defaultPort) {
            $guestIds = json_decode($booking->selected_family_members, true) ?? [];
            $guests = FamilyMember::whereIn('id', $guestIds)->get();
            $booking->guestDetails = $guests->map(function ($guest) {
                $guest->age = \Carbon\Carbon::parse($guest->date_of_birth)->age;
                return $guest;
            })->toArray();
        
            $bookingDate = $booking->check_in_date->format('Y-m-d');
            $booking->portDetails = $ports[$bookingDate] ?? $defaultPort;
        });
        
        return view('dashboard', [
            'bookings' => $bookings,
            'ports' => $ports,
            'defaultPort' => $defaultPort,
            'bookingSettings' => $bookingSettings, // Pass bookingSettings to the view
        ]);
    }
}
