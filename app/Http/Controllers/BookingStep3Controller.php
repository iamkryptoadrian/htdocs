<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\FamilyMember;
use Carbon\Carbon;
use App\Models\Service;

class BookingStep3Controller extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the FinalBookingData from the cookie and decode it
        $finalBookingDataJson = $request->cookie('FinalBookingData');
        $FinalBookingData = json_decode($finalBookingDataJson, true);

        //Log::info('FINAL BOOKING DETAILS', $FinalBookingData);

        // Extract selected family member IDs, ensuring we have an array
        $selectedMemberIds = $FinalBookingData['requestData']['selectedFamilyMembers'] ?? [];

        // Fetch family members' details based on the selected IDs
        $selectedMembers = FamilyMember::whereIn('id', $selectedMemberIds)->get();

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

        // Retrieve the agent_code cookie if it exists
        $agentCode = $request->cookie('agent_code');

        // Fetch only enabled services
        $enabledServices = Service::where('allowed_selection', true)->pluck('service_name')->toArray();


        // Pass the FinalBookingData and the prepared family members' details to the view
        return view('booking3', [
            'FinalBookingData' => $FinalBookingData,
            'memberNames' => $memberNames,
            'agentCode' => $agentCode,
            'enabledServices' => $enabledServices,
        ]);
    }

}
