@extends('user.layouts.main')
@php
    $pageTitle = "View Booking";
    $user = auth()->user();
@endphp
@section('main-container')
<div class="nk-content ">
    <div class="container-fluid">
       <div class="nk-content-inner">
          <div class="nk-content-body">
             <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                   <div class="nk-block-head-content">
                      <h3 class="nk-block-title page-title">Booking / <strong class="text-primary small">{{$booking->booking_id}}</strong></h3>
                      <div class="nk-block-des text-soft">
                         <ul class="list-inline">
                            <li>Booking Date: <span class="text-base">{{$booking->created_at}}</span></li>
                            <li>Arrival Date: <span class="text-base">{{$booking->check_in_date->format('Y-m-d')}}</span></li>
                            <li>Departure Date: <span class="text-base">{{$booking->check_out_date->format('Y-m-d')}}</span></li>
                         </ul>
                      </div>
                   </div>
                   <div class="nk-block-head-content">
                        <a href="#" id="previous-page-link" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
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
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabRoomDetails"><em class="icon ni ni-user-circle"></em><span>Room Details</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabGuestDetails"><em class="icon ni ni-user-circle"></em><span>Guest Details</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabDocuments"><em class="icon ni ni-file-text"></em><span>Documents</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabSupport"><em class="icon ni ni-chat-circle"></em><span>Support</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabActivities"><em class="icon ni ni-activity"></em><span>Activities</span></a>
                            </li>
                            <li class="nav-item nav-item-trigger d-xxl-none">
                                <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabInvoice"><em class="icon ni ni-reports-alt"></em><span>Invoice</span></a>
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

                                    <div class="nk-divider divider md"></div>
                                </div>

                                <div class="tab-pane" id="tabGuestDetails">
                                    <div class="nk-block">
                                    <div class="nk-block-head">
                                        <h5 class="title">Guest's Information</h5>
                                        <button type="button" class="btn btn-outline-primary mt-2" onclick="window.open('/booking/payment/success?booking_id={{ $booking->booking_id }}', '_blank')">Download/Print Itinerary</button>
                                    </div>
                                    <div class="nk-block-head nk-block-head-line">
                                        <h4 class="title fs-16px fw-bold">Total Guests: {{ $totalGuests }}</h4>
                                    </div>
                                    {{-- Adult Details --}}
                                    @foreach ($adults as $index => $adult)
                                        <div class="nk-block-head nk-block-head-line">
                                            <h6 class="title overline-title text-base">Adult {{ $index + 1 }} Details</h6>
                                        </div>
                                        <div class="profile-ud-list">
                                            {{-- Full Name --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Full Name</span>
                                                    <span class="profile-ud-value">{{ $adult->first_name }} {{ $adult->last_name }}</span>
                                                </div>
                                            </div>
                                            {{-- Date of Birth --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Date of Birth</span>
                                                    <span class="profile-ud-value">{{ $adult->date_of_birth->format('Y-m-d') }}, {{ $adult->age }} years</span>
                                                </div>
                                            </div>
                                            {{-- Mobile Number --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Mobile Number</span>
                                                    <span class="profile-ud-value">{{ $adult->phone_number }}</span>
                                                </div>
                                            </div>
                                            {{-- Email Address --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Email Address</span>
                                                    <span class="profile-ud-value">{{ ucfirst($adult->email) }}</span>
                                                </div>
                                            </div>
                                            {{-- ID/Passport No. --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">ID /Passport No.</span>
                                                    <span class="profile-ud-value">{{ $adult->id_number }}</span>
                                                </div>
                                            </div>
                                            {{-- Address --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Address</span>
                                                    <span class="profile-ud-value">{{ $adult->city }}, {{ $adult->state }}, {{ $adult->zip_code }} - {{ $adult->country }}</span>
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
                                            <h6 class="title overline-title text-base">Children {{ $index + 1 }} Details</h6>
                                        </div>
                                        <div class="profile-ud-list">
                                            {{-- Full Name --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Full Name</span>
                                                    <span class="profile-ud-value">{{ $child->first_name }} {{ $child->last_name }}</span>
                                                </div>
                                            </div>
                                            {{-- Date of Birth --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Date of Birth</span>
                                                    <span class="profile-ud-value">{{ $child->date_of_birth->format('Y-m-d') }}, {{ $child->age }} years</span>
                                                </div>
                                            </div>
                                            {{-- Mobile Number --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Mobile Number</span>
                                                    <span class="profile-ud-value">{{ $child->phone_number }}</span>
                                                </div>
                                            </div>
                                            {{-- Email Address --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Email Address</span>
                                                    <span class="profile-ud-value">{{ ucfirst($child->email) }}</span>
                                                </div>
                                            </div>
                                            {{-- ID/Passport No. --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">ID /Passport No.</span>
                                                    <span class="profile-ud-value">{{ $child->id_number }}</span>
                                                </div>
                                            </div>
                                            {{-- Address --}}
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Address</span>
                                                    <span class="profile-ud-value">{{ $child->city }}, {{ $child->state }}, {{ $child->zip_code }} - {{ $child->country }}</span>
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
                                                    <span class="profile-ud-value">{{ $kid->first_name }} {{ $kid->last_name }}</span>
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

                                <div class="tab-pane" id="tabInvoice">
                                    <div class="nk-block">
                                        <div class="printable">
                                            <div class="invoice">
                                                <div class="invoice-action hide-on-print">
                                                    <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="#" onclick="window.print();" return false;">
                                                      <em class="icon ni ni-printer-fill"></em>
                                                    </a>
                                                </div>
                                                <div class="invoice-wrap">
                                                   <div class="invoice-brand"><img src="{{url('admin/images/logo-black.svg')}}" alt="logo"></div>
                                                   <div class="invoice-head">
                                                      <div class="invoice-contact">
                                                         <div class="invoice-contact-info">
                                                            <h4 class="title">The Rock Resorts</h4>
                                                            <ul class="list-plain">
                                                               <li><em class="icon ni ni-map-pin-fill"></em><span>Pulau Aur, 86800 Mersing<br>Johor, Malaysia</span></li>
                                                               <li><em class="icon ni ni-call-fill"></em><span>+60 126 289 056</span></li>
                                                               <li><em class="icon ni ni-shield-check-fill"></em><span>1315334-K</span></li>
                                                            </ul>
                                                         </div>
                                                      </div>
                                                      <div class="invoice-desc">
                                                         <h3 class="title">{{ ucfirst($booking->main_guest_first_name) }} {{ ucfirst($booking->main_guest_last_name) }}</h3>
                                                         <ul class="list-plain">
                                                            <li class="invoice-id"><span>Booking ID</span>:<span>{{ $booking->booking_id}}</span></li>
                                                            <li class="invoice-date"><span>Date</span>:<span>{{ $booking->created_at->format('Y-m-d') }}</span></li>
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
                                                                    <td>RM{{ number_format($booking->package_charges, 2) }}</td>
                                                                    <td>1</td>
                                                                    <td>RM{{ number_format($booking->package_charges, 2) }}</td>
                                                                </tr>

                                                                {{-- Decode and loop through the additional_services --}}
                                                                @php
                                                                    $additionalServices = json_decode($booking->additional_services, true);
                                                                @endphp

                                                                @foreach ($additionalServices as $service)
                                                                    <tr>
                                                                        <td>{{ $serialNumber++ }}</td>
                                                                        <td>Additional Service - {{ $service['name'] }}</td>
                                                                        <td>RM{{ number_format($service['price'], 2) }}</td>
                                                                        <td>{{ $service['quantity'] }}</td>
                                                                        <td>RM{{ number_format($service['price'] * $service['quantity'], 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                @if ($booking->package_charges > 0)
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td colspan="2">Package Charges</td>
                                                                        <td>RM{{ number_format($booking->package_charges, 2) }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($booking->discount_amt > 0)
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td colspan="2">Discount{{ $booking->coupon_code ? ' (' . $booking->coupon_code . ')' : '' }}</td>
                                                                        <td>-RM{{ number_format($booking->discount_amt, 2) }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($booking->additional_services_total > 0)
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td colspan="2">Additional Services Total</td>
                                                                        <td>RM{{ number_format($booking->additional_services_total, 2) }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($booking->marine_fee > 0)
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td colspan="2">Marine Fees</td>
                                                                        <td>RM{{ number_format($booking->marine_fee, 2) }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($booking->total_surcharge_amount > 0)
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td colspan="2">Total Surcharge</td>
                                                                        <td>RM{{ number_format($booking->total_surcharge_amount, 2) }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($booking->sub_total > 0)
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td class="make_it_bold" colspan="2">Sub Total</td>
                                                                        <td>RM{{ number_format($booking->sub_total, 2) }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($booking->service_charge > 0)
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td colspan="2">Service Charge</td>
                                                                        <td>RM{{ number_format($booking->service_charge, 2) }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($booking->tax > 0)
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td colspan="2">TAX</td>
                                                                        <td>RM{{ number_format($booking->tax, 2) }}</td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="2">Net Total</td>
                                                                    <td>RM{{ number_format($booking->net_total, 2) }}</td>
                                                                </tr>
                                                            </tfoot>
                                                         </table>
                                                         <div class="nk-notes ff-italic fs-12px text-soft"> Invoice was created on a computer and is valid without the signature and seal. </div>
                                                      </div>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tabDocuments">
                                    <div class="nk-block-head">
                                        <h5 class="title">Upload Documents</h5>
                                    </div>
                                    <form action="{{ route('booking.uploadIdDocuments', $booking->booking_id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            @foreach ($adults as $index => $adult)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="idDocument{{ $adult->id }}">
                                                            Adult {{ $index + 1 }} ID/Passport ({{ ucfirst($adult->first_name) }} {{ ucfirst($adult->last_name) }})
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-file">
                                                                <input type="file" class="form-file-input" id="idDocument{{ $adult->id }}" name="idDocument{{ $adult->id }}"
                                                                    data-max-files="1"
                                                                    data-max-file-size="5"
                                                                    data-accepted-files=".jpg, .jpeg, .png"
                                                                    accept=".jpg, .jpeg, .png">
                                                                <label class="form-file-label" for="idDocument{{ $adult->id }}">Choose file</label>
                                                            </div>
                                                            @php
                                                                $docPath = $documentsMap->get($adult->id)['id_path'] ?? null;
                                                                $adjustedDocPath = $docPath ? Str::replaceFirst('public/', '', $docPath) : null;
                                                            @endphp

                                                            @if($adjustedDocPath && Storage::disk('public')->exists($adjustedDocPath))
                                                                <div class="text-success">
                                                                    ID Uploaded: {{ basename($adjustedDocPath) }}
                                                                </div>
                                                            @else
                                                                <div class="text-danger">
                                                                    No ID uploaded.
                                                                </div>
                                                            @endif
                                                            <br>
                                                            <span style="font-weight: bold">Supported Files: JPG / PNG / JPEG</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($index % 2 != 0)
                                                    </div><div class="row">
                                                @endif
                                            @endforeach
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-2">Submit Document</button>
                                    </form>


                                    <div class="nk-divider divider md"></div>

                                    <div class="nk-block-head">
                                        <h5 class="title">Diving License Upload (optional)</h5>
                                    </div>

                                    <form action="{{ route('booking.uploadScubaDivingDocuments', $booking->booking_id) }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            @foreach ($adults as $index => $adult)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="divingLicense{{ $adult->id }}">
                                                        Scuba Diving License ({{ ucfirst($adult->first_name) }} {{ ucfirst($adult->last_name) }})
                                                    </label>
                                                    <div class="form-control-wrap">
                                                        <input type="hidden" name="memberId{{ $adult->id }}" value="{{ $adult->id }}">
                                                        <div class="form-file">
                                                            <input type="file" class="form-file-input" id="divingLicense{{ $adult->id }}" name="divingLicense{{ $adult->id }}"
                                                                   data-max-files="1"
                                                                   data-max-file-size="5"
                                                                   data-accepted-files=".jpg, .jpeg, .png"
                                                                   accept=".jpg, .jpeg, .png">
                                                            <label class="form-file-label" for="divingLicense{{ $adult->id }}">Choose file</label>
                                                        </div>
                                                        @php
                                                            $licensePath = $documentsMap->get($adult->id)['license_path'] ?? null;
                                                            $adjustedLicensePath = $licensePath ? Str::replaceFirst('public/', '', $licensePath) : null;
                                                        @endphp

                                                        @if($adjustedLicensePath && Storage::disk('public')->exists($adjustedLicensePath))
                                                            <div class="text-success">
                                                                License Uploaded: {{ basename($adjustedLicensePath) }}
                                                            </div>
                                                        @else
                                                            <div class="text-danger">
                                                                No License uploaded.
                                                            </div>
                                                        @endif
                                                        <br>
                                                        <span style="font-weight: bold">Supported Files: JPG / PNG / JPEG</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($index % 2 == 1)
                                                </div><div class="row mt-4">
                                            @endif
                                        @endforeach

                                        </div>

                                        <button type="submit" class="btn btn-primary mt-2">Submit Licenses</button>
                                    </form>
                                </div>

                                <div class="tab-pane" id="tabSupport" style="white-space: normal;">
                                    <h4>Support Messages</h4>
                                    <div class="nk-chat-panel" style="height: 400px">
                                        @forelse  ($messages as $message)
                                        <div class="chat {{ $message->author_type === 'admin' ? 'is-you' : 'is-me' }}">
                                            @if ($message->author_type === 'admin')
                                                <div class="chat-avatar">
                                                    <!-- Adjust the initials for Customer Support as needed -->
                                                    <div class="user-avatar bg-purple"><span>CS</span></div>
                                                </div>
                                            @endif
                                            <div class="chat-content">
                                                <div class="chat-bubbles">
                                                    <div class="chat-bubble">
                                                        <div class="chat-msg">{{ $message->content }}</div>
                                                    </div>
                                                </div>
                                                <ul class="chat-meta">
                                                    <li>{{ $message->author_type === 'admin' ? 'Customer Support' : $message->author->first_name . ' ' . $message->author->last_name }}</li>
                                                    <li>{{ $message->created_at->format('d M, Y H:i A') }}</li>
                                                </ul>
                                            </div>
                                            @if ($message->author_type === 'customer')
                                                <div class="chat-avatar">
                                                    <!-- Assume you have a method to get the first two initials of the customer -->
                                                    <div class="user-avatar bg-purple">
                                                        <span>{{ strtoupper(substr($message->author->first_name, 0, 1)) . strtoupper(substr($message->author->last_name, 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="no-messages">
                                            <p>No messages found.</p>
                                        </div>
                                    @endforelse

                                    </div>
                                    <br>
                                    <form id="messageForm" action="{{ route('booking.postMessage', $booking->booking_id) }}" method="POST">
                                        @csrf
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <input style="border-bottom: 1px solid #816bff; border-radius: 0;" type="text" name="content" class="form-control form-control-simple" placeholder="Type your message..." required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary btn-dim" type="submit">Send</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="nk-divider divider md"></div>
                                </div>

                                <div class="tab-pane" id="tabActivities">
                                    <!-- Table for Additional Services -->
                                    <h5>Additional Services <a href="#add-services" data-bs-toggle="modal"  class="btn btn-outline-primary">Add More Services</a></h5>
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
                                                $additionalServices = json_decode($booking->additional_services, true);
                                                $serialNumber = 1;
                                            @endphp
                                            @foreach ($additionalServices as $service)
                                                <tr>
                                                    <th scope="row">{{ $serialNumber++ }}</th>
                                                    <td>{{ $service['name'] }}</td>
                                                    <td>{{ $service['quantity'] }}</td>
                                                    <td>RM{{ number_format($service['price'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
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
                                                $includedServices = json_decode($booking->included_services, true);
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
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
                                         <h5>{{ucfirst($booking->main_guest_first_name)}} {{ucfirst($booking->main_guest_last_name)}}</h5>
                                         <span class="sub-text">{{ucfirst($booking->main_guest_email)}}</span>
                                      </div>
                                   </div>
                                </div>
                                <div class="card-inner card-inner-sm">
                                   <ul class="btn-toolbar justify-center gx-1">
                                        <li>
                                            <form action="{{ route('resendBooking.confirmation', ['booking_id' => $booking->booking_id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-trigger btn-icon" aria-label="Resend Confirmation" onclick="return confirm('Are you sure you want to resend the confirmation?');">
                                                    <em class="icon ni ni-mail"></em>
                                                </button>
                                            </form>
                                        </li>
                                   </ul>
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
                                        <span class="lead-text {{ 'status-' . strtolower($booking->payment_status) }}">
                                            {{ ucfirst($booking->payment_status) }}
                                        </span>
                                    </div>
                                    <div class="col-6"><span class="sub-text">Booking Status:</span>
                                        <span class="lead-text {{ $statusClasses[$booking->booking_status] ?? 'text-secondary' }}">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </div>
                                   </div>
                                </div>
                                @if(in_array($booking->payment_status, ['Failed', 'Pending']) && $booking->booking_status == 'Pending For Payment' && $booking->check_in_date->isFuture())
                                    <div class="card-inner">
                                       <h6 class="overline-title-alt mb-3">Retry Payment</h6>
                                       <form action="{{ route('retryBooking.payment', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Retry Payment</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                    </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>


<!-- Add Servcies-->
<div class="modal fade" tabindex="-1" role="dialog" id="add-services">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="modal-title">Choose Service you want to add in your booking</h5>
                <form id="servicesForm" action="{{ route('booking.add-services', ['booking_id' => $booking->booking_id]) }}" method="POST">
                    @csrf  <!-- CSRF token for security -->
                    <div class="services-container">
                        <!-- Service row will be added dynamically here -->
                    </div>
                    <p class="text-primary mt-3" style="cursor: pointer;" id="addServiceText">Add Another</p>
                    <p class="mt-3">Total Cost: <span id="totalCost">RM 0</span></p>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="checkoutBtn">Checkout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const services = @json($addonServicesWithPrice); // Assumes $addonServicesWithPrice is passed from Laravel
        const servicesForm = document.getElementById('servicesForm');
        const servicesContainer = document.querySelector('.services-container');
        const addServiceText = document.getElementById('addServiceText');
        const totalCostSpan = document.getElementById('totalCost');
        let totalCost = 0;

        // Add hidden input for total cost
        const totalCostInput = document.createElement('input');
        totalCostInput.type = 'hidden';
        totalCostInput.name = 'totalCost';
        servicesForm.appendChild(totalCostInput);

        addServiceText.addEventListener('click', addServiceRow);

        // Ensure at least one row on load
        addServiceRow();

        function addServiceRow() {
            const index = servicesContainer.children.length; // Get the current index based on existing children
            const serviceRow = document.createElement('div');
            serviceRow.className = 'd-flex align-items-center mb-3 mt-4';
            serviceRow.innerHTML = `
                <div class="col-sm-6">
                    <label class="form-label">Choose Service</label>
                    <select class="form-control service-select" name="services[${index}][id]">
                        ${services.map(service => `
                            <option value="${service.id}" data-price="${service.price}" data-name="${service.name}">
                                ${service.name} - RM ${service.price}
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div class="col-sm-4" style="margin-left:25px">
                    <label class="form-label">Qty</label>
                    <input type="number" class="form-control service-quantity" name="services[${index}][quantity]" value="1" min="1">
                </div>
                <div class="col-sm-2">
                    <em class="icon ni ni-trash-fill text-danger"></em>
                </div>
                <!-- Hidden inputs to store the service name and price -->
                <input type="hidden" name="services[${index}][name]" value="${services[0].name}">
                <input type="hidden" name="services[${index}][price]" value="${services[0].price}">
            `;
            servicesContainer.appendChild(serviceRow);
            attachEventListeners(serviceRow, index);
            updateTotalCost(); // Update total cost immediately after adding a new row
        }

        function updateServiceDetails(selectElement, index) {
            const selectedOption = selectElement.selectedOptions[0];
            const serviceName = selectedOption.getAttribute('data-name');
            const servicePrice = selectedOption.getAttribute('data-price');

            const hiddenInputName = document.querySelector(`input[name="services[${index}][name]"]`);
            hiddenInputName.value = serviceName;

            const hiddenInputPrice = document.querySelector(`input[name="services[${index}][price]"]`);
            hiddenInputPrice.value = servicePrice;

            updateTotalCost(); // Update total cost when service selection changes
        }

        function attachEventListeners(serviceRow, index) {
            const selectElement = serviceRow.querySelector('.service-select');
            selectElement.addEventListener('change', () => updateServiceDetails(selectElement, index));

            const quantityInput = serviceRow.querySelector('.service-quantity');
            quantityInput.addEventListener('input', updateTotalCost); // Update total cost when quantity changes

            // Logic for handling events like removing the row or updating the cost
            const trashIcon = serviceRow.querySelector('.ni-trash-fill');
            trashIcon.addEventListener('click', function () {
                serviceRow.remove();
                updateTotalCost();
            });
        }

        function updateTotalCost() {
            totalCost = Array.from(servicesContainer.querySelectorAll('.d-flex')).reduce((total, row) => {
                const price = parseFloat(row.querySelector('.service-select').selectedOptions[0].dataset.price);
                const quantity = parseInt(row.querySelector('.service-quantity').value) || 0;
                return total + (price * quantity);
            }, 0);
            totalCostSpan.textContent = `RM ${totalCost.toFixed(2)}`;
            totalCostInput.value = totalCost.toFixed(2);
        }
    });
</script>



@endsection
