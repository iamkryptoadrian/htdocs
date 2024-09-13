@extends('layouts.main2')
@php
$pageTitle = "Booking Details";
@endphp
@section('main-container')

<style>
    input[type="number"] {
        -moz-appearance: textfield;
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: inner-spin-button !important;
        opacity: 1;
    }
</style>


<section class="layout-pt-lg layout-pb-md">
    <div data-anim-wrap class="container">
        <h2 class="mb-4">Booking Summary</h2>
        <form action="{{route('bookingstep2.store')}}" method="POST">
        @csrf
        @if(!empty($bookingData))
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <strong>Check-in - Check-out:</strong>
                        <p style="font-weight: 500"><span>{{ $bookingData['no_of_nights'] }} nights</span>, {{ $bookingData['check_in_check_out'] }}</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <strong>Package Name:</strong>
                        <p>{{ ucfirst($bookingData['package_name']) ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <strong>Selected Rooms:</strong>
                        <ul style="padding-left: 0px">
                            @for ($i = 1; $i <= $bookingData['no_of_rooms']; $i++)
                                <li>{{ $i }} - {{ $bookingData["room_{$i}_name"] ?? 'N/A' }}</li>
                            @endfor
                        </ul>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <strong>Guests Details:</strong>
                        @for ($i = 1; $i <= $bookingData['no_of_rooms']; $i++)
                        <li>
                            {{ $bookingData["room_{$i}_name"] ?? 'N/A' }} -
                            @if ($bookingData["room_{$i}_adults"] > 0)
                                Adults: {{ $bookingData["room_{$i}_adults"] }}
                            @endif
                            @if ($bookingData["room_{$i}_children"] > 0)
                                , Children: {{ $bookingData["room_{$i}_children"] }}
                            @endif
                            @if ($bookingData["room_{$i}_kids"] > 0)
                                , Kids: {{ $bookingData["room_{$i}_kids"] }}
                            @endif
                            @if ($bookingData["room_{$i}_toddlers"] > 0)
                                , Toddlers: {{ $bookingData["room_{$i}_toddlers"] }}
                            @endif
                        <li>
                        @endfor
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <strong>Services Included:</strong>
                        @foreach ($includedServicesWithDetails as $index => $service)
                            <div class="service-item" style="text-align:left;">
                                <span>
                                    {{ $loop->iteration }} - {{ $service['name'] }} x {{ $service['quantity'] }} Qty
                                </span>
                                <!-- Hidden inputs for service name and quantity -->
                                <input type="hidden" name="included_services[{{ $index }}][name]" value="{{ $service['name'] }}">
                                <input type="hidden" name="included_services[{{ $index }}][quantity]" value="{{ $service['quantity'] }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Hidden Inputs for Displayed Data -->
                <input type="hidden" name="nights" value="{{ $bookingData['no_of_nights'] }}">
                <input type="hidden" name="check_in_check_out" value="{{ $bookingData['check_in_check_out'] ?? 'N/A' }}">
                <input type="hidden" name="package_id" value="{{ $bookingData['package_id'] ?? 'N/A' }}">
                <input type="hidden" name="package_name" value="{{ $bookingData['package_name'] ?? 'N/A' }}">
                <input type="hidden" name="no_of_rooms" value="{{ $bookingData['no_of_rooms'] ?? '0' }}">
                <input type="hidden" name="total_night_charges" id="totalNightChargesInput" value="{{ $bookingData['total_price'] ?? '0' }}">
                <input type="hidden" name="booking_id" value="{{ $bookingData['booking_id'] ?? 'N/A' }}">
                <input type="hidden" name="additional_services_total" id="additionalServicesTotalInput" value="0">
                @for ($i = 1; $i <= $bookingData['no_of_rooms']; $i++)
                    <input type="hidden" name="room_{{ $i }}" value="{{ $bookingData["room_{$i}"] ?? 'N/A' }}">
                    <input type="hidden" name="room_{{ $i }}_price" value="{{ $bookingData["room_{$i}_price"] ?? '0' }}">
                    <input type="hidden" name="room_{{ $i }}_name" value="{{ $bookingData["room_{$i}_name"] ?? 'N/A' }}">
                    <input type="hidden" name="room_{{ $i }}_adults" value="{{ $bookingData["room_{$i}_adults"] ?? '0' }}">
                    <input type="hidden" name="room_{{ $i }}_children" value="{{ $bookingData["room_{$i}_children"] ?? '0' }}">
                    <input type="hidden" name="room_{{ $i }}_kids" value="{{ $bookingData["room_{$i}_kids"] ?? '0' }}">
                    <input type="hidden" name="room_{{ $i }}_toddlers" value="{{ $bookingData["room_{$i}_toddlers"] ?? '0' }}">
                @endfor
                <br>
                <hr>
                <br>
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Add Additional Services</strong> <span>(After checking the service enter the quanity)</span>
                        <table class="table" style="width: 100%; table-layout: fixed; background-color: #f8f9fa; border-collapse: collapse; margin-top:10px;">
                            <thead>
                                <tr style="background-color: #e9ecef;">
                                    <th style="text-align: center; padding: 8px;">Choose Service</th>
                                    <th style="text-align: left; padding: 8px;">Service Name</th>
                                    <th style="text-align: left; padding: 8px;">Service Price</th>
                                    <th style="text-align: center; padding: 8px;">Enter Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addonServices as $service)
                                <tr>
                                    <td style="text-align: start; padding: 8px; vertical-align: middle;">
                                        <div class="form-checkbox" style="justify-content:center;">
                                            <input type="checkbox" class="additional-service-checkbox" id="additional_service_{{ $service['id'] }}" name="additional_services[{{ $service['id'] }}][selected]" data-service-id="{{ $service['id'] }}" data-price="{{ $service['price'] }}">
                                            <div class="form-checkbox__mark">
                                                <div class="form-checkbox__icon">
                                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: left; padding: 8px; vertical-align: middle;">
                                        <label for="additional_service_{{ $service['id'] }}">{{ $service['service_name'] }}</label>
                                    </td>
                                    <td style="text-align: left; padding: 8px; vertical-align: middle;">
                                        RM{{ number_format($service['price'], 2) }}
                                    </td>
                                    <td style="text-align: center; padding: 8px; vertical-align: middle;">
                                        <input type="number" class="form-control service-quantity" id="quantity_service_{{ $service['id'] }}" name="additional_services[{{ $service['id'] }}][quantity]" placeholder="1" min="1" step="1" value="1" style="width: 60px; margin: auto; text-decoration:underline;" disabled>
                                        <!-- Hidden inputs for carrying over data -->
                                        <input type="hidden" name="additional_services[{{ $service['id'] }}][name]" value="{{ $service['service_name'] }}">
                                        <input type="hidden" name="additional_services[{{ $service['id'] }}][price]" value="{{ $service['price'] }}">
                                        <input type="hidden" name="additional_services[{{ $service['id'] }}][id]" value="{{ $service['id'] }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!-- Subtotal and Total Charges Section -->
        <div class="row mt-4 justify-content-end">
            <div class="col-auto">
                <div>
                    <strong>Stay Charges:</strong>
                    <span>RM {{ $bookingData['total_price'] }}</span>
                </div>
                <div>
                    <strong>Additional Services Total:</strong>
                    <span id="additionalServicesTotal">RM 0</span>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="button -md bg-accent-2 -dark-1 w-1/1 mt-40">Proceed To Next Step</button>
            </div>
        </div>
        @else
        <p>No booking information available.</p>
        @endif
        </form>
    </div>


</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceCheckboxes = document.querySelectorAll('.additional-service-checkbox');
    const additionalServicesTotalSpan = document.getElementById('additionalServicesTotal');
    const additionalServicesTotalInput = document.getElementById('additionalServicesTotalInput'); // Ensure this input exists in your HTML for submitting the total

    // Function to enable/disable quantity input based on checkbox
    function toggleQuantityInput(checkbox) {
        const serviceId = checkbox.getAttribute('data-service-id');
        const quantityInput = document.getElementById('quantity_service_' + serviceId);
        quantityInput.disabled = !checkbox.checked; // Disable input if checkbox is unchecked
        if (!checkbox.checked) {
            quantityInput.value = '0'; // Reset to 0 if disabled
        }
        updateTotalCharges(); // Update the total whenever a checkbox changes
    }

    // Function to calculate and update the total charges
    function updateTotalCharges() {
        let total = 0;
        serviceCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const serviceId = checkbox.getAttribute('data-service-id');
                const price = parseFloat(checkbox.getAttribute('data-price'));
                const quantityInput = document.getElementById('quantity_service_' + serviceId);
                const quantity = parseInt(quantityInput.value);
                total += price * quantity;
            }
        });
        const formattedTotal = 'RM ' + total.toFixed(2);
        additionalServicesTotalSpan.textContent = formattedTotal;
        additionalServicesTotalInput.value = formattedTotal; // Ensure this updates the hidden input for form submission
    }

    // Attach change event listeners to service checkboxes
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleQuantityInput(this);
        });
    });

    // Attach change event listeners to quantity inputs
    document.querySelectorAll('.service-quantity').forEach(input => {
        input.addEventListener('change', function() {
            if (!this.disabled) {
                updateTotalCharges();
            }
        });
    });
});
</script>

@endsection
