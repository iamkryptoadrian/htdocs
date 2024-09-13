@extends('layouts.main2')
@php
    $pageTitle = "Booking Confirmed";
    $user = Auth::user();
@endphp
@section('main-container')
<style>

  /*--------------------------------------------------------------------------------*/
  .payment-room > .row {
    margin-left: 0px;
    margin-right: 0px;
  }
  .payment-room > .row > [class*="col-"] {
    padding-left: 30px;
    padding-right: 30px;
  }
  .payment-room .payment-info {
    margin-top: 30px;
  }
  .payment-room .payment-info h2 {
    color: #111111;
    font-size: 34px;
    line-height: 36px;
    font-weight: 300;
    margin: 0;
  }
  .payment-room .payment-info .star-room {
    color: #59c45a;
    font-size: 12px;
    display: block;
    margin-top: 10px;
  }
  .payment-room .payment-info .star-room i {
    margin-right: 2px;
  }
  .payment-room .payment-info ul {
    margin: 10px 0 0 0;
    padding: 0;
    list-style: none;
  }
  .payment-room .payment-info ul li {
    position: relative;
    color: #333333;
    font-family: 'Open sans';
    padding-left: 110px;
    line-height: 30px;
  }
  .payment-room .payment-info ul li span {
    position: absolute;
    left: 0;
    top: 0;
    font-weight: 600;
  }
  .payment-room .payment-price {
    margin-top: 45px;
    border: 1px solid #e8e8e8;
    background-color: #fbfbfb;
    font-family: 'Open sans';
    overflow: hidden;
  }
  .payment-room .payment-price figure {
    width: 270px;
    float: left;
  }
  .payment-room .payment-price figure img {
    max-width: 100%;
    border-radius: 5px;
    height: 160px;
  }
  .payment-room .payment-price .total-trip {
    padding: 20px;
  }
  .payment-room .payment-price .total-trip span {
    font-weight: 600;
    line-height: 26px;
    display: block;
    font-size: 16px;
  }
  .payment-room .payment-price .total-trip span small {
    font-size: 14px;
    font-weight: normal;
    color: #666666;
  }
  .payment-room .payment-price .total-trip p {
    margin: 10px 0 0 0;
    padding-top: 13px;
    line-height: 20px;
    border-top: 1px solid #e8e8e8;
  }
  .payment-room .payment-price .total-trip p ins {
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    color: #25ab4b;
  }

  .total-red {
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    color: red;
  }

  .payment-room .payment-price .total-trip p i {
    margin-top: 10px;
    display: block;
    color: #666;
    font-size: 13px;
  }
  .order-received-details {
    margin-top: 30px;
    margin-left: 30px;
    margin-right: 30px;
    border-top: 1px dotted #ccc;
  }
  .order-received-details .row {
    margin-left: -30px;
    margin-right: -30px;
  }
  .order-received-details .row [class*="col-"] {
    padding-left: 30px;
    padding-right: 30px;
  }
  .order-details,
  .order-received {
    margin-top: 30px;

  }
  .order-details h2,
  .order-received h2 {
    margin: 0;
    color: #111111;
    font-size: 24px;
    line-height: 28px;
  }
  .order-received p {
    margin-top: 20px;
    margin-bottom: 0;
    line-height: 24px;
  }
  .order-received table {
    margin: 0;
    margin-top: 10px;
    width: 100%;
  }
  .order-received table th {
    font-weight: normal;
  }
  .order-received table td {
    padding: 5px 0px;
    font-weight: 600;
    color: #333333;
  }
  .order-details table {
    width: 100%;
    margin-top: 30px;
  }
  .order-details table th {
    text-transform: uppercase;
    padding: 10px 15px;
    border: 1px solid #f1f1f1;
  }
  .order-details table td {
    padding: 0px 15px;
    border: 1px solid #f1f1f1;
  }

  .order-details table td p {
    margin-top: 5px;
    margin-bottom: 0;
    font-size: 12px;
  }
  .order-details table td .room-name {
    font-size: 16px;
    margin-bottom: 10px;
    display: block;
    font-weight: normal;
    text-transform: capitalize;
  }
  .order-details table td span {
    font-weight: bold;
    font-size: 12px;
    text-transform: uppercase;
  }
  .order-details table td .total {
    color: #007722;
    font-size: 12px;
  }

  .order-complate  {
    border-top: 1px dotted #ccc;
    margin-top: 30px;
    padding-top: 30px;
    padding-bottom: 30px;
  }

  .payment-image {
    margin-top: 15px;
    margin-bottom: 15px;
    margin-left: 10px;
    border-radius: 5px;
    margin-right: 10px;
    width: 50%;
  }

  .support-contact {
    margin-top: 50px;
    margin-bottom:20px;
  }

  .service-item span {
    font-size: 16px;
  }

  /* 24. Responsive
   --------------------------------------------------------------------------------*/
  @media (max-width: 1199px) {

    /* Payment */
    .payment-room .payment-info h2 {
      font-size: 30px;
    }
    .payment-room .payment-price {
      margin-top: 0px;
    }
    .order-details, .order-received {
      margin-top: 15px;
    }

    .order-details table {
      margin-top: 15px;
      font-size: 12px;
    }

    .net_total {
      font-size: 16px;
    }

    .support-contact {
      margin-top: 25px;
    }

  }
  @media (max-width: 991px) {

    /* Payment */
    .payment-room .payment-info h2 {
      font-size: 26px;
    }
    .payment-room .payment-price figure {
      width: 200px;
    }
    .payment-room .payment-price .total-trip {
      padding: 10px 20px;
    }
  }
  @media (max-width: 767px) {
    /* Payment */

    .payment-room .row [class*="col-"] {
      padding-left: 15px;
      padding-right: 15px;
    }
    .payment-room .payment-info {
      margin-top: 20px;
    }
    .payment-room .payment-info h2 {
      font-size: 24px;
    }

    .order-received-details .row [class*="col-"] {
      padding-left: 15px;
      padding-right: 15px;
    }
    .order-complate.button-group {
        flex-direction: column !important;
    }
    .payment-image {
      width: 50%;
    }

    .service-item span {
        font-size: 14px;
    }

  }

  @media (max-width: 480px) {
    /*Payment*/
    .payment-room .payment-info h2 {
      font-size: 22px;
    }

    .payment-room .payment-price .total-trip {
      margin: 0;
    }

    .payment-room .payment-price {
      flex-direction: column;
    }
    .payment-image {
      width: 80%;
      margin: auto;
      margin-top: 10px;
    }

  }

  .order-complate.button-group {
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 10px;
  }

</style>

<section class="layout-pt-lg layout-pb-lg">
    <div class="main">
        <div class="container">
            <div class="printable">

                <div class="main-cn clearfix" style="background-color:#f9f9f9 !important">
                    <!-- Payment Room -->
                    <div class="payment-room">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="payment-info">
                                    <img class="mb-10" src="{{ asset('img/general/logo_dark.png') }}" alt="rock resort logo">
                                    <ul>
                                        <li>
                                            <span>Booking Id:</span>
                                            {{ $booking->booking_id }}
                                        </li>
                                        <li>
                                            <span>Location:</span>
                                            Pulau Aur, 86800 Mersing, Johor, Malaysia
                                        </li>
                                        <li>
                                            <span>Check-in:</span>
                                            {{ $booking->check_in_date->format('M d, Y') }}
                                        </li>
                                        <li>
                                            <span>Check-out:</span>
                                            {{ $booking->check_out_date->format('M d, Y') }}
                                        </li>
                                        <li>
                                            <span>Stay Duration:</span>
                                            {{ $nights + 1 }} Days, {{ $nights ?? 'N/A' }} Nights
                                        </li>
                                        <li>
                                            <div>
                                              <span>Rooms:</span>
                                              {{ count($roomsDetails) }} ({{ implode(', ', array_column($roomsDetails, 'room_name')) }})
                                            </div>
                                        </li>
                                    </ul>
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-6 payment-room">
                              <div class="payment-price d-flex">

                                  @if($mainImage)
                                    <img class="payment-image img-fluid" src="{{ asset('/storage/'.$mainImage) }}" alt="Package Image">
                                  @endif

                                  <div class="total-trip flex-grow-1">
                                      <span>
                                          {{ ucfirst($booking->package_name) ?? 'N/A' }}<br>
                                          <small>
                                            {{ $totalAdults ?? '0' }} Adult
                                            @if($totalChildren > 0), {{ $totalChildren }} Children @endif
                                            @if($totalKids > 0), {{ $totalKids }} Kids @endif
                                            @if($totalToddlers > 0), {{ $totalToddlers }} Toddlers @endif
                                          </small><br>

                                          <small>Total Guest: {{ $totalGuests }}</small>
                                        </span>
                                      <p class="mt-3">
                                          Trip Total: <ins> RM {{ $booking->net_total ?? '0' }}</ins>
                                          <i>
                                              <span class="d-flex gap-2 align-items-center">
                                                  Payment Status:
                                                  <ins class="{{ $booking->payment_status !== 'Paid' ? 'text-danger' : 'text-success' }}">
                                                      {{ $booking->payment_status ?? 'N/A' }}
                                                  </ins>
                                              </span>
                                          </i>
                                      </p>
                                  </div>
                              </div>
                            </div>

                        </div>
                    </div>
                    <!-- Payment Room -->
                    <div class="order-received-details">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="order-received">
                                    <h2>Booking Successful</h2>
                                    @if($booking->payment_status === 'Paid')
                                    <p>Thank you. Your trip has been confirmed.</p>
                                    @else
                                    <p style="font-weight: 600">Your booking has been made but the payment has not been confirmed.</p>
                                    @endif

                                    <br>
                                    <table style="width:100%;">
                                        <thead style="text-align: left;">
                                          <tr>
                                            <th>Guest Details</th>
                                            <th>Services Included</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>
                                            @foreach ($memberNames as $memberDetails)
                                                <div class="service-item" style="text-align:left;">
                                                    <span>{{ $loop->iteration }} - {{ $memberDetails['firstName'] }} {{ $memberDetails['lastName'] }}, {{ $memberDetails['age'] }} years old</span>
                                                </div>
                                            @endforeach
                                            </td>
                                            <td>
                                              @if (!empty($booking->included_services))
                                                @foreach (json_decode($booking->included_services, true) as $service)
                                                  <div class="service-item" style="text-align:left;">
                                                    <span>{{ $loop->iteration }} - {{ $service['name'] }} x {{ $service['quantity'] }} Qty</span>
                                                  </div>
                                                @endforeach
                                              @else
                                                <p>No services included.</p>
                                              @endif
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>

                                    <p style="margin-bottom: 5px;">Additional Service's</p>
                                    @if (!empty($booking->additional_services))
                                    @foreach (json_decode($booking->additional_services, true) as $service)
                                        <div class="service-item" style="text-align:left; font-weight:600;">
                                          <span>{{ $loop->iteration }} - {{ $service['name'] }} x {{ $service['quantity'] }} Qty</span>
                                        </div>
                                      @endforeach
                                    @else
                                      <p>No additional services selected.</p>
                                    @endif
                                </div>
                                <div class="support-contact">
                                    <p>In case of any support please contact us at <br><a style="font-weight: 600;" href="mailto:enquiry@therockresorts.com">
                                        enquiry@therockresorts.com</a> <br>
                                        <a href="" style="font-weight: 600;">
                                            +6012 628 9056
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="order-details">
                                    <h2>Payment Detail</h2>
                                    <table>
                                        <thead style="text-align: left;">
                                            <tr>
                                                <th>Charges</th>
                                                <th class="text-center">Price</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>
                                                <span>Package Charges</span>
                                            </td>
                                            <td class="text-center">
                                                <strong class="total">RM {{ $booking->package_charges ?? 'N/A' }}</strong>
                                            </td>
                                        </tr>
                                        @if(isset($booking->discount_amt) && $booking->discount_amt > 0)
                                            <tr>
                                                <td><span>Discount ({{ $booking->coupon_code ?? 'N/A' }})</span></td>
                                                <td class="text-center"><strong class="total-red">RM {{ number_format($booking->discount_amt, 2) }}</strong></td>
                                            </tr>
                                        @endif

                                        @if(!is_null($booking->additional_services_total) && $booking->additional_services_total > 0)
                                            <tr>
                                                <td><span>Additional Services Total</span></td>
                                                <td class="text-center"><strong class="total"> RM {{ number_format($booking->additional_services_total, 2) }}</strong></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><span>Marine Fees</span></td>
                                            <td class="text-center"><strong class="total"> RM {{ number_format($booking->marine_fee, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><span>Total Surchare</span></td>
                                            <td class="text-center"><strong class="total"> RM {{ number_format($booking->total_surcharge_amount, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><span>Sub Total</span></td>
                                            <td class="text-center"><strong class="total"> RM {{ number_format($booking->sub_total, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><span>Service Charge</span></td>
                                            <td class="text-center"><strong class="total"> RM {{ number_format($booking->service_charge, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><span>Tax</span></td>
                                            <td class="text-center"><strong class="total"> RM {{ number_format($booking->tax, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Net Total</strong></td>
                                            <td class="text-center"><strong class="total net_total"> RM {{ number_format($booking->net_total, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="order-complate text-center button-group">
                                    <button onclick="window.print();" class="button-20 hide-on-print">Print</button>
                                    <form action="{{ route('resend.confirmation', ['booking_id' => $booking->booking_id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="button-20 hide-on-print">Resend Email Confirmation</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
