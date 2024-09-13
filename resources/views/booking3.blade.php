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
        @if(!empty($FinalBookingData))

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <strong>Check-in - Check-out:</strong>
                        <p style="font-weight: 500">{{ $FinalBookingData['cookieData']['nights'] ?? 'N/A' }} Nights, {{ $FinalBookingData['cookieData']['check_in_check_out'] ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <strong>Package Name:</strong>
                        <p>{{ ucfirst($FinalBookingData['cookieData']['package_name']) ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <strong>Selected Rooms:</strong>
                        <ul style="padding-left: 0px">
                            @for ($i = 1; $i <= $FinalBookingData['cookieData']['no_of_rooms']; $i++)
                                <li>{{ $i }} - {{ $FinalBookingData['cookieData']["room_{$i}_name"] ?? 'N/A' }}</li>
                            @endfor
                        </ul>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <strong>Rooms Details:</strong>
                        @for ($i = 1; $i <= $FinalBookingData['cookieData']['no_of_rooms']; $i++)
                        <li>
                            {{ $FinalBookingData['cookieData']["room_{$i}_name"] ?? 'N/A' }} -
                            @if ($FinalBookingData['cookieData']["room_{$i}_adults"] > 0)
                                Adults: {{ $FinalBookingData['cookieData']["room_{$i}_adults"] }}
                            @endif
                            @if ($FinalBookingData['cookieData']["room_{$i}_children"] > 0)
                                , Children: {{ $FinalBookingData['cookieData']["room_{$i}_children"] }}
                            @endif
                            @if ($FinalBookingData['cookieData']["room_{$i}_kids"] > 0)
                                , Kids: {{ $FinalBookingData['cookieData']["room_{$i}_kids"] }}
                            @endif
                            @if ($FinalBookingData['cookieData']["room_{$i}_toddlers"] > 0)
                                , Toddlers: {{ $FinalBookingData['cookieData']["room_{$i}_toddlers"] }}
                            @endif
                        </li>
                        @endfor
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <strong>Services Included:</strong>
                        @foreach ($FinalBookingData['cookieData']['included_services'] as $index => $service)
                                <div class="service-item" style="text-align:left;">
                                    <span>
                                        {{ $index + 1 }} - {{ $service['name'] }} x {{ $service['quantity'] }} Qty
                                    </span>
                                </div>
                        @endforeach
                    </div>
                    <div class="col-12 col-md-6 col-lg-2 additional_service">
                        <strong>Additional Services:</strong>
                        @if (!empty($FinalBookingData['cookieData']['additional_services']))
                            @foreach ($FinalBookingData['cookieData']['additional_services'] as $id => $service)
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
                        <p style="font-weight: 500">RM {{ $FinalBookingData['requestData']['netTotal'] ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <hr>

            <div class="additional_service ">
                <form action="{{ route('payment.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="netTotal" value="{{ $FinalBookingData['requestData']['netTotal'] }}">
                    <input type="hidden" name="packageName" value="{{ $FinalBookingData['cookieData']['package_name'] }}">
                                    
                    <!-- Additional Section for Choosing Main Guest -->
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <strong>Choose Main Guest:</strong>
                        @if(!empty($memberNames))
                            @foreach($memberNames as $id => $memberDetails)
                                @if($memberDetails['age'] >= 13)
                                    <div class="d-flex items-center mb-2 mt-2">
                                        <div class="form-radio">                                            
                                            <input type="radio" required name="mainGuest" value="{{ $id }}" style="margin-right: 5px;" {{ old('mainGuest') == $id ? 'checked' : '' }}>
                                            <div class="form-radio__mark">
                                                <div class="form-radio__icon">
                                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-14 lh-12 ml-10">
                                            {{ $memberDetails['firstName'] }} {{ $memberDetails['lastName'] }}, {{ $memberDetails['age'] }} years
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p>No Member found</p>
                        @endif
                    </div>
                    
                    <br>
                    <hr>

                    <!-- Service Assignment Section -->
                    <div>
                        <strong>Assign Services to Guests:</strong>
                        @php
                            // Retrieve enabled services
                            $enabledServices = $enabledServices ?? []; // Ensure $enabledServices is available
                            $includedServices = $FinalBookingData['cookieData']['included_services'];
                            $additionalServices = $FinalBookingData['cookieData']['additional_services'];
                        
                            // Merge and filter services
                            $services = [];
                            foreach (array_merge($includedServices, $additionalServices) as $service) {
                                if (in_array($service['name'], $enabledServices)) {
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
                                            @for ($i = 0; $i < count($memberNames); $i++)
                                                <div class="custom-assignment-row">
                                                    <select name="activity_assignment[{{ $service['name'] }}][{{ $i }}][guest]" class="form-control">
                                                        @foreach($memberNames as $id => $memberDetails)
                                                            <option value="{{ $id }}">{{ $memberDetails['firstName'] }} {{ $memberDetails['lastName'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="number" name="activity_assignment[{{ $service['name'] }}][{{ $i }}][quantity]" min="0" max="{{ $service['quantity'] }}" value="{{ old('activity_assignment.' . $service['name'] . '.' . $i . '.quantity', 0) }}" class="form-control">
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
                                            @for ($i = 0; $i < count($memberNames); $i++)
                                                <div class="custom-assignment-row">
                                                    <select name="activity_assignment[{{ $service['name'] }}][{{ $i }}][guest]" class="form-control">
                                                        @foreach($memberNames as $id => $memberDetails)
                                                            <option value="{{ $id }}">{{ $memberDetails['firstName'] }} {{ $memberDetails['lastName'] }}</option>
                                                        @endforeach
                                                    </select>                                                    
                                                    <input type="number" name="activity_assignment[{{ $service['name'] }}][{{ $i }}][quantity]" min="0" max="{{ $service['quantity'] }}" value="{{ old('activity_assignment.' . $service['name'] . '.' . $i . '.quantity', 0) }}" class="form-control">
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
                    <div class="d-flex items-center mb-2 mt-2">
                        <div class="form-checkbox">                                            
                            <input type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
                            <div class="form-checkbox__mark">
                                <div class="form-checkbox__icon">
                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="text-14 lh-12 ml-10">
                            I agree with The <a style="color: #0011ff" href="{{ route('terms.index') }}" target="_blank">Rock Resorts Terms and Conditions.</a>
                        </div>
                    </div>
                    
                    <button class="button-20" style="margin-top:15px;">Click to Pay</button>
                </form>
            </div>

        @else
            <p>Booking Timeout, Please Do the booking again.</p>
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
