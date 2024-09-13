@extends('admin.layouts.main')
@php
    $pageTitle = "All Bookings";
@endphp
@section('main-container')

<div class="nk-content ">
    <div class="container-fluid">
       <div class="nk-content-inner">
          <div class="nk-content-body">
             <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                   <div class="nk-block-head-content">
                      <h3 class="nk-block-title page-title">Booking Lists</h3>
                      <div class="nk-block-des text-soft">
                      </div>
                   </div>
                  <!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">
                    <ul class="nk-block-tools g-3">
                       <li>
                          <div class="drodown">
                             <a href="{{route('admin.bookings.index')}}" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                          </div>
                       </li>
                    </ul>
                 </div>
                 <!-- .nk-block-head-content -->
                </div>
             </div>
             <div class="nk-block">
                <div class="card card-bordered card-stretch">
                   <div class="card-inner-group">
                      <div class="card-inner position-relative card-tools-toggle">
                        <div class="card-title-group">
                            <div class="card-tools">
                               <div class="form-inline flex-nowrap gx-3">
                                  <div class="btn-wrap">
                                     <span class="d-none d-md-block">
                                         <a href="{{ route('admin.bookings.index') }}" class="btn btn-dim btn-outline-light">Reset Filters</a>
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
                                                             <li class="{{ $recordsPerPage == 10 ? 'active' : '' }}"><a href="{{ route('admin.bookings.index', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a></li>
                                                             <li class="{{ $recordsPerPage == 20 ? 'active' : '' }}"><a href="{{ route('admin.bookings.index', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a></li>
                                                             <li class="{{ $recordsPerPage == 50 ? 'active' : '' }}"><a href="{{ route('admin.bookings.index', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a></li>
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
                        <!-- .card-search-group -->
                        <div class="card-search search-wrap" data-search="search">
                            <form method="GET" action="{{ route('admin.bookings.index') }}">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" name="search" placeholder="Search by Booking ID">
                                        <button class="search-submit btn btn-icon" type="submit"><em class="icon ni ni-search"></em></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- .card-search -->
                      </div>
                        <div class="card-inner p-0 scrollable_table">
                         <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                               <div class="nk-tb-col"><span class="sub-text">Booking ID</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Customer</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Package</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Booking Status</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Room Qty</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Mobile</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Arrive</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Depart</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Payment</span></div>
                               <div class="nk-tb-col"><span class="sub-text">Action</span></div>
                            </div>
                            @foreach ($bookings as $booking)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="text-primary">
                                        <a href="{{ route('admin.bookings.view', ['booking_id' => $booking->booking_id]) }}">{{ $booking->booking_id }}</a>
                                    </span>
                                </div>
                                <div class="nk-tb-col"><span>{{ ucfirst($booking->main_guest_first_name) }} {{ ucfirst($booking->main_guest_last_name) }}</span></div>
                                <div class="nk-tb-col"><span>{{ ucwords(strtolower($booking->package_name)) }}</span></div>
                                <div class="nk-tb-col">
                                    <span class="tb-status {{ $statusClasses[$booking->booking_status] ?? 'text-secondary' }}">
                                        {{ ucwords(strtolower($booking->booking_status)) }}
                                    </span>
                                </div>
                                <div class="nk-tb-col"><span>{{ $booking->no_of_rooms }}</span></div>
                                <div class="nk-tb-col"><span>{{ $booking->main_guest_phone_number }}</span></div>
                                <div class="nk-tb-col"><span>{{ $booking->check_in_date->format('d M Y') }}</span></div>
                                <div class="nk-tb-col"><span>{{ $booking->check_out_date->format('d M Y') }}</span></div>
                                <div class="nk-tb-col"><span class="tb-status {{ 'status-' . strtolower($booking->payment_status) }}">{{ ucfirst($booking->payment_status) }}</span></div>
                                <div class="nk-tb-col nk-tb-col-tools">
                                   <ul class="gx-1">
                                      <li>
                                         <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                               <ul class="link-list-opt no-bdr">
                                                  <li><a href="#"><em class="icon ni ni-mail-fill"></em><span>Send Email</span></a></li>
                                                  <li><a href="{{ route('admin.bookings.view', ['booking_id' => $booking->booking_id]) }}"><em class="icon ni ni-edit-fill"></em><span>Edit</span></a></li>
                                               </ul>
                                            </div>
                                         </div>
                                      </li>
                                   </ul>
                                </div>
                            </div>
                            @endforeach
                         </div>
                        </div>
                      <div class="card-inner">
                        <div class="nk-block-between-md g-3">
                            @if ($bookings->lastPage() >= 1)
                            <div class="g">
                                <ul class="pagination justify-content-center justify-content-md-start">
                                    {{-- Previous Page Link --}}
                                    @if ($bookings->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $bookings->previousPageUrl() }}" rel="prev">Prev</a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                                        {{-- "Three Dots" Separator --}}
                                        @if ($page == $bookings->currentPage() - 1 || $page == $bookings->currentPage() + 1)
                                            <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                        @endif

                                        {{-- Page Number Links --}}
                                        @if ($page == $bookings->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @elseif ($page == $bookings->currentPage() + 1 || $page == $bookings->currentPage() - 1)
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($bookings->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $bookings->nextPageUrl() }}" rel="next">Next</a></li>
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
                                            <option value="{{ request()->fullUrlWithQuery(['page' => $page]) }}" {{ $bookings->currentPage() == $page ? 'selected' : '' }}>
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
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>

@endsection
