<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TermsCondition;

class TermsConditionController extends Controller
{

    // Public-facing function to display the terms and conditions
    public function index()
    {
        $terms = TermsCondition::first();
        return view('terms', compact('terms'));
    }    

    // Show the form to create or edit the terms and conditions
    public function manage()
    {
        // Fetch the first (and only) record of terms and conditions
        $terms = TermsCondition::first();
        return view('admin.terms', compact('terms'));
    }

    // Store or update the terms and conditions
    public function save(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);
    
        $content = trim($request->input('content')); // Trim whitespace
    
        // Check if the terms already exist
        $terms = TermsCondition::first();
    
        if ($terms) {
            // Update the existing terms
            $terms->update(['content' => $content]);
        } else {
            // Create new terms and conditions
            TermsCondition::create(['content' => $content]);
        }
    
        return redirect()->route('admin.terms.manage')->with('success', 'Terms and Conditions saved successfully.');
    }
    
}
