<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class GeneralSettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = GeneralSetting::firstOrCreate([]);
        $methods = json_decode($settings->agent_withdraw_method, true) ?? [];
        return view('admin.general_settings', compact('settings', 'methods'), ['request' => $request]);
    }

    public function update(Request $request, $id)
    {
        $settings = GeneralSetting::findOrFail($id);
        $settings->update($request->all());
        return redirect()->route('admin.general_settings.index')->with('success', 'Settings updated successfully.');
    }

    public function addWithdrawMethod(Request $request, $id)
    {
        $settings = GeneralSetting::findOrFail($id);

        $methods = json_decode($settings->agent_withdraw_method, true) ?? [];
        $methods[] = [
            'name' => $request->name,
            'input_type' => 'text',
            'min_withdrawal' => $request->min_withdrawal,
            'enabled' => true,
        ];

        $settings->agent_withdraw_method = json_encode($methods);
        $settings->save();

        return redirect()->route('admin.general_settings.index')->with('success', 'Withdraw method added successfully.');
    }


    public function updateWithdrawMethod(Request $request, $id, $methodIndex)
    {
        $settings = GeneralSetting::findOrFail($id);

        $methods = json_decode($settings->agent_withdraw_method, true);
        $methods[$methodIndex]['name'] = $request->name;
        $methods[$methodIndex]['min_withdrawal'] = $request->min_withdrawal;
        $methods[$methodIndex]['enabled'] = $request->has('status');

        $settings->agent_withdraw_method = json_encode($methods);
        $settings->save();

        return redirect()->route('admin.general_settings.index')->with('success', 'Withdraw method updated successfully.');
    }

    public function deleteWithdrawMethod($id, $methodIndex)
    {
        $settings = GeneralSetting::findOrFail($id);

        $methods = json_decode($settings->agent_withdraw_method, true);
        unset($methods[$methodIndex]);

        $settings->agent_withdraw_method = json_encode(array_values($methods));
        $settings->save();

        return redirect()->route('admin.general_settings.index')->with('success', 'Withdraw method deleted successfully.');
    }
}
