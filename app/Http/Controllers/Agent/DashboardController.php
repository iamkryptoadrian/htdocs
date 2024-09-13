<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\GeneralSetting;
use App\Models\AgentTransaction;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        // Get the logged-in agent
        $agent = Auth::guard('agent')->user();

        // Retrieve the agent_code from the agent model
        $agent_code = $agent->agent_code;

        // Count the total number of bookings for this agent code
        $totalBookings = Booking::where('agent_code', $agent_code)->count();

        // Calculate current month's bookings
        $currentMonthBookings = Booking::where('agent_code', $agent_code)
                                        ->whereMonth('created_at', Carbon::now()->month)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->count();

        // Calculate previous month's bookings
        $previousMonthBookings = Booking::where('agent_code', $agent_code)
                                         ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                                         ->whereYear('created_at', Carbon::now()->subMonth()->year)
                                         ->count();

        // Calculate percentage change
        if ($previousMonthBookings > 0) {
            $percentageChange = (($currentMonthBookings - $previousMonthBookings) / $previousMonthBookings) * 100;
        } else {
            $percentageChange = $currentMonthBookings > 0 ? 100 : 0;
        }

        // Determine the class for indicating increase or decrease
        $changeClass = $percentageChange >= 0 ? 'text-success' : 'text-danger';
        $changeIcon = $percentageChange >= 0 ? 'ni ni-arrow-long-up' : 'ni ni-arrow-long-down';

        // Calculate daily bookings for the past 7 days
        $dailyBookings = [];
        $dailyBookingValues = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = Booking::where('agent_code', $agent_code)
                            ->whereDate('created_at', $date)
                            ->count();
            $value = Booking::where('agent_code', $agent_code)
                            ->whereDate('created_at', $date)
                            ->sum('net_total');
            $dailyBookings[] = ['date' => $date, 'count' => $count];
            $dailyBookingValues[] = ['date' => $date, 'value' => $value];
        }

        // Reverse the order to have the oldest date first
        $dailyBookings = array_reverse($dailyBookings);
        $dailyBookingValues = array_reverse($dailyBookingValues);

        // Calculate total booking value
        $totalBookingValue = Booking::where('agent_code', $agent_code)->sum('net_total');

        // Calculate this week's total booking value
        $currentWeekBookingValue = Booking::where('agent_code', $agent_code)
                                           ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                           ->sum('net_total');

        // Calculate last week's total booking value
        $previousWeekBookingValue = Booking::where('agent_code', $agent_code)
                                            ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                                            ->sum('net_total');

        // Calculate percentage change in booking value
        if ($previousWeekBookingValue > 0) {
            $valuePercentageChange = (($currentWeekBookingValue - $previousWeekBookingValue) / $previousWeekBookingValue) * 100;
        } else {
            $valuePercentageChange = $currentWeekBookingValue > 0 ? 100 : 0;
        }

        // Determine the class for indicating increase or decrease in booking value
        $valueChangeClass = $valuePercentageChange >= 0 ? 'text-success' : 'text-danger';
        $valueChangeIcon = $valuePercentageChange >= 0 ? 'ni ni-arrow-long-up' : 'ni ni-arrow-long-down';

        // Calculate total guests for the logged-in agent
        $totalGuests = Booking::where('agent_code', $agent_code)
                              ->get()
                              ->reduce(function ($carry, $item) {
                                  return $carry + count(json_decode($item->selected_family_members));
                              }, 0);

        // Calculate total customers for the logged-in agent
        $totalCustomers = Booking::where('agent_code', $agent_code)
                                 ->distinct('user_id')
                                 ->count('user_id');


        // Calculate total nights for the logged-in agent
        $totalNights = Booking::where('agent_code', $agent_code)
                              ->get()
                              ->reduce(function ($carry, $item) {
                                  $checkIn = Carbon::parse($item->check_in_date);
                                  $checkOut = Carbon::parse($item->check_out_date);
                                  return $carry + $checkOut->diffInDays($checkIn);
                              }, 0);

        $systemTotalNights = GeneralSetting::first()->total_nights;


       // Calculate agent commission for the last 30 days from the agent_transactions table
       $agentCommission = AgentTransaction::where('agent_code', $agent_code)
                                ->where('commission_status', 'paid')
                                ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
                                ->sum('commission_amount');

        // Pending Commission
        $pendingCommission = AgentTransaction::where('agent_code', $agent->agent_code)
            ->where('commission_status', 'pending')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->sum('commission_amount');

        $agentCommissionLast30Days = $agentCommission + $pendingCommission;

        // Fetch the latest 5 transactions
        $latestTransactions = AgentTransaction::with('booking')
            ->whereHas('booking', function($query) use ($agent_code) {
                $query->where('agent_code', $agent_code);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Pass data to the view
        return view('agent.dashboard', compact(
            'agent', 'totalBookings', 'currentMonthBookings', 'previousMonthBookings', 'percentageChange', 'changeClass', 'changeIcon',
            'dailyBookings', 'totalBookingValue', 'currentWeekBookingValue', 'valuePercentageChange', 'valueChangeClass', 'valueChangeIcon',
            'dailyBookingValues', 'totalGuests', 'totalNights', 'systemTotalNights', 'totalCustomers', 'agentCommissionLast30Days', 'latestTransactions'
        ));
    }

    public function updateAgentCode(Request $request)
    {
        $request->validate([
            'agent_code' => 'required|string|alpha|max:8|unique:agents,agent_code',
        ]);

        $agent = Auth::guard('agent')->user();
        $agent->agent_code = $request->input('agent_code');
        $agent->save();

        return redirect()->back()->with('status', 'Code updated successfully!');
    }


    public function validateAgentCode(Request $request)
    {
        $agentCode = $request->input('agent_code');

        // Log the incoming request data
        //Log::info('validateAgentCode request data:', ['agent_code' => $agentCode]);

        $agent = Agent::where('agent_code', $agentCode)->first();

        if ($agent) {
            $response = ['valid' => true, 'agent_name' => $agent->name];
        } else {
            $response = ['valid' => false];
        }

        // Log the response
       // Log::info('validateAgentCode response:', $response);

        return response()->json($response);
    }

    public function fetchAgentName(Request $request)
    {
        $agentCode = $request->input('agent_code');

        // Log the incoming request data
        //Log::info('fetchAgentName request data:', ['agent_code' => $agentCode]);

        $agent = Agent::where('agent_code', $agentCode)->first();

        if ($agent) {
            $response = ['valid' => true, 'agent_name' => $agent->name];
        } else {
            $response = ['valid' => false];
        }

        // Log the response
        //Log::info('fetchAgentName response:', $response);

        return response()->json($response);
    }

}
