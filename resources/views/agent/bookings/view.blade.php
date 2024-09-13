@extends('agent.layouts.main')
@php
    $pageTitle = 'View Booking';
@endphp
@section('main-container')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Booking / <strong class="text-primary small">{{ $booking->booking_id }}</strong></h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="list-inline">
                                        <li>Booking Date: <span class="text-base">{{ $booking->created_at }}</span></li>
                                        <li>Arrival Date: <span class="text-base">{{$booking->check_in_date->format('Y-m-d')}}</span></li>
                                        <li>Departure Date: <span class="text-base">{{$booking->check_out_date->format('Y-m-d')}}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="#" id="previous-page-link"
                                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Back</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-aside-wrap">
                                <div class="card-content scrollable_table">
                                    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tabRoomDetails"><em
                                                    class="icon ni ni-user-circle"></em><span>Room Details</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabGuestDetails"><em
                                                    class="icon ni ni-user-circle"></em><span>Guest Details</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabDocuments"><em
                                                    class="icon ni ni-file-text"></em><span>Documents</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabActivities"><em
                                                    class="icon ni ni-activity"></em><span>Activities</span></a>
                                        </li>
                                        <li class="nav-item nav-item-trigger d-xxl-none">
                                            <a href="#" class="toggle btn btn-icon btn-trigger"
                                                data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabInvoice"><em
                                                    class="icon ni ni-reports-alt"></em><span>Invoice</span></a>
                                        </li>
                                    </ul>
                                    <div class="card-inner">
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="tabRoomDetails">
                                                <div class="nk-block">
                                                <div class="nk-block-head">
                                                    <h5 class="title">Room Details</h5>
                                                    <button type="button" class="btn btn-outline-primary mt-2" onclick="window.open('/booking/payment/success?booking_id={{ $booking->booking_id }}', '_blank')">Download/Print Itinerary</button>
                                                </div>
                                                <div class="nk-block-head nk-block-head-line">
                                                    <h4 class="title fs-16px fw-bold">Total Rooms: {{ $totalRooms }}</h4>
                                                </div>
                                                {{-- Room Details --}}
                                                @if(!empty($roomDetails) && !empty($roomGuestDetails))
                                                    @foreach ($roomDetails as $index => $room)
                                                        @php
                                                            $guestDetails = $roomGuestDetails[$index] ?? [];
                                                            $RoomtotalGuests = 0;
                                                            foreach ($guestDetails as $key => $value) {
                                                                $RoomtotalGuests += (int)$value;
                                                            }
                                                        @endphp
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <h6 class="title overline-title text-base">Room {{ $index + 1 }} Details</h6>
                                                        </div>
                                                        <div class="profile-ud-list">
                                                            {{-- Room Name --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Room Name</span>
                                                                    <span class="profile-ud-value">{{ $room['room_name'] }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- Number of Guests --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Number of Guests</span>
                                                                    <span class="profile-ud-value">{{ $RoomtotalGuests }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    @endforeach
                                                @endif

                                                </div>

                                            </div>

                                            <div class="tab-pane" id="tabGuestDetails">
                                                <div class="nk-block">
                                                    <div class="nk-block-head">
                                                        <h5 class="title">Guest's Information</h5>
                                                    </div>

                                                    <div class="nk-block-head nk-block-head-line">
                                                        <h4 class="title fs-16px fw-bold">Total Guests: {{ $totalGuests }}</h4>
                                                    </div>

                                                    {{-- Adult Details --}}
                                                    @foreach ($adults as $index => $adult)
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <h6 class="title overline-title text-base">Adult
                                                                {{ $index + 1 }} Details</h6>
                                                        </div>
                                                        <div class="profile-ud-list">
                                                            {{-- Full Name --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Full Name</span>
                                                                    <span class="profile-ud-value">{{ ucfirst($adult->first_name) }}
                                                                        {{ ucfirst($adult->last_name) }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- Date of Birth --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Date of Birth</span>
                                                                    <span
                                                                        class="profile-ud-value">{{ $adult->date_of_birth->format('Y-m-d') }},
                                                                        {{ $adult->age }} years</span>
                                                                </div>
                                                            </div>
                                                            {{-- Mobile Number --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Mobile Number</span>
                                                                    <span
                                                                        class="profile-ud-value">{{ $adult->phone_number }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- Email Address --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Email Address</span>
                                                                    <span
                                                                        class="profile-ud-value">{{ ucfirst($adult->email) }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- ID/Passport No. --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">ID /Passport No.</span>
                                                                    <span
                                                                        class="profile-ud-value">{{ $adult->id_number }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- Address --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Address</span>
                                                                    <span class="profile-ud-value">{{ $adult->city }},
                                                                        {{ $adult->state }}, {{ $adult->zip_code }} -
                                                                        {{ $adult->country }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    @endforeach
                                                    <br>
                                                    {{-- Children Details, if any --}}
                                                    @if ($children->isNotEmpty())
                                                        @foreach ($children as $index => $child)
                                                            <div class="nk-block-head nk-block-head-line">
                                                                <h6 class="title overline-title text-base">Children
                                                                    {{ $index + 1 }} Details</h6>
                                                            </div>
                                                            <div class="profile-ud-list">
                                                                {{-- Full Name --}}
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Full Name</span>
                                                                        <span
                                                                            class="profile-ud-value">{{ ucfirst($child->first_name) }}
                                                                            {{ ucfirst($child->last_name) }}</span>
                                                                    </div>
                                                                </div>
                                                                {{-- Date of Birth --}}
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Date of Birth</span>
                                                                        <span
                                                                            class="profile-ud-value">{{ $child->date_of_birth->format('Y-m-d') }},
                                                                            {{ $child->age }} years</span>
                                                                    </div>
                                                                </div>
                                                                {{-- Mobile Number --}}
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Mobile Number</span>
                                                                        <span
                                                                            class="profile-ud-value">{{ $child->phone_number }}</span>
                                                                    </div>
                                                                </div>
                                                                {{-- Email Address --}}
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Email Address</span>
                                                                        <span
                                                                            class="profile-ud-value">{{ ucfirst($child->email) }}</span>
                                                                    </div>
                                                                </div>
                                                                {{-- ID/Passport No. --}}
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">ID /Passport
                                                                            No.</span>
                                                                        <span
                                                                            class="profile-ud-value">{{ $child->id_number }}</span>
                                                                    </div>
                                                                </div>
                                                                {{-- Address --}}
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Address</span>
                                                                        <span
                                                                            class="profile-ud-value">{{ $child->city }},
                                                                            {{ $child->state }}, {{ $child->zip_code }} -
                                                                            {{ $child->country }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        @endforeach
                                                    @endif
                                                    <br>
                                                    {{-- Kids Details, if any --}}
                                                    @if ($kids->isNotEmpty())
                                                    @foreach ($kids as $index => $kid)
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <h6 class="title overline-title text-base">Kids {{ $index + 1 }} Details</h6>
                                                        </div>
                                                        <div class="profile-ud-list">
                                                            {{-- Full Name --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Full Name</span>
                                                                    <span class="profile-ud-value">{{ ucfirst($kid->first_name) }} {{ ucfirst($kid->last_name) }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- Date of Birth --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Date of Birth</span>
                                                                    <span class="profile-ud-value">{{ $kid->date_of_birth->format('Y-m-d') }}, {{ $kid->age }} years</span>
                                                                </div>
                                                            </div>
                                                            {{-- Mobile Number --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Mobile Number</span>
                                                                    <span class="profile-ud-value">{{ $kid->phone_number }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- Email Address --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Email Address</span>
                                                                    <span class="profile-ud-value">{{ ucfirst($kid->email) }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- ID/Passport No. --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">ID /Passport No.</span>
                                                                    <span class="profile-ud-value">{{ $kid->id_number }}</span>
                                                                </div>
                                                            </div>
                                                            {{-- Address --}}
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Address</span>
                                                                    <span class="profile-ud-value">{{ $kid->city }}, {{ $kid->state }}, {{ $kid->zip_code }} - {{ $kid->country }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        @endforeach
                                                    @endif
                                                    <br>
                                                </div>
                                                <div class="nk-divider divider md"></div>
                                            </div>

                                            <div class="tab-pane" id="tabDocuments">
                                                <h4>Uploaded Documents</h4>
                                                <br>
                                                @forelse($adults as $adult)
                                                    <div class="nk-block">
                                                        <h6 class="title">Adult {{ $loop->index + 1 }} -
                                                            {{ ucfirst($adult->first_name) }} {{ ucfirst($adult->last_name) }}</h6>
                                                        @php
                                                            $docPath = $documents
                                                                ->where('member_id', $adult->id)
                                                                ->first();
                                                        @endphp

                                                        @if ($docPath)
                                                            <p>ID/Passport:
                                                                <a href="{{ Storage::disk('public')->url($docPath->id_document_path) }}"
                                                                    target="_blank">View Document</a>
                                                            </p>
                                                            <p>Scuba Diving License:
                                                                @if ($docPath->license_document_path)
                                                                    <a href="{{ Storage::disk('public')->url($docPath->license_document_path) }}"
                                                                        target="_blank">View License</a>
                                                                @else
                                                                    No License uploaded.
                                                                @endif
                                                            </p>
                                                        @else
                                                            <p>No documents uploaded.</p>
                                                        @endif
                                                    </div>
                                                    <div class="nk-divider divider md"></div>
                                                @empty
                                                    <p>No family members found.</p>
                                                @endforelse
                                            </div>

                                            <div class="tab-pane" id="tabActivities">
                                                <!-- Table for Additional Services -->
                                                <h5>Additional Services</h5>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Service Name</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Loop through the additional services --}}
                                                        @php
                                                            $additionalServices = json_decode(
                                                                $booking->additional_services,
                                                                true,
                                                            );
                                                            // Continue the serial number from where it left off
                                                            $serialNumberAddon = 1;
                                                        @endphp
                                                        @foreach ($additionalServices as $service)
                                                            <tr>
                                                                <th scope="row">{{ $serialNumberAddon++ }}</th>
                                                                <td>{{ $service['name'] }}</td>
                                                                <td>{{ $service['quantity'] }}</td>
                                                                <td>RM{{ number_format($service['price'], 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="nk-divider divider md"></div>
                                                <!-- Table for Included Services -->
                                                <h5>Included Services</h5>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Service Name</th>
                                                            <th scope="col">Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Loop through the included services --}}
                                                        @php
                                                            $includedServices = json_decode(
                                                                $booking->included_services,
                                                                true,
                                                            );
                                                            $serialNumber = 1;
                                                        @endphp
                                                        @foreach ($includedServices as $service)
                                                            <tr>
                                                                <th scope="row">{{ $serialNumber++ }}</th>
                                                                <td>{{ $service['name'] }}</td>
                                                                <td>{{ $service['quantity'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <div class="nk-divider divider md"></div>
                                                <h5>Activity Assignment</h5>
                                                <table style="width: 100%; border-collapse: collapse;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%; text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Guest Name</th>
                                                            <th style="width: 80%; text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Guest Activities</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($activityDetails as $guestName => $services)
                                                            <tr>
                                                                <td style="border-bottom: 1px solid #ddd; padding: 8px;">{{ $guestName }}</td>
                                                                <td style="border-bottom: 1px solid #ddd; padding: 8px;">
                                                                    @foreach ($services as $service => $quantity)
                                                                        {{ $service }} ({{ $quantity }}),
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="tab-pane" id="tabInvoice">
                                                <div class="nk-block">
                                                    <div class="printable">
                                                        <div class="invoice">
                                                            <div class="invoice-action hide-on-print">
                                                                <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary"
                                                                    href="#" onclick="window.print();" return false;">
                                                                    <em class="icon ni ni-printer-fill"></em>
                                                                </a>
                                                            </div>
                                                            <div class="invoice-wrap">
                                                                <div class="invoice-brand"><img
                                                                        src="{{ url('admin/images/logo-black.svg') }}"
                                                                        alt="logo"></div>
                                                                <div class="invoice-head">
                                                                    <div class="invoice-contact">
                                                                        <div class="invoice-contact-info">
                                                                            <h4 class="title">The Rock Resorts</h4>
                                                                            <ul class="list-plain">
                                                                                <li><em
                                                                                        class="icon ni ni-map-pin-fill"></em><span>Pulau
                                                                                        Aur, 86800 Mersing<br>Johor,
                                                                                        Malaysia</span></li>
                                                                                <li><em
                                                                                        class="icon ni ni-call-fill"></em><span>+60
                                                                                        126 289 056</span></li>
                                                                                <li><em
                                                                                        class="icon ni ni-shield-check-fill"></em><span>1315334-K</span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="invoice-desc">
                                                                        <h3 class="title">
                                                                            {{ ucfirst($booking->main_guest_first_name) }}
                                                                            {{ ucfirst($booking->main_guest_last_name) }}
                                                                        </h3>
                                                                        <ul class="list-plain">
                                                                            <li class="invoice-id"><span>Booking
                                                                                    ID</span>:<span>{{ $booking->booking_id }}</span>
                                                                            </li>
                                                                            <li class="invoice-date">
                                                                                <span>Date</span>:<span>{{ $booking->created_at->format('Y-m-d') }}</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="invoice-bills">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="w-150px">S.No</th>
                                                                                    <th class="w-60">Description</th>
                                                                                    <th>Price</th>
                                                                                    <th>Qty</th>
                                                                                    <th>Amount</th>
                                                                                </tr>
                                                                            </thead>
                                                                            @php
                                                                                $serialNumber = 1; // Initialize a separate counter for S.NO
                                                                            @endphp

                                                                            <tbody>
                                                                                {{-- Display the package first --}}
                                                                                <tr>
                                                                                    <td>{{ $serialNumber++ }}</td>
                                                                                    <td>{{ $booking->package_name }}</td>
                                                                                    <td>RM{{ number_format($booking->package_charges, 2) }}
                                                                                    </td>
                                                                                    <td>1</td>
                                                                                    <td>RM{{ number_format($booking->package_charges, 2) }}
                                                                                    </td>
                                                                                </tr>

                                                                                {{-- Decode and loop through the additional_services --}}
                                                                                @php
                                                                                    $additionalServices = json_decode(
                                                                                        $booking->additional_services,
                                                                                        true,
                                                                                    );
                                                                                @endphp

                                                                                @foreach ($additionalServices as $service)
                                                                                    <tr>
                                                                                        <td>{{ $serialNumber++ }}</td>
                                                                                        <td>Additional Service -
                                                                                            {{ $service['name'] }}</td>
                                                                                        <td>RM{{ number_format($service['price'], 2) }}
                                                                                        </td>
                                                                                        <td>{{ $service['quantity'] }}</td>
                                                                                        <td>RM{{ number_format($service['price'] * $service['quantity'], 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                            <tfoot>
                                                                                @if ($booking->package_charges > 0)
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td colspan="2">Package Charges
                                                                                        </td>
                                                                                        <td>RM{{ number_format($booking->package_charges, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($booking->discount_amt > 0)
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td colspan="2">
                                                                                            Discount{{ $booking->coupon_code ? ' (' . $booking->coupon_code . ')' : '' }}
                                                                                        </td>
                                                                                        <td>-RM{{ number_format($booking->discount_amt, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($booking->additional_services_total > 0)
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td colspan="2">Additional
                                                                                            Services Total</td>
                                                                                        <td>RM{{ number_format($booking->additional_services_total, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($booking->marine_fee > 0)
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td colspan="2">Marine Fees</td>
                                                                                        <td>RM{{ number_format($booking->marine_fee, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($booking->total_surcharge_amount > 0)
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td colspan="2">Total Surcharge
                                                                                        </td>
                                                                                        <td>RM{{ number_format($booking->total_surcharge_amount, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($booking->sub_total > 0)
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td class="make_it_bold"
                                                                                            colspan="2">Sub Total</td>
                                                                                        <td>RM{{ number_format($booking->sub_total, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($booking->service_charge > 0)
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td colspan="2">Service Charge
                                                                                        </td>
                                                                                        <td>RM{{ number_format($booking->service_charge, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($booking->tax > 0)
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td colspan="2">TAX</td>
                                                                                        <td>RM{{ number_format($booking->tax, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                <tr>
                                                                                    <td colspan="2"></td>
                                                                                    <td colspan="2">Net Total</td>
                                                                                    <td>RM{{ number_format($booking->net_total, 2) }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                        <div class="nk-notes ff-italic fs-12px text-soft">
                                                                            Invoice was created on a computer and is valid
                                                                            without the signature and seal. </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl"
                                    data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true"
                                    data-toggle-body="true">
                                    <div class="card-inner-group" data-simplebar>
                                        <div class="card-inner">
                                            <div class="user-card user-card-s2">
                                                <div class="user-avatar lg bg-primary">
                                                    <div class="user-avatar lg bg-primary">
                                                        <span>
                                                            {{ strtoupper(substr($booking->main_guest_first_name, 0, 1)) . strtoupper(substr($booking->main_guest_last_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="user-info">
                                                    <h5>{{ ucfirst($booking->main_guest_first_name) }}
                                                        {{ ucfirst($booking->main_guest_last_name) }}</h5>
                                                    <span
                                                        class="sub-text">{{ ucfirst($booking->main_guest_email) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-inner">
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="profile-stats"><span class="amount">{{$totalAdults}}</span><span class="sub-text">Total Adults</span></div>
                                                 </div>
                                                 <div class="col-4">
                                                    <div class="profile-stats"><span class="amount">{{$totalChildren}}</span><span class="sub-text">Total Children</span></div>
                                                 </div>
                                                 <div class="col-4">
                                                    <div class="profile-stats"><span class="amount">{{$totalToddlers}}</span><span class="sub-text">Total Toddler</span></div>
                                                 </div>
                                                 <div class="col-4">
                                                   <div class="profile-stats"><span class="amount">{{$totalKids}}</span><span class="sub-text">Total Kids</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-inner">
                                            <h6 class="overline-title-alt mb-2">Additional</h6>
                                            <div class="row g-3">
                                                <div class="col-6"><span class="sub-text">Payment Status:</span>
                                                    <span
                                                        class="lead-text {{ 'status-' . strtolower($booking->payment_status) }}">
                                                        {{ ucfirst($booking->payment_status) }}
                                                    </span>
                                                </div>
                                                <div class="col-6"><span class="sub-text">Booking Status:</span>
                                                    <span
                                                        class="lead-text {{ $statusClasses[$booking->booking_status] ?? 'text-secondary' }}">
                                                        {{ ucfirst($booking->booking_status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Add Admin Note-->
    <div class="modal fade" tabindex="-1" role="dialog" id="add-admin_note">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Add Private Notes</h5>
                    <!-- Update the action attribute to point to your store route -->
                    <form action="{{ route('admin.notes.private', ['bookingId' => $booking->id]) }}" method="POST"
                        class="mt-2">
                        @csrf
                        <div class="row g-gs">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="room_name">Note</label>
                                    <textarea class="form-control" id="note" name="note" placeholder="Enter your note here" rows="4"></textarea> <!-- Change 'rows' as needed -->
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li>
                                        <!-- Updated type to submit -->
                                        <button type="submit" class="btn btn-primary">Add Note</button>
                                    </li>
                                    <li>
                                        <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- .modal-body -->
            </div>
            <!-- .modal-content -->
        </div>
        <!-- .modal-dialog -->
    </div>


@endsection
