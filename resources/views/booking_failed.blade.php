@extends('layouts.main2')
@php
    $pageTitle = "Make Payment";
    $user = Auth::user();
@endphp
@section('main-container')
<style>
    .custom-service-assignment {
    margin-bottom: 15px;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-sizing: border-box;
}
.custom-service-assignment label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}
.custom-assignment-row {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
.custom-assignment-row select, .custom-assignment-row input {
    margin-right: 10px;
    padding: 5px;
    border-radius: 3px;
    border: 1px solid #ccc;
}
.custom-assignment-row input[type="number"] {
    width: 80px;
}
.custom-assignment-container {
    display: flex;
    flex-wrap: wrap;
}
.custom-assignment-container .custom-service-assignment {
    flex: 1 1 calc(25% - 10px);
    margin: 5px;
}
@media (max-width: 1200px) {
    .custom-assignment-container .custom-service-assignment {
        flex: 1 1 calc(33.33% - 10px);
    }
}
@media (max-width: 992px) {
    .custom-assignment-container .custom-service-assignment {
        flex: 1 1 calc(50% - 10px) !important;
    }
}
@media (max-width: 576px) {
    .custom-assignment-container{
      display: block !important;
    }
}

</style>
<section class="layout-pt-lg layout-pb-lg">
    <div data-anim-wrap class="container">
        <h2>Booking Details</h2>
        <br>
        {{-- Check if booking data is available --}}
        @if(!empty($booking))

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <strong>Check-in - Check-out:</strong>
                        <p style="font-weight: 500">{{ $booking->check_in_date->diffInDays($booking->check_out_date) }} Nights, {{ $booking->check_in_date->format('d-m-Y') ?? 'N/A' }} to {{ $booking->check_out_date->format('d-m-Y') ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <strong>Package Name:</strong>
                        <p>{{ ucfirst($booking->package_name) ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <strong>Selected Rooms:</strong>
                        <ul style="padding-left: 0px">
                            @foreach(json_decode($booking->rooms_details, true) as $index => $room)
                                <li>{{ $index + 1 }} - {{ $room['room_name'] ?? 'N/A' }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <strong>Guests Details:</strong>
                        @foreach($rooms as $room)
                        <li>
                            {{ $room['room_name'] ?? 'N/A' }} -
                            @if ($room['adults'] > 0)
                                {{ $room['adults'] }} Adults
                            @endif
                            @if ($room['children'] > 0)
                                , {{ $room['children'] }} Children
                            @endif
                            @if ($room['kids'] > 0)
                                , {{ $room['kids'] }} Kids
                            @endif
                            @if ($room['toddlers'] > 0)
                                , {{ $room['toddlers'] }} Toddlers
                            @endif
                        </li>
                        @endforeach

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <strong>Services Included:</strong>
                        @foreach ($includedServices as $index => $service)
                                <div class="service-item" style="text-align:left;">
                                    <span>
                                        {{ $index + 1 }} - {{ $service['name'] }} x {{ $service['quantity'] }} Qty
                                    </span>
                                </div>
                        @endforeach
                    </div>
                    <div class="col-12 col-md-6 col-lg-2 additional_service">
                        <strong>Additional Services:</strong>
                        @if (!empty($additionalServices))
                            @foreach ($additionalServices as $id => $service)
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
                    <div class="col-12 col-md-6 col-lg-2">
                        <strong>Guest Details:</strong>
                        @if(!empty($memberNames))
                        @foreach($memberNames as $id => $memberDetails)
                            <div>
                                <span>
                                    {{ $loop->iteration }} - {{ $memberDetails['firstName'] }} {{ $memberDetails['lastName'] }}, {{ $memberDetails['age'] }} years
                                </span>
                            </div>
                        @endforeach
                        @else
                            <p>No Member found</p>
                        @endif
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <strong>Amount to Pay:</strong>
                        <p style="font-weight: 500">RM {{ $booking->net_total ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <hr>

            <div class="col-12 additional_service">
                @if ($canRetry)
                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="netTotal" value="{{ $booking->net_total }}">
                        <input type="hidden" name="packageName" value="{{ $booking->package_name }}">

                        <!-- Additional Section for Choosing Main Guest -->
                        <div>
                            <strong>Choose Main Guest:</strong>
                            @if(!empty($memberNames))
                                @foreach($memberNames as $id => $memberDetails)
                                    @if($memberDetails['age'] >= $adultAge)
                                        <div class="main_guest_list col-6">
                                            <label>
                                                <input required style="width: 5%" type="radio" name="mainGuest" value="{{ $id }}" style="margin-right: 5px;">
                                                {{ $memberDetails['firstName'] }} {{ $memberDetails['lastName'] }}, {{ $memberDetails['age'] }} years
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p>No Member found</p>
                            @endif
                        </div>

                        <hr>

                        <!-- Service Assignment Section -->
                        <div>
                            <strong>Assign Services to Guests:</strong>
                            @php
                                $excludeServices = ['Lunch', 'Dinner', 'Breakfast']; // List of services to exclude

                                // Merge services
                                $services = [];
                                foreach (array_merge($includedServices, $additionalServices) as $service) {
                                    if (!in_array($service['name'], $excludeServices)) {
                                        if (isset($services[$service['name']])) {
                                            $services[$service['name']]['quantity'] += $service['quantity'];
                                        } else {
                                            $services[$service['name']] = $service;
                                        }
                                    }
                                }
                            @endphp

                            <div class="custom-assignment-container">
                                @if(count($memberNames) == 1)
                                    @php
                                        $singleMemberId = array_keys($memberNames)[0];
                                        $singleMemberName = $memberNames[$singleMemberId]['firstName'] . ' ' . $memberNames[$singleMemberId]['lastName'];
                                    @endphp
                                    @foreach ($services as $service)
                                        @if ($service['quantity'] == 1)
                                            <div class="custom-service-assignment">
                                                <label>{{ $service['name'] }} ({{ $service['quantity'] }} Qty):</label>
                                                <div class="custom-assignment-row">
                                                    <select name="activity_assignment[{{ $service['name'] }}][0][guest]" class="form-control">
                                                        <option value="{{ $singleMemberId }}">{{ $singleMemberName }}</option>
                                                    </select>
                                                    <input type="number" name="activity_assignment[{{ $service['name'] }}][0][quantity]" min="1" max="{{ $service['quantity'] }}" value="{{ $service['quantity'] }}" class="form-control">
                                                </div>
                                            </div>
                                        @else
                                            <div class="custom-service-assignment">
                                                <label>{{ $service['name'] }} ({{ $service['quantity'] }} Qty):</label>
                                                @for ($i = 0; $i < $service['quantity']; $i++)
                                                    <div class="custom-assignment-row">
                                                        <select name="activity_assignment[{{ $service['name'] }}][{{ $i }}][guest]" class="form-control">
                                                            <option value="{{ $singleMemberId }}">{{ $singleMemberName }}</option>
                                                        </select>
                                                        <input type="number" name="activity_assignment[{{ $service['name'] }}][{{ $i }}][quantity]" min="1" max="{{ $service['quantity'] }}" value="1" class="form-control">
                                                    </div>
                                                @endfor
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($services as $service)
                                        @if ($service['quantity'] == 1)
                                            <div class="custom-service-assignment">
                                                <label>{{ $service['name'] }} ({{ $service['quantity'] }} Qty):</label>
                                                <div class="custom-assignment-row">
                                                    <select name="activity_assignment[{{ $service['name'] }}][0][guest]" class="form-control">
                                                        @foreach($memberNames as $id => $memberDetails)
                                                            <option value="{{ $id }}">{{ $memberDetails['firstName'] }} {{ $memberDetails['lastName'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="number" name="activity_assignment[{{ $service['name'] }}][0][quantity]" min="1" max="{{ $service['quantity'] }}" value="1" class="form-control" readonly>
                                                </div>
                                            </div>
                                        @else
                                            <div class="custom-service-assignment">
                                                <label>{{ $service['name'] }} ({{ $service['quantity'] }} Qty):</label>
                                                @for ($i = 0; $i < $service['quantity']; $i++)
                                                    <div class="custom-assignment-row">
                                                        <select name="activity_assignment[{{ $service['name'] }}][{{ $i }}][guest]" class="form-control">
                                                            @foreach($memberNames as $id => $memberDetails)
                                                                <option value="{{ $id }}">{{ $memberDetails['firstName'] }} {{ $memberDetails['lastName'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" name="activity_assignment[{{ $service['name'] }}][{{ $i }}][quantity]" min="0" max="{{ $service['quantity'] }}" value="0" class="form-control">
                                                    </div>
                                                @endfor
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <hr>


                        <div class="row">
                            <div class="row y-gap-30 justify-between">
                                <div class="col-auto">
                                    <strong>Enter Agent Code</strong>
                                    <div class="row y-gap-30">
                                        <div class="col-auto">
                                            <div class="contactForm">
                                                <div class="form-input">
                                                    <input style="height:55px" type="text" id="agentCodeInput" class="" placeholder="Enter Agent Code" value="{{ $agentCode ?? '' }}" {{ $agentCode ? 'disabled' : '' }}>
                                                    <input type="hidden" name="agent_code" id="hiddenAgentCodeInput">
                                                    <div id="AgentCodeMessage" class="text-success" style="display: none;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" id="applyCodeButton" class="button -md -type-2 bg-accent-2 -accent-1" style="{{ $agentCode ? 'display: none;' : 'display: block;' }}">Apply Code</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <strong>Debit/Credit Card:</strong>
                        <br>
                        <button class="button-20" style="margin-top:15px;">Click to Pay</button>
                    </form>
                @else
                    <p>The check-in date has passed. Retry is not allowed.</p>
                @endif
            </div>
        @else
            <p>Booking Timeout, Please do the booking again.</p>
            <a href="/search_results" style="font-weight: 700; color:#0011ff">Go Back...</a>
        @endif
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const assignmentContainers = document.querySelectorAll('.custom-service-assignment');

        assignmentContainers.forEach(container => {
            const inputs = container.querySelectorAll('input[type="number"]');
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    const totalQty = Array.from(inputs).reduce((acc, input) => acc + parseInt(input.value || 0), 0);
                    const maxQty = parseInt(container.querySelector('label').innerText.match(/\((\d+) Qty\)/)[1], 10);

                    if (totalQty > maxQty) {
                        input.value = 0;
                        alert(`Total quantity for ${container.querySelector('label').innerText} cannot exceed ${maxQty}.`);
                    }
                });
            });
        });

        form.addEventListener('submit', function (event) {
            let allValid = true;

            assignmentContainers.forEach(container => {
                const inputs = container.querySelectorAll('input[type="number"]');
                const totalQty = Array.from(inputs).reduce((acc, input) => acc + parseInt(input.value || 0), 0);
                const requiredQty = parseInt(container.querySelector('label').innerText.match(/\((\d+) Qty\)/)[1], 10);

                if (totalQty !== requiredQty) {
                    allValid = false;
                    container.style.borderColor = 'red';
                } else {
                    container.style.borderColor = '#ddd';
                }
            });

            if (!allValid) {
                event.preventDefault();
                alert('Please ensure all service quantities are correctly assigned.');
            }
        });


        // Check if agent code is present in the cookies
        var agentCodeInput = document.getElementById('agentCodeInput');
        var hiddenAgentCodeInput = document.getElementById('hiddenAgentCodeInput');
        var applyCodeButton = document.getElementById('applyCodeButton');
        var AgentCodeMessage = document.getElementById('AgentCodeMessage');
        var agentCode = agentCodeInput.value.trim();

        if (agentCode) {
            agentCodeInput.value = agentCode;
            hiddenAgentCodeInput.value = agentCode;
            agentCodeInput.disabled = true;
            applyCodeButton.style.display = 'none';
            fetchAgentName(agentCode);
            console.log('code ', agentCode);
        }

        // Add event listener to the apply code button
        applyCodeButton.addEventListener('click', function() {
            var code = agentCodeInput.value.trim();
            if (code) {
                validateAgentCode(code);
            }
        });
    });

    // Function to get cookie value by name
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    // Function to validate agent code
    function validateAgentCode(code) {
        fetch('/validate-agent-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
            },
            body: JSON.stringify({ agent_code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                document.cookie = "agent_code=" + code + "; max-age=" + (60 * 60 * 48) + "; path=/"; // 48 hours
                agentCodeInput.disabled = true;
                hiddenAgentCodeInput.value = code;
                applyCodeButton.style.display = 'none';
                AgentCodeMessage.textContent = "Agent: " + data.agent_name;
                AgentCodeMessage.style.display = 'block';
            } else {
                AgentCodeMessage.textContent = "Invalid agent code.";
                AgentCodeMessage.style.display = 'block';
                AgentCodeMessage.style.color = 'red';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            AgentCodeMessage.textContent = "An error occurred. Please try again.";
            AgentCodeMessage.style.display = 'block';
            AgentCodeMessage.style.color = 'red';
        });
    }

    // Function to fetch agent name by agent code
    function fetchAgentName(code) {
        fetch('/fetch-agent-name', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
            },
            body: JSON.stringify({ agent_code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                AgentCodeMessage.textContent = "Agent: " + data.agent_name;
                AgentCodeMessage.style.display = 'block';
            } else {
                AgentCodeMessage.textContent = "Invalid agent code.";
                AgentCodeMessage.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            AgentCodeMessage.textContent = "An error occurred. Please try again.";
            AgentCodeMessage.style.display = 'block';
            AgentCodeMessage.style.color = 'red';
        });
    }
</script>
@endsection
