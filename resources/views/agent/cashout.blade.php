@extends('agent.layouts.main')

@php
    $pageTitle = "Cashout Commissions";
@endphp

@section('main-container')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Cashout Commissions</h3>
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
                    <div class="row g-gs">
                        <div class="col-12">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="nk-block">
                                        <div class="lead-text mb-2 mt-2">Your Finance Account</div>
                                        <div class="profile-balance">
                                            <div class="profile-balance-group row gx-4">
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="profile-balance-sub text-primary">
                                                        <span class="profile-balance-plus text-soft"><em class="icon ni ni-bullet-fill"></em></span>
                                                        <div class="profile-balance-amount">
                                                            <div class="number text-primary"><small class="currency currency-usd">RM</small> {{ number_format($availableCommission, 2) }}</div>
                                                        </div>
                                                        <div class="profile-balance-subtitle">Available Commission <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="The Commission amount which you can withdraw." data-bs-original-title="The Commission amount which you can withdraw."></em></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="profile-balance-sub text-orange">
                                                        <span class="profile-balance-plus text-soft"><em class="icon ni ni-bullet-fill"></em></span>
                                                        <div class="profile-balance-amount">
                                                            <div class="number text-orange"><small class="currency currency-usd">RM</small> {{ number_format($pendingCommission, 2) }}</div>
                                                        </div>
                                                        <div class="profile-balance-subtitle">Pending Commission<em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="The Commission amount which is pending for clearance from booking." data-bs-original-title="The Commission amount which is pending for clearance from booking."></em></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="profile-balance-sub text-teal">
                                                        <span class="profile-balance-plus text-soft"><em class="icon ni ni-bullet-fill"></em></span>
                                                        <div class="profile-balance-amount">
                                                            <div class="number text-teal"><small class="currency currency-usd">RM</small> {{ number_format($totalCashout, 2) }}</div>
                                                        </div>
                                                        <div class="profile-balance-subtitle">Total Cashout <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="The Commission amount which you have cashed out so far." data-bs-original-title="The Commission amount which you have cashed out so far."></em></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="profile-balance-sub text-orange">
                                                        <span class="profile-balance-plus text-soft"><em class="icon ni ni-bullet-fill"></em></span>
                                                        <div class="profile-balance-amount">
                                                            <div class="number text-orange"><small class="currency currency-usd">RM</small> {{ number_format($pendingCashout, 2) }}</div>
                                                        </div>
                                                        <div class="profile-balance-subtitle">Pending Cashout <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="The Commission amount which is under cashout process." data-bs-original-title="The Commission amount which is under cashout process."></em></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="lead-text mb-2 mt-2">Submit New Cashout Request</div>
                                        <form action="{{ route('agent.cashout.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group col-xl-6 col-md-6 col-sm-12 p-2 border round-sm">
                                                <div class="form-group">
                                                    <label class="form-label">Select Withdraw Method</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-select" id="select2-example" name="request_type" required>
                                                            @foreach ($methods as $method)
                                                                <option value="{{ $method['name'] }}">{{ $method['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label" for="details">Enter Cashout Details</label>
                                                    <div class="form-control-wrap">
                                                        <textarea
                                                            class="form-control"
                                                            id="details"
                                                            name="details"
                                                            placeholder="Enter your account details."
                                                            required
                                                        ></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label" for="amount">Enter Amount</label>
                                                    <div class="form-control-wrap">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">RM</span>
                                                            </div>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                id="amount"
                                                                name="amount"
                                                                placeholder="Enter amount you want to withdraw"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Display recent transactions -->
                                    <div class="nk-block scrollable_table">
                                        <h6 class="lead-text mb-3">Recent Request</h6>
                                        <div class="nk-tb-list nk-tb-ulist is-compact border round-sm">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="sub-text">Trx ID</span></div>
                                                <div class="nk-tb-col"><span class="sub-text">Cashout Method</span></div>
                                                <div class="nk-tb-col"><span class="sub-text">Total Amount</span></div>
                                                <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                                                <div class="nk-tb-col"><span class="sub-text">Date</span></div>
                                                <div class="nk-tb-col"><span class="sub-text">Details</span></div>
                                            </div>
                                            @foreach ($recentTransactions as $transaction)
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col">
                                                        <a href="#"><span class="fw-bold">{{ $transaction->trx_id }}</span></a>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <span>{{ $transaction->cashout_method }}</span>
                                                    </div>
                                                    <div class="nk-tb-col"><span class="amount">RM {{ number_format($transaction->total_amount, 2) }}</span></div>
                                                    <div class="nk-tb-col">
                                                        <span class="lead-text
                                                            @if ($transaction->status == 'approved') text-success
                                                            @elseif ($transaction->status == 'pending') text-warning
                                                            @elseif ($transaction->status == 'rejected') text-danger
                                                            @endif">
                                                            {{ ucfirst($transaction->status) }}
                                                            @if ($transaction->status == 'rejected')
                                                                <em class="icon ni ni-help-fill" data-bs-toggle="modal" data-bs-target="#rejectionReasonModal{{ $transaction->trx_id }}"></em>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col"><span class="sub-text">{{ $transaction->created_at->format('d M, Y') }}</span></div>
                                                    <div class="nk-tb-col">
                                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $transaction->trx_id }}">View</a>
                                                    </div>
                                                </div>

                                                <!-- Details Modal -->
                                                <div class="modal fade" id="detailsModal{{ $transaction->trx_id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $transaction->trx_id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detailsModalLabel{{ $transaction->trx_id }}">Cashout Method Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <strong style="font-size: 18px; color: #000;"><pre>{{ $transaction->details }}</pre></strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Rejection Reason Modal -->
<div class="modal fade" id="rejectionReasonModal{{ $transaction->trx_id }}" tabindex="-1" role="dialog" aria-labelledby="rejectionReasonLabel{{ $transaction->trx_id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectionReasonLabel{{ $transaction->trx_id }}">Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ $transaction->rejection_reason }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
                                            @endforeach
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

@endsection
