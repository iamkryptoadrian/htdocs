@extends('admin.layouts.main')

@php
$pageTitle = "All Agents";
@endphp

@section('main-container')

<div class="nk-content ">
    <div class="container-fluid">
       <div class="nk-content-inner">
          <div class="nk-content-body">
             <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">All Agents</h3>
                        <div class="nk-block-des text-soft">
                           <p>Add / Update / Susspend Agents</p>
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
                                        <a href="{{ route('admin.agentlist') }}" class="btn btn-dim btn-outline-light">Reset Filters</a>
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
                                                             <li class="{{ $recordsPerPage == 10 ? 'active' : '' }}"><a href="{{ route('admin.agentlist', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a></li>
                                                             <li class="{{ $recordsPerPage == 20 ? 'active' : '' }}"><a href="{{ route('admin.agentlist', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a></li>
                                                             <li class="{{ $recordsPerPage == 50 ? 'active' : '' }}"><a href="{{ route('admin.agentlist', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a></li>
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
                            <form method="GET" action="{{ route('admin.agentlist') }}">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" name="search" placeholder="Search Agent By Name or Email">
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
                                <div class="nk-tb-col"><span class="sub-text">First Name</span></div>
                                <div class="nk-tb-col"><span class="sub-text">Last Name</span></div>
                                <div class="nk-tb-col"><span class="sub-text">Email</span></div>
                                <div class="nk-tb-col"><span class="sub-text">Agent Code</span></div>
                                <div class="nk-tb-col"><span class="sub-text">User Status</span></div>
                                <div class="nk-tb-col"><span class="sub-text">Action</span></div>
                            </div><!-- .nk-tb-item -->

                            @forelse ($agents as $agent)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span><a href="#">{{ $loop->iteration }}</a></span>
                                </div>
                                <div class="nk-tb-col">
                                    @php
                                        $nameParts = explode(' ', $agent->name, 2);
                                        $firstName = $nameParts[0] ?? '';
                                        $lastName = $nameParts[1] ?? '';
                                    @endphp
                                    <span>{{ $firstName }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span>{{ $lastName }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span>{{ $agent->email }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span>{{ Str::upper($agent->agent_code) }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    @if($agent->account_status == 'active')
                                        <span class="text-success">Active Agent</span>
                                    @else
                                        <span class="text-danger">Blacklisted Agent</span>
                                    @endif
                                </div>
                                <div class="nk-tb-col nk-tb-col-tools">
                                    <ul class="gx-1">
                                        <li>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-h"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li>
                                                            <a data-bs-toggle="modal" href="#edit-user" data-bs-target="#edit-user" data-user-id="{{ $agent->id }}">
                                                                <em class="icon ni ni-edit"></em>
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form id="toggle-user-{{ $agent->id }}" action="{{ route('admin.banAgent', $agent->id) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE') <!-- Ensure the server-side method matches this intention -->
                                                            </form>

                                                            <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('toggle-user-{{ $agent->id }}').submit();">
                                                                @if($agent->account_status == 'active')
                                                                    <em class="icon ni ni-cross-circle" style="color: red;"></em>
                                                                    <span style="color: red;">Blacklist Agent</span>
                                                                @else
                                                                    <em class="icon ni ni-check-circle" style="color: green;"></em>
                                                                    <span style="color: green;">Active Agent</span>
                                                                @endif
                                                            </a>

                                                            <!-- Login As Agent Link -->
                                                            <a href="{{ route('admin.loginAsAgent', $agent->id) }}">
                                                                <em class="icon ni ni-user" style="color: blue;"></em>
                                                                <span style="color: blue;">Login As Agent</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- .nk-tb-item -->
                            @empty
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span>No agents found.</span>
                                    </div>
                                </div>
                            @endforelse
                        </div><!-- .nk-tb-list -->
                      </div>
                      <!-- Pagination -->
                      <div class="card-inner">
                         <div class="nk-block-between-md g-3">
                             @if ($agents->lastPage() >= 1)
                             <div class="g">
                                 <ul class="pagination justify-content-center justify-content-md-start">
                                     {{-- Previous Page Link --}}
                                     @if ($agents->onFirstPage())
                                         <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                     @else
                                         <li class="page-item"><a class="page-link" href="{{ $agents->previousPageUrl() }}" rel="prev">Prev</a></li>
                                     @endif

                                     {{-- Pagination Elements --}}
                                     @foreach ($agents->getUrlRange(1, $agents->lastPage()) as $page => $url)
                                         {{-- "Three Dots" Separator --}}
                                         @if ($page == $agents->currentPage() - 1 || $page == $agents->currentPage() + 1)
                                             <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                         @endif

                                         {{-- Page Number Links --}}
                                         @if ($page == $agents->currentPage())
                                             <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                         @elseif ($page == $agents->currentPage() + 1 || $page == $agents->currentPage() - 1)
                                             <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                         @endif
                                     @endforeach

                                     {{-- Next Page Link --}}
                                     @if ($agents->hasMorePages())
                                         <li class="page-item"><a class="page-link" href="{{ $agents->nextPageUrl() }}" rel="next">Next</a></li>
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
                                             <option value="{{ request()->fullUrlWithQuery(['page' => $page]) }}" {{ $agents->currentPage() == $page ? 'selected' : '' }}>
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
