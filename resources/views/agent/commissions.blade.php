@extends('agent.layouts.main')
@php
    $pageTitle = "All Commissions";
@endphp
@section('main-container')
<div class="nk-content ">
    <div class="container-fluid">
       <div class="nk-content-inner">
          <div class="nk-content-body">
             <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">All Commissions</h3>
                        <div class="nk-block-des text-soft">
                           <p>All Commission Transactions</p>
                        </div>
                    </div>
                   <!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <a href="#" id="previous-page-link" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
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
                                        <a href="{{ route('agent.commissions') }}" class="btn btn-dim btn-outline-light">Reset Filters</a>
                                    </span>

                                 </div>
                              </div>
                              <!-- .form-inline -->
                           </div>
                           <!-- .card-tools -->
                           <div class="card-tools me-n1">
                              <ul class="btn-toolbar gx-1">
                                 <li>
                                    <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                 </li>
                                 <!-- li -->
                                 <li class="btn-toolbar-sep"></li>
                                 <!-- li -->
                                 <li>
                                    <div class="toggle-wrap">
                                       <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                       <div class="toggle-content" data-content="cardTools">
                                          <ul class="btn-toolbar gx-1">
                                             <li class="toggle-close">
                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                             </li>
                                             <!-- li -->
                                             <!-- li -->
                                             <li>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-setting"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                         <ul class="link-check">
                                                             <li><span>Show</span></li>
                                                             <li class="{{ $recordsPerPage == 10 ? 'active' : '' }}"><a href="{{ route('agent.commissions', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a></li>
                                                             <li class="{{ $recordsPerPage == 20 ? 'active' : '' }}"><a href="{{ route('agent.commissions', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a></li>
                                                             <li class="{{ $recordsPerPage == 50 ? 'active' : '' }}"><a href="{{ route('agent.commissions', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a></li>
                                                          </ul>
                                                          <ul class="link-check">
                                                             <li><span>Order</span></li>
                                                             <li class="{{ $sortOrder == 'ASC' ? 'active' : '' }}"><a href="?show=10&order=ASC">ASC</a></li>
                                                             <li class="{{ $sortOrder == 'DESC' ? 'active' : '' }}"><a href="?show=10&order=DESC">DESC</a></li>
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
                            <form method="GET" action="{{ route('agent.commissions') }}">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" name="search" placeholder="Search by Customer Name or Booking ID">
                                        <button class="search-submit btn btn-icon" type="submit"><em class="icon ni ni-search"></em></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- .card-search -->
                      </div>
                      <!-- .card-inner -->
                      <div class="card-inner p-0">
                         <div class="nk-tb-list nk-tb-ulist">
                             <div class="nk-tb-item nk-tb-head">
                                 <div class="nk-tb-col"><span class="sub-text">S.No</span></div>
                                 <div class="nk-tb-col"><span class="sub-text">Booking ID</span></div>
                                 <div class="nk-tb-col"><span class="sub-text">Customer Name</span></div>
                                 <div class="nk-tb-col"><span class="sub-text">Booking Amount</span></div>
                                 <div class="nk-tb-col"><span class="sub-text">Commission Amount</span></div>
                                 <div class="nk-tb-col"><span class="sub-text">Booking Status</span></div>
                                 <div class="nk-tb-col"><span class="sub-text">Commission Status</span></div>
                             </div>
                            <!-- .nk-tb-item -->
                            @forelse ($transactions as $transaction)
                            <div class="nk-tb-item">
                                 <div class="nk-tb-col">
                                     <span>{{ $loop->iteration }}</span>
                                 </div>
                                 <div class="nk-tb-col">
                                      <span><a href="#">{{ $transaction->booking->booking_id }}</a></span>
                                 </div>
                                 <div class="nk-tb-col">
                                      <span>{{ $transaction->customer_name }}</span>
                                 </div>
                                 <div class="nk-tb-col">
                                      <span>RM {{ $transaction->booking->net_total }}</span>
                                 </div>
                                 <div class="nk-tb-col">
                                      <span>RM {{ $transaction->commission_amount }}</span>
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
                            </div><!-- .nk-tb-item  -->
                            @empty
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-sub">No transactions found.</span>
                                </div>
                            </div>
                            @endforelse
                            <!-- .nk-tb-item  -->
                         </div>
                         <!-- .nk-tb-list -->
                      </div>
                      <!-- Pagination -->
                      <div class="card-inner">
                         <div class="nk-block-between-md g-3">
                             @if ($transactions->lastPage() >= 1)
                             <div class="g">
                                 <ul class="pagination justify-content-center justify-content-md-start">
                                     {{-- Previous Page Link --}}
                                     @if ($transactions->onFirstPage())
                                         <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                     @else
                                         <li class="page-item"><a class="page-link" href="{{ $transactions->previousPageUrl() }}" rel="prev">Prev</a></li>
                                     @endif

                                     {{-- Pagination Elements --}}
                                     @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                         {{-- "Three Dots" Separator --}}
                                         @if ($page == $transactions->currentPage() - 1 || $page == $transactions->currentPage() + 1)
                                             <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                         @endif

                                         {{-- Page Number Links --}}
                                         @if ($page == $transactions->currentPage())
                                             <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                         @elseif ($page == $transactions->currentPage() + 1 || $page == $transactions->currentPage() - 1)
                                             <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                         @endif
                                     @endforeach

                                     {{-- Next Page Link --}}
                                     @if ($transactions->hasMorePages())
                                         <li class="page-item"><a class="page-link" href="{{ $transactions->nextPageUrl() }}" rel="next">Next</a></li>
                                     @else
                                         <li class="page-item disabled"><span class="page-link">Next</span></li>
                                     @endif
                                 </ul>
                             </div>
                             @endif
                            <div class="g">
                               <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                  <div>
                                     <select class="form-select js-select2" onchange="window.location.href = this.value;">
                                         @foreach ($pageRange as $page)
                                             <option value="{{ request()->fullUrlWithQuery(['page' => $page]) }}" {{ $transactions->currentPage() == $page ? 'selected' : '' }}>
                                                 Page {{ $page }}
                                             </option>
                                         @endforeach
                                     </select>
                                  </div>
                                  <div>OF {{$page}}</div>
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
