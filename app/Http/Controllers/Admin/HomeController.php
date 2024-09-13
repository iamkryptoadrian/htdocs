<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        } else {
            // Calculate total number of bookings
            $totalBookings = Booking::count();

            // Calculate total bookings for this month
            $totalBookingsThisMonth = Booking::whereMonth('created_at', now()->month)
                                             ->whereYear('created_at', now()->year)
                                             ->count();

            // Calculate total bookings for this week
            $totalBookingsThisWeek = Booking::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                            ->count();

            $totalAvailableRooms = Room::sum('room_quantity');

            // Calculate total overall income
            $totalIncome = Booking::sum('net_total');

            // Calculate total income for this month
            $monthlyIncome = Booking::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->sum('net_total');

            // Calculate total income for this week
            $weeklyIncome = Booking::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                   ->sum('net_total');

            $topPackages = $this->getTopPackages(30);

            $latestCustomers = $this->latestCustomers();

            $recentBookings = $this->recentBookings();


            // Fetch data for charts
            $bookingData = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->get();

            $roomData = Room::selectRaw('DATE(created_at) as date, SUM(room_quantity) as available')
                ->groupBy('date')
                ->get();

            $incomeData = Booking::selectRaw('DATE(created_at) as date, SUM(net_total) as amount')
                ->groupBy('date')
                ->get();


            // Pass the data to the view
            return view('admin.dashboard', [
                'totalBookings' => $totalBookings,
                'totalBookingsThisMonth' => $totalBookingsThisMonth,
                'totalBookingsThisWeek' => $totalBookingsThisWeek,
                'totalAvailableRooms' => $totalAvailableRooms,
                'totalIncome' => $totalIncome,
                'monthlyIncome' => $monthlyIncome,
                'weeklyIncome' => $weeklyIncome,
                'topPackages' => $topPackages,
                'latestCustomers' => $latestCustomers,
                'recentBookings' => $recentBookings,
                'bookingData' => $bookingData,
                'roomData' => $roomData,
                'incomeData' => $incomeData,
            ]);
        }
    }
    public function getTopPackages($days = 30)
    {
        // Get the date range
        $dateFrom = Carbon::now()->subDays($days);

        // Fetch top packages within the date range
        $topPackages = DB::table('bookings')
                         ->select('package_id', DB::raw('count(*) as total_bookings'))
                         ->where('created_at', '>=', $dateFrom)
                         ->groupBy('package_id')
                         ->orderBy('total_bookings', 'desc')
                         ->take(5) // Limit to top 5 packages, for example
                         ->get();

        // Fetch package names from package table
        $topPackages->transform(function ($booking) {
            $package = Package::find($booking->package_id);
            $booking->package_name = $package ? $package->package_name : 'Unknown Package';
            return $booking;
        });

        return $topPackages;
    }

    public function latestCustomers()
    {
        // Fetch the latest 5 customers from the database
        $latestCustomers = User::latest()
                               ->take(5)
                               ->get();

        // Pass the latest customers to the view
        return $latestCustomers;
    }

    public function recentBookings()
    {
        // Fetch the latest 5 bookings from the database with user information
        $recentBookings = Booking::with('user')
                               ->latest()
                               ->take(5)
                               ->get();

        // Format the bookings for display
        $recentBookings->transform(function ($booking) {
            // Format the creation time as time elapsed
            $booking->time_passed = $booking->created_at->diffForHumans();
            return $booking;
        });

        // Pass the recent bookings to the view
        return $recentBookings;
    }

}
