<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cookie;



class CouponController extends Controller
{

    public function index(Request $request)
    {
        // Default values
        $recordsPerPage = $request->query('show', 20);
        $sortOrder = $request->query('order', 'DESC');
        $sortBy = $request->query('sortBy', 'created_at');
        $searchTerm = $request->query('search');

        // Validate sortOrder to prevent SQL injection or errors
        $sortOrder = $sortOrder === 'ASC' ? 'ASC' : 'DESC';

        // Start the query
        $query = Coupon::query();

        // Apply search term if provided
        if ($searchTerm) {
            $query->where('code', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%");
        }

        // Retrieve coupons with pagination and sorting
        $coupons = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);

        // Attach the current query string to the pagination links to maintain state
        $coupons->appends($request->except('page'));

        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $coupons->lastPage();
        // This array will be passed to the view for generating the "go-to" dropdown options
        $pageRange = range(1, $totalPages);

        $packages = Package::all();

        // Pass necessary data to the view
        return view('admin.coupons', [
            'packages' => $packages,
            'coupons' => $coupons,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'code' => 'required|string|unique:coupons|max:255',
            'discount_percent' => 'required|numeric|between:0,99.99',
            'expiry_date' => 'required|date|after:today',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'package_id' => 'nullable|exists:packages,id'

        ];

        // Custom validation messages
        $messages = [
            'code.required' => 'The coupon code is required.',
            'code.unique' => 'This coupon code already exists.',
            'discount_percent.required' => 'The discount percentage is required.',
            'expiry_date.after' => 'The expiry date must be a date after today.',
            // Add more custom messages as needed
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Redirect back with errors if validation fails
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Create a new coupon using mass assignment
            Coupon::create([
                'code' => $request->code,
                'discount_percent' => $request->discount_percent,
                'expiry_date' => $request->expiry_date,
                'max_discount_amount' => $request->max_discount_amount,
                'package_id' => $request->package_id,

            ]);

            // Redirect with success mcessage
            return redirect()->route('admin.coupon')->with('success', 'Coupon created successfully.');
        } catch (Exception $e) {
            // Log the error for debugging purposes
            //\Log::error("Error creating coupon: " . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'An error occurred while creating the coupon. Please try again.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data before proceeding
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'expiry_date' => 'required|date',
            'max_discount_amount' => 'nullable|numeric',
            'package_id' => 'nullable|exists:packages,id'
        ]);

        try {
            // Find the coupon by its id
            $coupon = Coupon::findOrFail($id);

            // Update the coupon with the validated data
            $coupon->update([
                'code' => $validatedData['code'],
                'discount_percent' => $validatedData['discount_percent'],
                'expiry_date' => $validatedData['expiry_date'],
                'max_discount_amount' => $validatedData['max_discount_amount'] ?? null,
                'package_id' => $validatedData['package_id'] ?? null,
            ]);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Coupon updated successfully.');
        } catch (Exception $e) {
            // General error handling
            return redirect()->back()->with('error', 'An error occurred while updating the coupon: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Find the coupon by ID
            $coupon = Coupon::findOrFail($id);

            // Delete the coupon
            $coupon->delete();

            // Redirect back with a success message
            return redirect()->route('admin.coupon')->with('success', 'Coupon deleted successfully.');
        } catch (Exception $e) {
            // Log the error for debugging purposes
            //\Log::error("Error deleting coupon: " . $e->getMessage());

            // If the coupon is not found or another error occurs, redirect back with an error message
            return redirect()->back()->with('error', 'An error occurred while deleting the coupon. Please try again.');
        }
    }


    public function validateCoupon(Request $request)
    {
        try {
            // Validate the request inputs first
            $request->validate([
                'code' => 'required|string',
                'totalAmount' => 'required|numeric|min:0.01',
                'package_id' => 'required|integer'
            ]);

            // Extract validated data
            $couponCode = $request->input('code');
            $totalAmount = $request->input('totalAmount');
            $packageId = $request->input('package_id');


            // Find the coupon by code
            $coupon = Coupon::where('code', $couponCode)
                            ->where('expiry_date', '>=', now())
                            ->where(function ($query) use ($packageId) {
                                $query->where('package_id', $packageId)
                                      ->orWhereNull('package_id');
                            })->first();

            if (!$coupon) {
                return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
            }

            // Ensure coupon percentage and max discount are numeric
            if (!is_numeric($coupon->discount_percent) || !is_numeric($coupon->max_discount_amount)) {
                return response()->json(['success' => false, 'message' => 'Invalid coupon details.']);
            }

            // Calculate discount
            $discountValue = $totalAmount * ($coupon->discount_percent / 100);
            $discountValue = min($discountValue, $coupon->max_discount_amount);

            // Create a cookie with the coupon details
            $couponDetails = json_encode([
                'code' => $coupon->code,
                'discount_percent' => $coupon->discount_percent,
                'max_discount_amount' => $coupon->max_discount_amount,
                'discountValue' => $discountValue,
            ]);

            // Define cookie duration (minutes)
            $duration = 15; // 1 hour

            // Create a cookie
            $cookie = cookie('coupon', $couponDetails, $duration);

            // Attach the cookie to the response
            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully.',
                'discountValue' => $discountValue,
            ])->cookie($cookie);

        } catch (ValidationException $e) {
            // Handle validation errors
            //\Log::error('Coupon validation error', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()]);
        } catch (Exception $e) {
            // Handle general errors
            //\Log::error('Error applying coupon', ['exception' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while applying the coupon.']);
        }
    }

    // In your CouponController or relevant controller
    public function checkCouponSession(Request $request) {
        // Check if a coupon cookie exists
        $coupon = Cookie::get('coupon');

        if ($coupon) {
            // Decode the JSON data from the cookie
            $couponData = json_decode($coupon, true);

            return response()->json([
                'success' => true,
                'coupon' => $couponData
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function remove(Request $request)
    {
        Cookie::queue(Cookie::forget('coupon'));
        return response()->json(['success' => true, 'message' => 'Coupon removed successfully.']);
    }
}
