<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingSettingController extends Controller
{
    // Show the age settings page
    public function index()
    {
        // Fetch the first setting or create a new instance if none exists
        $setting = BookingSetting::firstOrCreate([]);
        return view('admin.bookingage_settings', compact('setting'));
    }

    // Store or update general age-related settings
    public function storeGeneralSettings(Request $request)
    {
        try {
            $data = $request->validate([
                'adult_age' => 'string|nullable',
                'adult_discount' => 'numeric|nullable',
                'children_age' => 'string|nullable',
                'children_discount' => 'numeric|nullable',
                'kids_age' => 'string|nullable',
                'kids_discount' => 'numeric|nullable',
                'Toddlers_age' => 'string|nullable',
                'Toddlers_discount' => 'numeric|nullable',
            ]);

            $setting = BookingSetting::updateOrCreate(['id' => $request->id], $data);

            return redirect()->back()->with('success', 'General settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the general settings.');
        }
    }

    // Show the port settings page
    public function port_index()
    {
        // Fetch the first setting or create a new instance if none exists
        $setting = BookingSetting::firstOrCreate([]);
        return view('admin.bookingport_settings', compact('setting'));
    }

    // Show the port calendar page
    public function port_calender_index()
    {
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths(12); // Show the next 12 months
    
        // Fetch the existing port data
        $setting = BookingSetting::firstOrCreate([]);
        $portsData = json_decode($setting->ports, true) ?? [];
    
        return view('admin.port_calender', compact('startDate', 'endDate', 'portsData','setting'));
    }
    

    // Handle the setup of port details for a specific date
    public function portSetup($date)
    {
        // Fetch the setting for the given date or create a new one
        $setting = BookingSetting::firstOrCreate([]);
        $portsData = json_decode($setting->ports, true) ?? [];

        // Get the port data for the specific date
        $portDataForDate = $portsData[$date] ?? null;

        // Pass the setting, date, and port data to the setup view
        return view('admin.port_setup', compact('setting', 'date', 'portDataForDate'));
    }

    // Store or update port settings for a specific date
    public function storePortSettings(Request $request, $date)
    {
        try {
            $data = $request->validate([
                'ports' => 'required|json',
            ]);

            // Fetch the existing settings or create a new one
            $setting = BookingSetting::firstOrCreate(['id' => $request->id]);

            // Decode existing ports JSON data
            $portsData = json_decode($setting->ports, true) ?? [];

            // Update the ports data for the specific date
            $portsData[$date] = json_decode($data['ports'], true);

            // Save the updated ports data back to the database
            $setting->ports = json_encode($portsData);
            $setting->save();

            return redirect()->back()->with('success', 'Port settings updated successfully for ' . $date);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the port settings.');
        }
    }
    
    // Function to update the default port setup
    public function updateDefaultPort(Request $request)
    {
        try {
            $data = $request->validate([
                'ports' => 'required|json',
            ]);

            $setting = BookingSetting::firstOrCreate([]);
            $setting->default_port = json_decode($data['ports'], true);
            $setting->save();

            return redirect()->back()->with('success', 'Default port setup updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating default port setup', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while updating the default port setup.');
        }
    }

}
