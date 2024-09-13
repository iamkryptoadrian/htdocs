@extends('layouts.main2')
@php
$pageTitle = "Customer Details";
$user = Auth::user();
$coupon = json_decode(request()->cookie('coupon'), true);
$packageCharges = str_replace('RM ', '', $bookingData2['total_night_charges'] ?? '0');
$additionalServicesTotal = str_replace('RM ', '', $bookingData2['additional_services_total'] ?? '0');
$marineFeePerPerson = str_replace('RM ', '', $marineFee ?? '0');
$couponDiscountString = str_replace('RM ', '', $coupon['discountValue'] ?? '0');
$totalSurchargeAmount = str_replace('RM ', '', $surcharges['totalSurchargeAmount'] ?? '0');
$packageCharges = floatval($packageCharges);
$additionalServicesTotal = floatval($additionalServicesTotal);

$marineFeePerPerson = floatval($marineFeePerPerson);

// Calculate total number of adults and children for marine fee
$totalAdults = 0;
$totalChildren = 0;
$totalKids  = 0;
$totalToddlers = 0;
for ($i = 1; $i <= $bookingData2['no_of_rooms']; $i++) {
    $totalAdults += $bookingData2["room_{$i}_adults"] ?? 0;
    $totalChildren += $bookingData2["room_{$i}_children"] ?? 0;
    $totalKids += $bookingData2["room_{$i}_kids"] ?? 0;
    $totalToddlers += $bookingData2["room_{$i}_toddlers"] ?? 0;
}

$totalMarineFee = ($totalAdults + $totalChildren) * $marineFeePerPerson;


$couponDiscount = floatval($couponDiscountString);
$totalSurchargeAmount = floatval($totalSurchargeAmount);
$subTotal = $packageCharges + $additionalServicesTotal + $totalMarineFee + $totalSurchargeAmount - $couponDiscount;
$subTotal = $packageCharges + $additionalServicesTotal + $totalMarineFee + $totalSurchargeAmount - $couponDiscount;
$serviceCharge = ($subTotal * $serviceFees) / 100;
$tax = ($subTotal * $taxAmount) / 100;
$netTotal = $subTotal + $serviceCharge + $tax;


// Assuming the passed age ranges are in the format 'minAge-maxAge' like '6-12'
list($childrenMinAge, $childrenMaxAge) = explode('-', $childrenAge);
list($kidsMinAge, $kidsMaxAge) = explode('-', $kidsAge);
list($toddlerMinAge, $toddlerMaxAge) = explode('-', $toddlerAge);


// Convert family members array to collection
$familyMembers = collect($familyMembers);

$adultFamilyMembers = $familyMembers->filter(function($member) use ($adultAge) {
    return \Carbon\Carbon::parse($member['date_of_birth'])->age >= $adultAge;
})->sortByDesc(function($member) {
    return \Carbon\Carbon::parse($member['date_of_birth'])->age;
});
$totalAdultMembers = $adultFamilyMembers->count();

$childrenFamilyMembers = $familyMembers->filter(function($member) use ($childrenMinAge, $childrenMaxAge) {
    $age = \Carbon\Carbon::parse($member['date_of_birth'])->age;
    return $age >= $childrenMinAge && $age <= $childrenMaxAge;
})->sortByDesc(function($member) {
    return \Carbon\Carbon::parse($member['date_of_birth'])->age;
});
$totalchildrenMembers = $childrenFamilyMembers->count();

$kidsFamilyMembers = $familyMembers->filter(function($member) use ($kidsMinAge, $kidsMaxAge) {
    $age = \Carbon\Carbon::parse($member['date_of_birth'])->age;
    return $age >= $kidsMinAge && $age <= $kidsMaxAge;
})->sortByDesc(function($member) {
    return \Carbon\Carbon::parse($member['date_of_birth'])->age;
});
$totalkidsMembers = $kidsFamilyMembers->count();

$toddlersFamilyMembers = $familyMembers->filter(function($member) use ($toddlerMinAge, $toddlerMaxAge) {
    $age = \Carbon\Carbon::parse($member['date_of_birth'])->age;
    return $age >= $toddlerMinAge && $age <= $toddlerMaxAge;
})->sortByDesc(function($member) {
    return \Carbon\Carbon::parse($member['date_of_birth'])->age;
});
$totalToddlersMembers = $toddlersFamilyMembers->count();

@endphp
@section('main-container')

<section class="layout-pt-lg layout-pb-lg">
    <div data-anim-wrap class="container">
        <h4 style="font-family:var(--bs-body-font-family);">Booking Details</h4>
        <br>
        {{-- Check if booking data is available --}}
        @if(!empty($bookingData2))
        @php
            $totalGuests = 0;
            for ($i = 1; $i <= $bookingData2['no_of_rooms']; $i++) {
                $totalGuests += $bookingData2["room_{$i}_adults"] ?? 0;
                $totalGuests += $bookingData2["room_{$i}_children"] ?? 0;
                $totalGuests += $bookingData2["room_{$i}_kids"] ?? 0;
                $totalGuests += $bookingData2["room_{$i}_toddlers"] ?? 0;
            }

            $remainingGuests = max($totalGuests - count($familyMembers), 0);
        @endphp
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <strong>Check-in - Check-out:</strong>
                    <p style="font-weight: 500"><span>{{  $bookingData2['nights'] }} nights</span>, {{ $bookingData2['check_in_check_out'] }}</p>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <strong>Package Name:</strong>
                    <p>{{ ucfirst($bookingData2['package_name']) ?? 'N/A' }}</p>
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <strong>Selected Rooms:</strong>
                    <ul style="padding-left: 0px">
                        @for ($i = 1; $i <= $bookingData2['no_of_rooms']; $i++)
                            <li>{{ $i }} - {{ $bookingData2["room_{$i}_name"] ?? 'N/A' }}</li>
                        @endfor
                    </ul>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <strong>Guests Details:</strong>
                    @for ($i = 1; $i <= $bookingData2['no_of_rooms']; $i++)
                    <li>
                        {{ $bookingData2["room_{$i}_name"] ?? 'N/A' }} -
                        @if ($bookingData2["room_{$i}_adults"] > 0)
                            Adults: {{ $bookingData2["room_{$i}_adults"] }}
                        @endif
                        @if ($bookingData2["room_{$i}_children"] > 0)
                            , Children: {{ $bookingData2["room_{$i}_children"] }}
                        @endif
                        @if ($bookingData2["room_{$i}_kids"] > 0)
                            , Kids: {{ $bookingData2["room_{$i}_kids"] }}
                        @endif
                        @if ($bookingData2["room_{$i}_toddlers"] > 0)
                            , Toddlers: {{ $bookingData2["room_{$i}_toddlers"] }}
                        @endif
                    </li>
                    @endfor
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <strong>Services Included:</strong>
                    @foreach ($bookingData2['included_services'] as $index => $service)
                            <div class="service-item" style="text-align:left;">
                                <span>
                                    {{ $index + 1 }} - {{ $service['name'] }} x {{ $service['quantity'] }} Qty
                                </span>
                            </div>
                    @endforeach
                </div>
                <div class="col-12 col-md-6 col-lg-3 additional_service">
                    <strong>Additional Services:</strong>
                    @if (!empty($bookingData2['additional_services']))
                        @foreach ($bookingData2['additional_services'] as $id => $service)
                            <div class="service-item" style="text-align:left;">
                                <span>
                                    {{ $loop->iteration }} - {{ $service['name'] }} x {{ $service['quantity'] }} Qty
                                </span>
                            </div>
                        @endforeach
                    @else
                        <p>No additional services selected.</p>
                    @endif
                </div>
            </div>
        </div>

        <hr>
        <div id="newGuestPopup" class="popup" style="display: none;">
            <div class="popup-content">
                <!-- Close Button -->
                <span class="close-btn" style="float: right; cursor: pointer; font-size: 20px; font-weight: bold;">&times;</span>

                <form id="newGuestForm" method="POST" action="{{ route('booking.addGuest') }}">
                    @csrf
                    <!-- Add guest form fields -->
                    @include('partials.add-guest-form')
                    <button type="submit" class="button-20">Submit Guest</button>
                </form>
            </div>
        </div>
        <form id="final_form" method="post">
            @csrf
            @if(auth()->check() && !empty($bookingData2))
                {{-- Display family member list with checkboxes --}}
                <h4 style="font-family:var(--bs-body-font-family);">Select Guests: <span id="guestCount">(0 /{{ $totalGuests }})</span></h4>
                <ul id="guestList" style="padding-left: 0 !important">

                    {{-- Existing family members --}}

                    <div class="tabs -underline-1 js-tabs">
                        <div class="tabs__controls row x-gap-0 js-tabs-controls">
                            <div class="col-auto">
                                <button type="button" class="tabs__button text-14 fw-500 px-20 pb-10 js-tabs-button is-tab-el-active" data-tab-target=".-tab-item-1">Adult ({{ $totalAdultMembers }})</button>
                            </div>

                            @if($totalChildren > 0)
                            <div class="col-auto">
                                <button type="button" class="tabs__button text-14 fw-500 px-20 pb-10 js-tabs-button" data-tab-target=".-tab-item-2">Children ({{ $totalchildrenMembers }})</button>
                            </div>
                            @endif

                            @if($totalKids > 0)
                            <div class="col-auto">
                                <button type="button" class="tabs__button text-14 fw-500 px-20 pb-10 js-tabs-button" data-tab-target=".-tab-item-3">Kids ({{ $totalkidsMembers }})</button>
                            </div>
                            @endif

                            @if($totalToddlers > 0)
                            <div class="col-auto">
                                <button type="button" class="tabs__button text-14 fw-500 px-20 pb-10 js-tabs-button" data-tab-target=".-tab-item-4">Toddlers ({{ $totalToddlersMembers }})</button>
                            </div>
                            @endif
                        </div>

                        <div class="tabs__content pt-15 js-tabs-content">
                            <div class="tabs__pane -tab-item-1 is-tab-el-active">
                                <ul>
                                    {{-- Adults --}}
                                    @if ($adultFamilyMembers->isEmpty())
                                    <p>Please add a member to your profile.</p>
                                    @else
                                    @foreach($adultFamilyMembers as $member)
                                    <li style="display: flex; align-items: center;">
                                        <div class="d-flex items-center mb-2">
                                            <div class="form-checkbox">
                                                <input type="checkbox" name="selectedFamilyMembers[]" value="{{ $member['id'] }}" data-age="{{ \Carbon\Carbon::parse($member['date_of_birth'])->age }}" data-isAdult="true">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon">
                                                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-14 lh-12 ml-10">
                                                {{ $member['first_name'] }} {{ $member['last_name'] }} - ({{ \Carbon\Carbon::parse($member['date_of_birth'])->age }} years old)
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="tabs__pane -tab-item-2">
                                <ul>
                                    {{-- Children --}}
                                    @if ($childrenFamilyMembers->isEmpty())
                                    <p>Please add a Children to your profile.</p>
                                    @else
                                    @foreach($childrenFamilyMembers as $member)
                                    <li style="display: flex; align-items: center;">
                                        <div class="d-flex items-center mb-2">
                                            <div class="form-checkbox">
                                                <input type="checkbox" name="selectedFamilyMembers[]" value="{{ $member['id'] }}" data-age="{{ \Carbon\Carbon::parse($member['date_of_birth'])->age }}" data-isAdult="false">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon">
                                                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-14 lh-12 ml-10">
                                                {{ $member['first_name'] }} {{ $member['last_name'] }} - ({{ \Carbon\Carbon::parse($member['date_of_birth'])->age }} years old)
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="tabs__pane -tab-item-3">
                                <ul>
                                    {{-- Kids --}}
                                    @if ($kidsFamilyMembers->isEmpty())
                                    <p>Please add a Kid to your profile.</p>
                                    @else
                                    @foreach($kidsFamilyMembers as $member)
                                    <li style="display: flex; align-items: center;">
                                        <div class="d-flex items-center mb-2">
                                            <div class="form-checkbox">
                                                <input type="checkbox" name="selectedFamilyMembers[]" value="{{ $member['id'] }}" data-age="{{ \Carbon\Carbon::parse($member['date_of_birth'])->age }}" data-isAdult="false">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon">
                                                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-14 lh-12 ml-10">
                                                {{ $member['first_name'] }} {{ $member['last_name'] }} - ({{ \Carbon\Carbon::parse($member['date_of_birth'])->age }} years old)
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="tabs__pane -tab-item-4">
                                <ul>
                                    {{-- Toddlers --}}
                                    @if ($toddlersFamilyMembers->isEmpty())
                                    <p>Please add a Toddler to your profile.</p>
                                    @else
                                    @foreach($toddlersFamilyMembers as $member)
                                    @php
                                    $dob = \Carbon\Carbon::parse($member['date_of_birth']);
                                    $currentDate = \Carbon\Carbon::now();
                                    $ageInYears = $dob->age;
                                    $ageInMonths = $dob->diffInMonths($currentDate);
                                    $ageInDays = $dob->diffInDays($currentDate);
                                    $daysInCurrentMonth = $dob->diffInDays($currentDate->copy()->startOfMonth());
                                    @endphp
                                    <li style="display: flex; align-items: center;">
                                        <div class="d-flex items-center mb-2">
                                            <div class="form-checkbox">
                                                <input type="checkbox" name="selectedFamilyMembers[]" value="{{ $member['id'] }}" data-age="{{ $ageInYears }}" data-isAdult="false">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon">
                                                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-14 lh-12 ml-10">
                                                {{ $member['first_name'] }} {{ $member['last_name'] }} -
                                                @if ($ageInYears < 1)
                                                @if ($ageInMonths < 1)
                                                ({{ $ageInDays }} days old)
                                                @else
                                                ({{ $ageInMonths }} months {{ $daysInCurrentMonth }} days old)
                                                @endif
                                                @else
                                                ({{ $ageInYears }} years old)
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>


                </ul>

                <button id="addNewGuestButton" type="button" class="button-20">Add New Guest</button>

            @else
                <div class="alert alert-info">
                    <p>Please <a style="font-weight: 600; color:burlywood;font-size: 26px;" href="{{ route('login') }}?redirect={{ urlencode('/booking-step2') }}">log in</a> to continue with your booking.</p>
                </div>
            @endif
        <hr>

        <div class="row mb-50">
            <div class="row y-gap-30 justify-between">
                <div class="col-auto">
                  <strong>Enter Promo Code</strong>
                  <div class="row y-gap-30">
                        <div class="col-auto">
                          <div class="contactForm">
                            <div class="form-input">
                                <div class="form-input">
                                    <input style="height:55px" type="text" id="promoCodeInput" class="" placeholder="Enter Coupon Code">
                                    <div id="promoCodeMessage" class="text-success" style="display: none;"></div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" id="applyCouponButton" class="button -md -type-2 bg-accent-2 -accent-1" style="display: block;">Apply Coupon</button>
                            <button type="button" id="removeCouponButton" class="button -md -type-2 bg-accent-2 -accent-1" style="display: none;">Remove Coupon</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <strong>Your Booking Total</strong>
            <div class="col-auto">
                <table class="table checkout-summary">
                    <thead>
                        <tr>
                            <th>Charges</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Package Charges:</strong></td>
                            <td>RM {{ number_format($packageCharges, 2) }}</td>
                            <input type="hidden" name="packageCharges" value="{{ $packageCharges }}" />
                        </tr>
                        @if($coupon)
                            <tr>
                                <td><strong>Discount ({{ $coupon['code'] }}):</strong></td>
                                <td class="text-success">- RM {{ number_format($couponDiscount, 2) }}</td>
                                <input type="hidden" name="couponCode" value="{{ $coupon['code'] }}" />
                                <input type="hidden" name="couponDiscount" value="{{ $couponDiscount }}" />
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Additional Services Total:</strong></td>
                            <td>RM {{ number_format($additionalServicesTotal, 2) }}</td>
                            <input type="hidden" name="additionalServicesTotal" value="{{ $additionalServicesTotal }}" />
                        </tr>
                        <tr>
                            <td><strong>Total Marine Fees:</strong></td>
                            <td>RM {{ number_format($totalMarineFee, 2) }}</td>
                            <input type="hidden" name="marineFee" value="{{ $totalMarineFee }}" />
                        </tr>
                        <tr>
                            <td><strong>Total Surcharge:</strong></td>
                            <td>RM {{ number_format($totalSurchargeAmount, 2) }}</td>
                            <input type="hidden" name="totalSurchargeAmount" value="{{ $totalSurchargeAmount }}" />
                        </tr>
                        <tr class="subtotal">
                            <td><strong>Sub Total:</strong></td>
                            <td>RM {{ number_format($subTotal, 2) }}</td>
                            <input type="hidden" name="subTotal" value="{{ $subTotal }}" />
                        </tr>
                        <tr>
                            <td><strong>Service Charge:</strong></td>
                            <td>RM {{ number_format($serviceCharge, 2) }}</td>
                            <input type="hidden" name="serviceCharge" value="{{ $serviceCharge }}" />
                        </tr>
                        <tr>
                            <td><strong>Tax:</strong></td>
                            <td>RM {{ number_format($tax, 2) }}</td>
                            <input type="hidden" name="tax" value="{{ $tax }}" />
                        </tr>
                        <tr class="net-total">
                            <td><strong>Net Total:</strong></td>
                            <td>RM {{ number_format($netTotal, 2) }}</td>
                            <input type="hidden" name="netTotal" value="{{ $netTotal }}" />
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="button -md bg-accent-1 -accent-2 text-white w-100" type="submit">Proceed To Payment</button>
                </div>
            </div>
        </form>

        @else
            <p>Booking Timeout, Please Do the booking again.</p>
            <a href="/search_results" style="font-weight: 700; color:#0011ff">Go Back...</a>
        @endif
    </div>
</section>

<script>

    const CHILDREN_AGE_RANGE = '{{ $childrenAge }}'.split('-').map(Number); // e.g., "7-12" becomes [7, 12]
    const KIDS_AGE_RANGE = '{{ $kidsAge }}'.split('-').map(Number); // e.g., "0-6" becomes [0, 6]
    const TODDLER_AGE_RANGE = '{{ $toddlerAge }}'.split('-').map(Number);
    const ADULT_AGE = {{ $adultAge }};

    let selectedGuests = 0; // Global variable for selected guests

    $(document).ready(function() {
        var totalGuests = {{ $totalGuests ?? '0' }};  // Changed to $totalToddlers to be consistent

        var totalAdults = 0;
        var totalChildren = 0;
        var totalKids = 0;  // Changed to var totalKids for consistency with PHP
        var totalToddlers = 0;

        @for ($i = 1; $i <= $bookingData2['no_of_rooms']; $i++)
            totalAdults += {{ $bookingData2["room_{$i}_adults"] ?? 0 }};
            totalChildren += {{ $bookingData2["room_{$i}_children"] ?? 0 }};
            totalKids += {{ $bookingData2["room_{$i}_kids"] ?? 0 }};
            totalToddlers += {{ $bookingData2["room_{$i}_toddlers"] ?? 0 }};
        @endfor

        // Set JavaScript variables
        var requiredAdults = totalAdults;
        var requiredChildren = totalChildren;
        var requiredKids = totalKids;
        var requiredToddlers = totalToddlers;

        // Handle the new guest form submission
        $('#newGuestForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize(); // Serialize form data
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'), // URL from the form's action attribute
                data: formData,
                success: function(response) {
                    // Assuming response contains the added guest
                    // Reload the page to reflect the changes
                    location.reload();
                },
                error: function(response) {
                    // Handle errors, for example, show validation messages
                    alert('Error: Could not add guest');
                }
            });
        });

        // Checkbox change listener
        $('input[name="selectedFamilyMembers[]"]').change(function() {
            let selectedAdults = 0;
            let selectedChildren = 0;
            let selectedKids = 0;
            let selectedToddlers = 0;

            $('#guestList input[type="checkbox"]:checked').each(function() {
                const age = parseInt($(this).data('age'), 10);
                if (age >= ADULT_AGE) {
                    selectedAdults++;
                } else if (age >= KIDS_AGE_RANGE[0] && age <= KIDS_AGE_RANGE[1]) {
                    selectedKids++;
                } else if (age >= CHILDREN_AGE_RANGE[0] && age <= CHILDREN_AGE_RANGE[1]) {
                    selectedChildren++;
                } else if (age >= TODDLER_AGE_RANGE[0] && age <= TODDLER_AGE_RANGE[1]) {
                    selectedToddlers++;
                }
            });

            // Check if total selected guests exceed the allowed number
            if ((selectedAdults + selectedChildren + selectedKids + selectedToddlers) > totalGuests) {
                alert(`You cannot select more than ${totalGuests} guests in total.`);
                $(this).prop('checked', false);
                return;
            }

            // Additional conditions for exceeding specific guest type counts
            if (selectedAdults > requiredAdults) {
                alert(`You cannot select more than ${requiredAdults} adults.`);
                $(this).prop('checked', false);
                return;
            }

            if (selectedChildren > requiredChildren) {
                alert(`You cannot select more than ${requiredChildren} children.`);
                $(this).prop('checked', false);
                return;
            }

            if (selectedKids > requiredKids) {
                alert(`You cannot select more than ${requiredKids} kids.`);
                $(this).prop('checked', false);
                return;
            }

            if (selectedToddlers > requiredToddlers) {
                alert(`You cannot select more than ${requiredToddlers} Toddlers.`);
                $(this).prop('checked', false);
                return;
            }

            selectedGuests = selectedAdults + selectedChildren + selectedKids + selectedToddlers;
            updateGuestCountDisplay(); // Update the displayed count
        });

        // Function to update the guest count display
        function updateGuestCountDisplay() {
            $('#guestCount').text('(' + selectedGuests + '/' + totalGuests + ')');
        }

        updateGuestCountDisplay();
    });


    document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('final_form');
    if (!form) return;

    form.setAttribute('action', '{{ route("booking.finalize") }}');
    const isLoggedIn = @json(Auth::check());

    form.addEventListener('submit', function(event) {
        const totalGuests = parseInt('{{ $totalGuests ?? '0' }}', 10);
        const selectedGuestCount = selectedGuests;

        // Check if user is logged in
        if (!isLoggedIn) {
            event.preventDefault();
            alert('Please login first.');
            return; // Exit the function
        }

        if (selectedGuestCount !== totalGuests) {
            event.preventDefault();
            alert(`Please ensure the number of selected guests (${selectedGuestCount}) matches the total required guests (${totalGuests}).`);
        }
    });


    const promoCodeInput = document.getElementById('promoCodeInput');
    const promoCodeMessage = document.getElementById('promoCodeMessage');
    const applyCouponButton = document.getElementById('applyCouponButton');
    const removeCouponButton = document.getElementById('removeCouponButton');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Function to set the message for coupon application/removal
    function setMessage(message, isSuccess) {
        promoCodeMessage.textContent = message;
        promoCodeMessage.classList.toggle('text-success', isSuccess);
        promoCodeMessage.classList.toggle('text-danger', !isSuccess);
        promoCodeMessage.style.display = 'block';
    }

    // Function to apply a coupon
    function applyCoupon() {
        const promoCode = promoCodeInput.value.trim();
        if (!promoCode) {
            setMessage('Please enter a coupon code.', false);
            return;
        }

        const requestUrl = '{{ route('validate-coupon') }}';
        const packageId = '{{ $bookingData2['package_id'] ?? '0' }}';
        const totalAmount = '{{ $bookingData2['total_night_charges'] ?? '0' }}';

        fetch(requestUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                code: promoCode,
                package_id: packageId,
                totalAmount: totalAmount
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log the received data
            if (data.success) {
                // Use the existing data directly since 'coupon' property does not exist
                updateDiscountSection(data, data.discountValue); // Pass the entire 'data' as 'coupon' object
                setMessage('Promo code has been applied successfully.', true);
                window.location.reload(); // Reload the page to reflect changes
            } else {
                setMessage(data.message, false);
            }
        })
        .catch(error => {
            console.error('Error applying the coupon:', error);
            setMessage('An error occurred while applying the coupon.', false);
        });
    }

    // Function to remove a coupon
    function removeCoupon() {
        fetch('{{ route('remove-coupon') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                promoCodeInput.disabled = false;
                promoCodeInput.value = '';
                setMessage('Coupon removed successfully.', true);
                applyCouponButton.style.display = 'block';
                removeCouponButton.style.display = 'none';
                window.location.reload();
            } else {
                setMessage('Failed to remove the coupon.', false);
            }
        })
        .catch(error => {
            console.error('Failed to remove the coupon:', error);
            setMessage('An error occurred while removing the coupon.', false);
        });
    }

    // Function to check for an applied coupon on session
    function checkForAppliedCoupon() {
        fetch('{{ route('check-coupon') }}', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.coupon) {
                setCouponAppliedState(data.coupon);
            }
        })
        .catch(error => console.error('Error checking for applied coupon:', error));
    }

    // Set the UI to show the applied coupon
    function setCouponAppliedState(coupon) {
        if (!coupon || !coupon.code) {
            console.error('Invalid coupon data:', coupon);
            return;
        }
        promoCodeInput.value = coupon.code; // Make sure coupon object has a 'code' property
        promoCodeInput.disabled = true;
        setMessage(`Promo code ${coupon.code} has been applied successfully.`, true);
        applyCouponButton.style.display = 'none';
        removeCouponButton.style.display = 'block';
    }

    function updateDiscountSection(couponData, discountValue) {
        const discountSection = document.getElementById('discount-section');
        if (discountSection) {
            discountSection.innerHTML = `<strong>Discount:</strong> <span class="text-success">- RM ${discountValue.toFixed(2)}</span>`;
            discountSection.style.display = 'block';
        } else {
            console.error('Discount section element not found.');
        }
    }

    // Event listeners for the apply and remove coupon buttons
    applyCouponButton.addEventListener('click', applyCoupon);
    removeCouponButton.addEventListener('click', removeCoupon);

    // Check for an applied coupon when the page loads
    checkForAppliedCoupon();
});
</script>

<script>
    // Function to show the popup
    function showPopup() {
        document.getElementById("newGuestPopup").style.display = "block";
    }

    // Function to hide the popup
    function hidePopup() {
        document.getElementById("newGuestPopup").style.display = "none";
    }

    // Show popup on button click
    document.getElementById("addNewGuestButton").addEventListener("click", showPopup);

    // Hide popup on close button click
    document.querySelector(".close-btn").addEventListener("click", hidePopup);

    // Prevent popup from closing when clicking inside it
    document.querySelector(".popup-content").addEventListener("click", function(event) {
        event.stopPropagation();
    });

    // This time, we add the event listener directly to the popup background to close it when clicking outside the content
    document.getElementById("newGuestPopup").addEventListener("click", hidePopup);
</script>

@endsection
