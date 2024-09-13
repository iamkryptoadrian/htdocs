@extends('admin.layouts.main')

@php
    $pageTitle = 'Cashout Request';
@endphp

@section('main-container')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">All Cashout Request</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Approve / Reject Requests</p>
                                </div>
                            </div>
                            <!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <a href="#" id="previous-page-link"
                                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Back</span>
                                </a>
                            </div>
                            <!-- .nk-block-head-content -->
                        </div>
                        <!-- .nk-block-between -->
                    </div>
                    <!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner position-relative card-tools-toggle">
                                    <div class="card-title-group">
                                        <div class="card-tools">
                                            <div class="form-inline flex-nowrap gx-3">
                                                <div class="btn-wrap">
                                                    <span class="d-none d-md-block">
                                                        <a href="{{ route('admin.agent_cashout') }}"
                                                            class="btn btn-dim btn-outline-light">Reset Filters</a>
                                                    </span>

                                                </div>
                                            </div>
                                            <!-- .form-inline -->
                                        </div>
                                        <!-- .card-tools -->
                                        <div class="card-tools me-n1">
                                            <ul class="btn-toolbar gx-1">
                                                <li>
                                                    <a href="#" class="btn btn-icon search-toggle toggle-search"
                                                        data-target="search"><em class="icon ni ni-search"></em></a>
                                                </li>
                                                <!-- li -->
                                                <li class="btn-toolbar-sep"></li>
                                                <!-- li -->
                                                <li>
                                                    <div class="toggle-wrap">
                                                        <a href="#" class="btn btn-icon btn-trigger toggle"
                                                            data-target="cardTools"><em
                                                                class="icon ni ni-menu-right"></em></a>
                                                        <div class="toggle-content" data-content="cardTools">
                                                            <ul class="btn-toolbar gx-1">
                                                                <li class="toggle-close">
                                                                    <a href="#"
                                                                        class="btn btn-icon btn-trigger toggle"
                                                                        data-target="cardTools"><em
                                                                            class="icon ni ni-arrow-left"></em></a>
                                                                </li>
                                                                <!-- li -->
                                                                <!-- li -->
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#"
                                                                            class="btn btn-trigger btn-icon dropdown-toggle"
                                                                            data-bs-toggle="dropdown">
                                                                            <em class="icon ni ni-setting"></em>
                                                                        </a>
                                                                        <div
                                                                            class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                                            <ul class="link-check">
                                                                                <li><span>Show</span></li>
                                                                                <li
                                                                                    class="{{ $recordsPerPage == 10 ? 'active' : '' }}">
                                                                                    <a
                                                                                        href="{{ route('admin.agent_cashout', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a>
                                                                                </li>
                                                                                <li
                                                                                    class="{{ $recordsPerPage == 20 ? 'active' : '' }}">
                                                                                    <a
                                                                                        href="{{ route('admin.agent_cashout', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a>
                                                                                </li>
                                                                                <li
                                                                                    class="{{ $recordsPerPage == 50 ? 'active' : '' }}">
                                                                                    <a
                                                                                        href="{{ route('admin.agent_cashout', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a>
                                                                                </li>
                                                                            </ul>
                                                                            <ul class="link-check">
                                                                                <li><span>Order</span></li>
                                                                                <li
                                                                                    class="{{ $sortOrder == 'ASC' ? 'active' : '' }}">
                                                                                    <a href="?show=10&order=ASC">ASC</a>
                                                                                </li>
                                                                                <li
                                                                                    class="{{ $sortOrder == 'DESC' ? 'active' : '' }}">
                                                                                    <a href="?show=10&order=DESC">DESC</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .dropdown -->
                                                                </li>
                                                                <!-- li -->
                                                            </ul>
                                                            <!-- .btn-toolbar -->
                                                        </div>
                                                        <!-- .toggle-content -->
                                                    </div>
                                                    <!-- .toggle-wrap -->
                                                </li>
                                                <!-- li -->
                                            </ul>
                                            <!-- .btn-toolbar -->
                                        </div>
                                        <!-- .card-tools -->
                                    </div>
                                    <!-- .card-title-group -->
                                    <div class="card-search search-wrap" data-search="search">
                                        <form method="GET" action="{{ route('admin.agent_cashout') }}">
                                            <div class="card-body">
                                                <div class="search-content">
                                                    <a href="#" class="search-back btn btn-icon toggle-search"
                                                        data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                                    <input type="text"
                                                        class="form-control border-transparent form-focus-none"
                                                        name="search" placeholder="Search Agent By Name or Email">
                                                    <button class="search-submit btn btn-icon" type="submit"><em
                                                            class="icon ni ni-search"></em></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- .card-search -->
                                </div>
                                <!-- .card-inner -->
                                <div class="card-inner p-0 scrollable_table">
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="sub-text">S.No</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Trx ID</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Agent Name</span></div>
                                            <div class="nk-tb-col tb-col-sm"><span class="sub-text">Cashout Method</span></div>
                                            <div class="nk-tb-col tb-col-xxl"><span class="sub-text">Total Amount</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Date</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Current Status</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Transfer Details</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Actions</span></div>
                                        </div>

                                        @foreach ($cashoutRequests as $request)
                                        @php
                                            $agent = App\Models\Agent::where('agent_code', $request->agent_code)->first();
                                        @endphp
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span>{{ $loop->iteration }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span class="fw-bold"><a href="#">{{ $request->trx_id }}</a></span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>{{ $agent ? $agent->name : 'Unknown Agent' }}</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm">
                                                <span>{{ $request->cashout_method }}</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-xxl"><span class="amount">RM {{ number_format($request->total_amount, 2) }}</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">{{ $request->created_at->format('d M, Y') }}</span></div>
                                            <div class="nk-tb-col">
                                                <span class="
                                                    @if ($request->status == 'approved') text-success
                                                    @elseif ($request->status == 'pending') text-warning
                                                    @elseif ($request->status == 'rejected') text-danger
                                                    @endif">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $request->trx_id }}">View</a>
                                            </div>

                                            <div class="nk-tb-col nk-tb-col-tools">
                                                @if ($request->status == 'pending')
                                                <ul class="gx-1">
                                                    <li>
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-h"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li>
                                                                        <a href="#" class="text-success" onclick="event.preventDefault(); if(confirm('Are you sure you want to approve this cashout request?')) { document.getElementById('approve-form-{{ $request->id }}').submit(); }">Approve</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->trx_id }}">Reject</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <form id="approve-form-{{ $request->id }}" action="{{ route('admin.approve_cashout', $request->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('POST')
                                                        </form>
                                                    </li>
                                                </ul>
                                                @else
                                                <span></span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Details Modal -->
                                        <div class="modal fade" id="detailsModal{{ $request->trx_id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $request->trx_id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailsModalLabel{{ $request->trx_id }}">Transfer Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <strong style="font-size: 18px; color: #000;"><pre>{{ $request->details }}</pre></strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $request->trx_id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $request->trx_id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel{{ $request->trx_id }}">Reject Cashout Request</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.reject_cashout', $request->id) }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <div class="form-group">
                                                                <label for="rejection_reason" class="form-label">Rejection Reason</label>
                                                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div><!-- .nk-tb-list -->
                                </div>
                                <!-- Pagination -->
                                <div class="card-inner">
                                    <div class="nk-block-between-md g-3">
                                        @if ($cashoutRequests->lastPage() >= 1)
                                            <div class="g">
                                                <ul class="pagination justify-content-center justify-content-md-start">
                                                    {{-- Previous Page Link --}}
                                                    @if ($cashoutRequests->onFirstPage())
                                                        <li class="page-item disabled"><span class="page-link">Prev</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item"><a class="page-link"
                                                                href="{{ $cashoutRequests->previousPageUrl() }}"
                                                                rel="prev">Prev</a></li>
                                                    @endif

                                                    {{-- Pagination Elements --}}
                                                    @foreach ($cashoutRequests->getUrlRange(1, $cashoutRequests->lastPage()) as $page => $url)
                                                        {{-- "Three Dots" Separator --}}
                                                        @if ($page == $cashoutRequests->currentPage() - 1 || $page == $cashoutRequests->currentPage() + 1)
                                                            <li class="page-item disabled"><span class="page-link"><em
                                                                        class="icon ni ni-more-h"></em></span></li>
                                                        @endif

                                                        {{-- Page Number Links --}}
                                                        @if ($page == $cashoutRequests->currentPage())
                                                            <li class="page-item active"><span
                                                                    class="page-link">{{ $page }}</span></li>
                                                        @elseif ($page == $cashoutRequests->currentPage() + 1 || $page == $cashoutRequests->currentPage() - 1)
                                                            <li class="page-item"><a class="page-link"
                                                                    href="{{ $url }}">{{ $page }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach

                                                    {{-- Next Page Link --}}
                                                    @if ($cashoutRequests->hasMorePages())
                                                        <li class="page-item"><a class="page-link"
                                                                href="{{ $cashoutRequests->nextPageUrl() }}"
                                                                rel="next">Next</a></li>
                                                    @else
                                                        <li class="page-item disabled"><span class="page-link">Next</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="g">
                                            <div
                                                class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                                <div>
                                                    <select class="form-select js-select2"
                                                        onchange="window.location.href = this.value;">
                                                        @foreach ($pageRange as $page)
                                                            <option
                                                                value="{{ request()->fullUrlWithQuery(['page' => $page]) }}"
                                                                {{ $cashoutRequests->currentPage() == $page ? 'selected' : '' }}>
                                                                Page {{ $page }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>OF {{ $page }}</div>
                                            </div>
                                        </div>
                                        <!-- .pagination-goto -->
                                    </div>
                                    <!-- .nk-block-between -->
                                </div>
                                <!-- pagination ends -->
                            </div>
                            <!-- .card-inner-group -->
                        </div>
                        <!-- .card -->
                    </div>
                    <!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>

@endsection
