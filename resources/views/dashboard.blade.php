@extends('user.layouts.main')
@php
    $pageTitle = 'The Rock Resort';
    $user = auth()->user();
@endphp
@section('main-container')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Active Bookings</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Button to trigger modal -->
                    <div class="card text-white bg-secondary mb-3">
                        <div class="card-header">SELECT YOUR ARRIVAL METHOD</div>
                        <div class="card-body">
                            @foreach ($bookings as $booking)
                            <button 
                            data-booking-id="{{ $booking->id }}" 
                            data-booking-guests="{{ json_encode($booking->guestDetails) }}"
                            data-port-details="{{ json_encode($booking->portDetails) }}"
                            class="btn btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalTabs">
                            Select Arrival Method for Booking ID {{ $booking->booking_id }}
                            </button>
                        
                            @endforeach
                        </div>
                    </div>

                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <ul class="nav nav-tabs mt-n3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#activeBookings"
                                        aria-selected="true" role="tab">
                                        <em class="icon ni ni-star-fill"></em>
                                        <span>Active Bookings</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#upcomingBookings" aria-selected="false"
                                        role="tab">
                                        <em class="icon ni ni-calendar"></em>
                                        <span>Upcoming Bookings</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#cancelledBookings" aria-selected="false"
                                        role="tab">
                                        <em class="icon ni ni-cross-circle-fill"></em>
                                        <span>Pending / Cancelled Bookings</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#oldBookings" aria-selected="false"
                                        role="tab">
                                        <em class="icon ni ni-cross-circle-fill"></em>
                                        <span>Old Bookings</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content scrollable_table">
                                <!-- Active Bookings -->
                                <div class="tab-pane active show" id="activeBookings" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-orders">
                                            <thead class="tb-odr-head">
                                                <tr class="tb-odr-item">
                                                    <th class="tb-odr-info">Booking ID</th>
                                                    <th class="tb-odr-info">Arrival Date</th>
                                                    <th class="tb-odr-info">Departure Date</th>
                                                    <th class="tb-odr-info">Booking Status</th>
                                                    <th class="tb-odr-info">Payment Status</th>
                                                    <th class="tb-odr-action text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tb-odr-body">
                                                @forelse ($bookings as $booking)
                                                    @if ($booking->booking_status === 'Active')
                                                        <tr class="tb-odr-item">
                                                            <td class="tb-odr-info">
                                                                <a
                                                                    href="{{ route('booking.show', $booking->booking_id) }}">{{ $booking->booking_id }}</a>
                                                            </td>
                                                            <td class="tb-odr-info">
                                                                {{ $booking->check_in_date->format('d M Y') }}
                                                            </td>
                                                            <td class="tb-odr-info">
                                                                {{ $booking->check_out_date->format('d M Y') }}
                                                            </td>
                                                            <td class="tb-odr-info">
                                                                <span class="tb-odr-status"><span
                                                                        class="badge badge-dot bg-success">{{ $booking->booking_status }}
                                                                    </span></span>
                                                            </td>
                                                            <td class="tb-odr-info">
                                                                <span class="tb-odr-status">
                                                                    <span
                                                                        class="badge badge-dot
                                                                    {{ $booking->payment_status === 'Failed' ? 'bg-danger' : '' }}
                                                                    {{ $booking->payment_status === 'Pending' ? 'bg-warning' : '' }}
                                                                    {{ $booking->payment_status === 'Paid' ? 'bg-success' : '' }}">
                                                                        {{ $booking->payment_status }}
                                                                    </span>
                                                                </span>
                                                            </td>
                                                            <td class="tb-odr-action text-end">
                                                                <a href="{{ route('booking.show', $booking->booking_id) }}"
                                                                    class="btn btn-sm btn-primary">View</a>
                                                                <!-- Additional action buttons -->
                                                                <div class="dropdown">
                                                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                        data-bs-toggle="dropdown">
                                                                        <em class="icon ni ni-more-h"></em>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <ul class="link-list-plain">
                                                                            <li><a href="#" class="text-primary">Get
                                                                                    Support</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No active bookings available
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Upcoming Bookings -->
                                <div class="tab-pane scrollable_table" id="upcomingBookings" role="tabpanel">
                                    <table class="table table-orders">
                                        <thead class="tb-odr-head">
                                            <tr class="tb-odr-item">
                                                <th class="tb-odr-info">Booking ID</th>
                                                <th class="tb-odr-info">Arrival Date</th>
                                                <th class="tb-odr-info">Departure Date</th>
                                                <th class="tb-odr-info">Booking Status</th>
                                                <th class="tb-odr-info">Payment Status</th>
                                                <th class="tb-odr-action text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tb-odr-body">
                                            @forelse ($bookings as $booking)
                                                @if ($booking->booking_status === 'confirmed')
                                                    <tr class="tb-odr-item">
                                                        <td class="tb-odr-info">
                                                            <a
                                                                href="{{ route('booking.show', $booking->booking_id) }}">{{ $booking->booking_id }}</a>
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            {{ $booking->check_in_date->format('d M Y') }}
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            {{ $booking->check_out_date->format('d M Y') }}
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            <span class="tb-odr-status"><span
                                                                    class="badge badge-dot bg-success">{{ $booking->booking_status }}
                                                                </span></span>
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            <span class="tb-odr-status">
                                                                <span
                                                                    class="badge badge-dot
                                                                {{ $booking->payment_status === 'Failed' ? 'bg-danger' : '' }}
                                                                {{ $booking->payment_status === 'Pending' ? 'bg-warning' : '' }}
                                                                {{ $booking->payment_status === 'Paid' ? 'bg-success' : '' }}">
                                                                    {{ $booking->payment_status }}
                                                                </span>
                                                            </span>
                                                        </td>
                                                        <td class="tb-odr-action text-end">
                                                            <a href="{{ route('booking.show', $booking->booking_id) }}"
                                                                class="btn btn-sm btn-primary">View</a>
                                                            <!-- Additional action buttons -->
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-more-h"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#" class="text-primary">Get
                                                                                Support</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No Upcoming bookings available
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Cancelled Bookings -->
                                <div class="tab-pane scrollable_table" id="cancelledBookings" role="tabpanel">
                                    <table class="table table-orders">
                                        <thead class="tb-odr-head">
                                            <tr class="tb-odr-item">
                                                <th class="tb-odr-info">Booking ID</th>
                                                <th class="tb-odr-info">Arrival Date</th>
                                                <th class="tb-odr-info">Departure Date</th>
                                                <th class="tb-odr-info">Booking Status</th>
                                                <th class="tb-odr-info">Payment Status</th>
                                                <th class="tb-odr-action text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tb-odr-body">
                                            @forelse ($bookings as $booking)
                                                @if (in_array($booking->booking_status, ['cancelled', 'Pending For Payment']))
                                                    <tr class="tb-odr-item">
                                                        <td class="tb-odr-info">
                                                            <a
                                                                href="{{ route('booking.show', $booking->booking_id) }}">{{ $booking->booking_id }}</a>
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            {{ $booking->check_in_date->format('d M Y') }}
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            {{ $booking->check_out_date->format('d M Y') }}
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            <span class="tb-odr-status">
                                                                <span
                                                                    class="badge badge-dot
                                                                {{ $booking->booking_status === 'cancelled' ? 'bg-danger' : '' }}
                                                                {{ $booking->booking_status === 'Pending For Payment' ? 'bg-warning' : '' }}">
                                                                    {{ $booking->booking_status }}
                                                                </span>
                                                            </span>
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            <span class="tb-odr-status">
                                                                <span
                                                                    class="badge badge-dot
                                                                {{ $booking->payment_status === 'Failed' ? 'bg-danger' : '' }}
                                                                {{ $booking->payment_status === 'Pending' ? 'bg-warning' : '' }}
                                                                {{ $booking->payment_status === 'Paid' ? 'bg-success' : '' }}">
                                                                    {{ $booking->payment_status }}
                                                                </span>
                                                            </span>
                                                        </td>
                                                        <td class="tb-odr-action text-end">
                                                            <a href="{{ route('booking.show', $booking->booking_id) }}"
                                                                class="btn btn-sm btn-primary">View</a>
                                                            <!-- Additional action buttons -->
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-more-h"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#" class="text-primary">Get
                                                                                Support</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Cancelled bookings available
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- old Bookings -->
                                <div class="tab-pane scrollable_table" id="oldBookings" role="tabpanel">
                                    <table class="table table-orders">
                                        <thead class="tb-odr-head">
                                            <tr class="tb-odr-item">
                                                <th class="tb-odr-info">Booking ID</th>
                                                <th class="tb-odr-info">Arrival Date</th>
                                                <th class="tb-odr-info">Departure Date</th>
                                                <th class="tb-odr-info">Booking Status</th>
                                                <th class="tb-odr-info">Payment Status</th>
                                                <th class="tb-odr-action text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tb-odr-body">
                                            @forelse ($bookings as $booking)
                                                @if ($booking->booking_status === 'completed')
                                                    <tr class="tb-odr-item">
                                                        <td class="tb-odr-info">
                                                            <a
                                                                href="{{ route('booking.show', $booking->booking_id) }}">{{ $booking->booking_id }}</a>
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            {{ $booking->check_in_date->format('d M Y') }}
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            {{ $booking->check_out_date->format('d M Y') }}
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            <span class="tb-odr-status"><span
                                                                    class="badge badge-dot bg-success">{{ $booking->booking_status }}
                                                                </span></span>
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            <span class="tb-odr-status">
                                                                <span
                                                                    class="badge badge-dot
                                                                {{ $booking->payment_status === 'Failed' ? 'bg-danger' : '' }}
                                                                {{ $booking->payment_status === 'Pending' ? 'bg-warning' : '' }}
                                                                {{ $booking->payment_status === 'Paid' ? 'bg-success' : '' }}">
                                                                    {{ $booking->payment_status }}
                                                                </span>
                                                            </span>
                                                        </td>
                                                        <td class="tb-odr-action text-end">
                                                            <a href="{{ route('booking.show', $booking->booking_id) }}"
                                                                class="btn btn-sm btn-primary">View</a>
                                                            <!-- Additional action buttons -->
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-more-h"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-plain">
                                                                        <li><a href="#" class="text-primary">Get
                                                                                Support</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Old bookings available</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Single Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalTabs">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <form action="#" method="POST" id="bookingForm">
                    @csrf
                    <input type="hidden" name="booking_id" id="booking_id" value="">

                    <!-- Arrival Method -->
                    <div class="mb-3">
                        <h5 class="title">Arrival Method to The Rock Resorts</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="arrival_method" id="arrival_self" value="self_arrangement" checked>
                            <label class="form-check-label" for="arrival_self">Self Arrangement</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="arrival_method" id="arrival_boat" value="boat_booking">
                            <label class="form-check-label" for="arrival_boat">Boat Booking</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="arrival_method" id="arrival_charter" value="charter_boat">
                            <label class="form-check-label" for="arrival_charter">Charter Boat</label>
                        </div>
                    </div>

                    <!-- Departure Method -->
                    <div class="mb-3">
                        <h5 class="title">Departure Method From The Rock Resorts</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="departure_method" id="departure_self" value="self_arrangement" checked>
                            <label class="form-check-label" for="departure_self">Self Arrangement</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="departure_method" id="departure_boat" value="boat_booking">
                            <label class="form-check-label" for="departure_boat">Boat Booking</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="departure_method" id="departure_charter" value="charter_boat">
                            <label class="form-check-label" for="departure_charter">Charter Boat</label>
                        </div>
                    </div>

                    <!-- Conditional Tabs for Boat Booking -->
                    <div id="boatBookingTabs" style="display: none;">
                        <ul class="nav nav-tabs" id="boatBookingTabNav">
                            <li class="nav-item" id="arrivalTabNav">
                                <a class="nav-link active" data-bs-toggle="tab" href="#arrivalTab">Arrival Details</a>
                            </li>
                            <li class="nav-item" id="departureTabNav">
                                <a class="nav-link" data-bs-toggle="tab" href="#departureTab">Departure Details</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Arrival Tab -->
                            <div class="tab-pane active" id="arrivalTab">
                                <h6 class="title">Arrival Port</h6>
                                <div class="mb-3">
                                    <select class="form-select" id="arrival_port_select" name="arrival_port_select"></select>
                                </div>

                                <!-- Time Slot Selection -->
                                <div class="mb-3">
                                    <label for="arrival_time_slot" class="form-label">Select Time Slot</label>
                                    <select class="form-select" id="arrival_time_slot" name="arrival_time_slot"></select>
                                </div>

                                <!-- Select Guests -->
                                <h6 class="title">Select Guests</h6>
                                <div id="arrival_guest_list"></div>
                                <hr>
                                <!-- Arrival Boat Charges and Tax -->                                
                                <div class="mb-3">
                                    <p id="arrivalBoatPrice" style="display: none;">Arrival Boat Price: RM 0.00</p>
                                    <p id="arrivalCharterPrice" style="display: none;">Arrival Charter Boat Price: RM 0.00</p>
                                </div>                                  
                            </div>

                            <!-- Departure Tab -->
                            <div class="tab-pane" id="departureTab">
                                <h6 class="title">Drop-off Port</h6>
                                <div class="mb-3">
                                    <select class="form-select" id="departure_port_select" name="departure_port_select"></select>
                                </div>

                                <!-- Time Slot Selection -->
                                <div class="mb-3">
                                    <label for="departure_time_slot" class="form-label">Select Time Slot</label>
                                    <select class="form-select" id="departure_time_slot" name="departure_time_slot"></select>
                                </div>

                                <!-- Select Guests -->
                                <h6 class="title">Select Guests</h6>
                                <div id="departure_guest_list"></div>
                                <hr>
                                <!-- Departure Boat Charges and Tax -->                                
                                <div class="mb-3">
                                    <p id="departureBoatPrice" style="display: none;">Departure Boat Price: RM 0.00</p>
                                    <p id="departureCharterPrice" style="display: none;">Departure Charter Boat Price: RM 0.00</p>
                                </div>                                                             
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pricing Breakdown -->
                    <div class="mb-3" id="pricingBreakdown">
                        <p id="taxCharges">Tax: RM 0.00</p>
                        <p id="totalCharges">Total Charges: RM 0.00</p>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Save Details</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const boatBookingTabs = document.getElementById('boatBookingTabs');
    const arrivalMethodInputs = document.querySelectorAll('input[name="arrival_method"]');
    const departureMethodInputs = document.querySelectorAll('input[name="departure_method"]');
    const arrivalTabNav = document.getElementById('arrivalTabNav');
    const departureTabNav = document.getElementById('departureTabNav');
    const totalCharges = document.getElementById('totalCharges');

    let charterBoatPrice = 0;
    let isCharterSelected = false;

    // Toggle visibility of boat booking tabs
    function toggleBoatBookingTabs() {
        const isArrivalSelf = document.querySelector('input[name="arrival_method"]:checked').value === 'self_arrangement';
        const isDepartureSelf = document.querySelector('input[name="departure_method"]:checked').value === 'self_arrangement';
        const isArrivalCharter = document.querySelector('input[name="arrival_method"]:checked').value === 'charter_boat';

        // If charter is selected for arrival, force it for departure too
        if (isArrivalCharter) {
            document.getElementById('departure_charter').checked = true;
            document.getElementById('departure_boat').disabled = true;
            document.getElementById('departure_self').disabled = true;
            isCharterSelected = true;
        } else {
            document.getElementById('departure_boat').disabled = false;
            document.getElementById('departure_self').disabled = false;
            isCharterSelected = false;
        }

        // Show/hide tabs based on self-arrangement
        if (isArrivalSelf && isDepartureSelf) {
            boatBookingTabs.style.display = 'none'; // Hide all tabs
        } else {
            boatBookingTabs.style.display = 'block'; // Show the tab container
            if (isArrivalSelf) {
                arrivalTabNav.style.display = 'none'; // Hide arrival tab
                departureTabNav.querySelector('a').click(); // Switch to departure tab
            } else {
                arrivalTabNav.style.display = 'block'; // Show arrival tab
            }

            if (isDepartureSelf) {
                departureTabNav.style.display = 'none'; // Hide departure tab
                arrivalTabNav.querySelector('a').click(); // Switch to arrival tab
            } else {
                departureTabNav.style.display = 'block'; // Show departure tab
            }
        }
    }

    // Event listeners to toggle visibility based on method selection
    arrivalMethodInputs.forEach(input => input.addEventListener('change', toggleBoatBookingTabs));
    departureMethodInputs.forEach(input => input.addEventListener('change', toggleBoatBookingTabs));

    // Initialize state on load
    toggleBoatBookingTabs();

    // When the modal is shown, populate guest list, ports, and time slots
    $('#modalTabs').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Button that triggered the modal
        const guestDetails = button.data('booking-guests');
        const portDetails = button.data('port-details');

        const arrivalPortSelect = document.getElementById('arrival_port_select');
        const departurePortSelect = document.getElementById('departure_port_select');
        const arrivalTimeSlot = document.getElementById('arrival_time_slot');
        const departureTimeSlot = document.getElementById('departure_time_slot');
        const arrivalGuestList = document.getElementById('arrival_guest_list');
        const departureGuestList = document.getElementById('departure_guest_list');

        const arrivalBoatPriceElement = document.getElementById('arrivalBoatPrice');
        const arrivalCharterPriceElement = document.getElementById('arrivalCharterPrice');
        const departureBoatPriceElement = document.getElementById('departureBoatPrice');
        const departureCharterPriceElement = document.getElementById('departureCharterPrice');

        // Reset previous modal state
        arrivalGuestList.innerHTML = '';
        departureGuestList.innerHTML = '';
        arrivalPortSelect.innerHTML = '';
        departurePortSelect.innerHTML = '';
        arrivalTimeSlot.innerHTML = '';
        departureTimeSlot.innerHTML = '';

        // Hide price elements by default
        arrivalBoatPriceElement.style.display = 'none';
        arrivalCharterPriceElement.style.display = 'none';
        departureBoatPriceElement.style.display = 'none';
        departureCharterPriceElement.style.display = 'none';

        // Populate guest list for arrival and departure
        guestDetails.forEach(guest => {
            const guestHtml = `<div class="form-check">
                <input class="form-check-input" type="checkbox" name="arrival_guests[]" value="${guest.id}" id="guest_${guest.id}_arrival">
                <label class="form-check-label" for="guest_${guest.id}_arrival">${guest.first_name} ${guest.last_name} (${guest.age} years)</label>
            </div>`;
            arrivalGuestList.innerHTML += guestHtml;

            const departureGuestHtml = `<div class="form-check">
                <input class="form-check-input" type="checkbox" name="departure_guests[]" value="${guest.id}" id="guest_${guest.id}_departure">
                <label class="form-check-label" for="guest_${guest.id}_departure">${guest.first_name} ${guest.last_name} (${guest.age} years)</label>
            </div>`;
            departureGuestList.innerHTML += departureGuestHtml;
        });

        // Populate port details and time slots
        if (portDetails) {
            portDetails.forEach(port => {
                const portOption = `<option value="${port.port_name}" data-price="${port.port_price}" data-charter-price="${port.charter_boat_price || 0}">${port.port_name} - RM ${port.port_price}</option>`;
                arrivalPortSelect.innerHTML += portOption;
                departurePortSelect.innerHTML += portOption;

                // Populate arrival and departure time slots for each port
                port.arrival_schedules.forEach(schedule => {
                    const timeSlotOption = `<option value="${schedule.time}">${schedule.time} (Capacity: ${schedule.capacity})</option>`;
                    arrivalTimeSlot.innerHTML += timeSlotOption;
                });

                port.departure_schedules.forEach(schedule => {
                    const timeSlotOption = `<option value="${schedule.time}">${schedule.time} (Capacity: ${schedule.capacity})</option>`;
                    departureTimeSlot.innerHTML += timeSlotOption;
                });
            });
        }

        // Price Calculation Logic
        function calculatePrice() {
            let total = 0;
            let priceToUse = 0;
            const selectedGuests = Array.from(document.querySelectorAll('input[name="arrival_guests[]"]:checked'));

            const selectedPort = arrivalPortSelect.options[arrivalPortSelect.selectedIndex];
            const portPrice = parseFloat(selectedPort.dataset.price) || 0;
            const charterBoatPrice = parseFloat(selectedPort.dataset.charterPrice) || 0;

            // Use charter boat price for both arrival and departure if charter boat is selected
            if (isCharterSelected) {
                priceToUse = charterBoatPrice;
                arrivalCharterPriceElement.style.display = 'block';
                arrivalCharterPriceElement.innerText = `Arrival Charter Boat Price: RM ${priceToUse}`;
                departureCharterPriceElement.style.display = 'block';
                departureCharterPriceElement.innerText = `Departure Charter Boat Price: RM ${priceToUse}`;
            } else {
                priceToUse = portPrice;
                arrivalBoatPriceElement.style.display = 'block';
                arrivalBoatPriceElement.innerText = `Arrival Boat Price: RM ${priceToUse}`;
                departureBoatPriceElement.style.display = 'block';
                departureBoatPriceElement.innerText = `Departure Boat Price: RM ${priceToUse}`;
            }

            selectedGuests.forEach(guestCheckbox => {
                const guestId = guestCheckbox.value;
                const guest = guestDetails.find(g => g.id == guestId);

                if (guest.age >= 13) {
                    total += priceToUse; // Adult price
                } else if (guest.age >= 7 && guest.age < 13) {
                    total += priceToUse * 0.5; // Child price (50% discount)
                }
            });

            totalCharges.innerText = `Total Charges: RM ${total.toFixed(2)}`;
        }

        // Attach event listeners to guest checkboxes and port selection for price recalculation
        document.querySelectorAll('input[name="arrival_guests[]"]').forEach(input => {
            input.addEventListener('change', calculatePrice);
        });
        arrivalPortSelect.addEventListener('change', calculatePrice);
    });
});

</script>

@endsection