@extends('agent.layouts.main')
@php
    $pageTitle = 'Agent Dashboard';
@endphp
@section('main-container')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Dashboard Overview</h3>
                            <div class="nk-block-des text-soft">
                                <p>Welcome to The Rock Resort.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-xxl-6">
                <div class="row g-gs">
                    <div class="col-lg-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Your Affiliate Link</h6>
                                    </div>
                                </div>
                                @if (!$agent->agent_code)
                                <form method="POST" action="{{ route('agent.update_code') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="agent-code">Your URL</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="agent-referral-link">{{ url('/') }}?agent_code=</span>
                                                </div>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="agent-code"
                                                    name="agent_code"
                                                    placeholder="Enter your agent code"
                                                    pattern="[a-zA-Z]{1,8}"
                                                    title="Agent code should be up to 8 letters only"
                                                    required
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Set Agent Code</button>
                                    </div>
                                </form>
                                @else
                                <div class="form-group mt-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" disabled id="generated-url" value="{{ url('/') }}?agent_code={{ $agent->agent_code }}" readonly />
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-dim" type="button" onclick="copyToClipboard()">Copy URL</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xxl-12">
                        <div class="row g-gs">
                            <div class="col-sm-6 col-lg-6 col-xxl-6">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="title">Total Bookings</h6>
                                            </div>
                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Total Bookings using your agent code." data-bs-original-title="Total Bookings using your agent code."></em>
                                            </div>
                                        </div>
                                        <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                            <div class="nk-sale-data">
                                                <span class="amount">
                                                    {{$totalBookings}}
                                                </span>
                                                <span class="sub-title">
                                                    <span class="change {{ $changeClass }}"><em class="icon {{ $changeIcon }}"></em>{{ number_format(abs($percentageChange), 2) }}%</span> since last month
                                                </span>
                                            </div>
                                            <div class="nk-sales-ck">
                                                <canvas class="sales-bar-chart" id="agentWeeklyBoooking" style="display: block; box-sizing: border-box; height: 56px; width: 331px;" width="331" height="56"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-6 col-xxl-6">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="title">Total Booking Value</h6>
                                            </div>
                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Total Booking Value using your code." data-bs-original-title="Total Booking Value using your code."></em>
                                            </div>
                                        </div>
                                        <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                            <div class="nk-sale-data">
                                                <span class="amount">RM {{ number_format($totalBookingValue, 2) }}</span>
                                                <span class="sub-title">
                                                    <span class="change {{ $valueChangeClass }}"><em class="icon {{ $valueChangeIcon }}"></em>{{ number_format(abs($valuePercentageChange), 2) }}%</span> since last week
                                                </span>
                                            </div>
                                            <div class="nk-sales-ck">
                                                <canvas class="sales-bar-chart" id="totalBookingValue" style="display: block; box-sizing: border-box; height: 56px; width: 338px;" width="338" height="56"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6">
                <div class="card card-bordered h-100">
                    <div class="card-inner">
                        <div class="card-title-group align-start gx-3 mb-3">
                            <div class="card-title">
                                <h6 class="title">Total Commission</h6>
                                <p>Last 30 days commission from bookings.</p>
                            </div>
                        </div>
                        <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                            <div class="nk-sale-data"><span class="amount">RM {{$agentCommissionLast30Days}}</span></div>
                            <div class="nk-sale-data">
                                <span class="amount sm">{{$totalCustomers}}<small> Customers </small> - {{ $totalGuests }}<small> Guest</small> <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Customer: Number of accounts used for booking. Guest: Number of people travelled so far." data-bs-original-title="Customer: Number of accounts used for booking. Guest: Number of people travelled so far."></em></span>
                            </div>
                        </div>

                        <div class="mt-5 nk-sale-data-group align-center justify-between gy-3 gx-5">

                            <div class="nk-sale-data">
                                <h6 class="title">Night Securing Percentage</h6>
                            </div>
                            <div class="nk-sale-data">
                                <span class="amount sm">{{ $totalNights }} / <strong>{{ $systemTotalNights }}</strong> <small>Nights</small> <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Total Nights Available in the system." data-bs-original-title="Total Nights Available in the system."></em></span>
                            </div>
                        </div>
                        @php
                            $nightSecuringPercentage = ($totalNights / $systemTotalNights) * 100;
                        @endphp
                        <span>{{ number_format($nightSecuringPercentage, 3)}}%</span>
                        <div class="progress progress-lg mt-2">
                            <div class="progress-bar" data-progress="{{ number_format($nightSecuringPercentage, 3)}}">{{ number_format($nightSecuringPercentage, 3)}}%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-bordered card-full">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title"><span class="me-2">Commissions</span> <a href="{{ route('agent.commissions') }}" class="link d-none d-sm-inline">See History</a></h6>
                            </div>
                            <div class="card-tools">
                                <ul class="card-tools-nav">

                                    <li class="active">
                                        <a href="#"><span>Latest 5 Records</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span>Booking ID</span></div>
                                <div class="nk-tb-col tb-col-sm"><span>Customer</span></div>
                                <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                <div class="nk-tb-col"><span>Booking Amount</span></div>
                                <div class="nk-tb-col"><span>Commission Amount</span></div>
                                <div class="nk-tb-col"><span class="d-none d-sm-inline">Booking Status</span></div>
                                <div class="nk-tb-col"><span class="d-none d-sm-inline">Commission Status</span></div>
                            </div>
                            @foreach ($latestTransactions as $transaction)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-lead"><a href="#">{{ $transaction->booking->booking_id }}</a></span>
                                </div>
                                <div class="nk-tb-col tb-col-sm">
                                    <div class="user-card">
                                        <div class="user-avatar user-avatar-sm bg-purple"><span>{{ strtoupper(substr($transaction->customer_name, 0, 2)) }}</span></div>
                                        <div class="user-name"><span class="tb-lead">{{ $transaction->customer_name }}</span></div>
                                    </div>
                                </div>
                                <div class="nk-tb-col tb-col-md"><span class="tb-sub">{{ $transaction->created_at->format('d/m/Y') }}</span></div>
                                <div class="nk-tb-col">
                                    <span class="tb-sub tb-amount"><span>RM</span> {{ number_format($transaction->booking->net_total, 2) }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-sub tb-amount"><span>RM</span> {{ number_format($transaction->commission_amount, 2) }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="
                                        @if (in_array($transaction->booking->booking_status, ['confirmed', 'completed', 'Active']))
                                            text-success
                                        @elseif ($transaction->booking->booking_status === 'Pending For Payment')
                                            text-warning
                                        @elseif ($transaction->booking->booking_status === 'cancelled')
                                            text-danger
                                        @endif
                                    ">
                                        {{ $transaction->booking->booking_status }}
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="
                                        @if ($transaction->commission_status === 'paid')
                                            text-success
                                        @elseif ($transaction->commission_status === 'cancelled')
                                            text-danger
                                        @else
                                            text-warning
                                        @endif
                                    ">
                                        {{ Str::ucfirst($transaction->commission_status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-inner-sm border-top text-center d-sm-none"><a href="{{ route('agent.commissions') }}" class="btn btn-link btn-block">See History</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var agentWeeklyBoooking = {
    labels: @json(array_column($dailyBookings, 'date')),
    dataUnit: 'Bookings',
    stacked: true,
    datasets: [{
        label: "Daily Bookings",
        color: ["#6576ff", "#6576ff", "#6576ff", "#6576ff", "#6576ff", "#6576ff", "#6576ff"],
        data: @json(array_column($dailyBookings, 'count'))
    }]
};

var totalBookingValue = {
    labels: @json(array_column($dailyBookingValues, 'date')),
    dataUnit: 'MYR',
    stacked: true,
    datasets: [{
        label: "Daily Booking Value",
        color: ["#aea1ff", "#aea1ff", "#aea1ff", "#aea1ff", "#aea1ff", "#aea1ff", "#aea1ff"],
        data: @json(array_column($dailyBookingValues, 'value'))
    }]
};
</script>
<script src="{{url('agent/js/dashboard.js')}}"></script>
@endsection
