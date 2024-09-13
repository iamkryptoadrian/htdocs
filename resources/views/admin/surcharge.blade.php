@extends('admin.layouts.main')
@php
    $pageTitle = "Surcharge Setup";
@endphp
@section('main-container')
<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">All Surcharge</h3>
                     <div class="nk-block-des text-soft">
                        <p>Add / Update / Delete Surcharge</p>
                     </div>
                  </div>
                  <!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">
                     <ul class="nk-block-tools g-3">
                        <li>
                           <div class="drodown">
                              <a href="#add-surcharge" class="btn btn-icon btn-primary" data-bs-toggle="modal" ><em class="icon ni ni-plus"></em></a>
                           </div>
                        </li>
                     </ul>
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
                                        <a href="{{ route('admin.surcharge.index') }}" class="btn btn-dim btn-outline-light">Reset Filters</a>
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
                                                         <li class="{{ $recordsPerPage == 10 ? 'active' : '' }}"><a href="{{ route('admin.surcharge.index', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a></li>
                                                         <li class="{{ $recordsPerPage == 20 ? 'active' : '' }}"><a href="{{ route('admin.surcharge.index', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a></li>
                                                         <li class="{{ $recordsPerPage == 50 ? 'active' : '' }}"><a href="{{ route('admin.surcharge.index', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a></li>
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
                            <form method="GET" action="{{ route('admin.surcharge.index') }}">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" name="search" placeholder="Search by Surcharge name or id">
                                        <button class="search-submit btn btn-icon" type="submit"><em class="icon ni ni-search"></em></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- .card-search -->
                     </div>
                        <!-- Surcharge Listing -->
                        <div class="card-inner p-0">
                            <div class="nk-tb-list nk-tb-ulist">
                               <div class="nk-tb-item nk-tb-head">
                                  <div class="nk-tb-col"><span class="sub-text">ID</span></div>
                                  <div class="nk-tb-col"><span class="sub-text">Surcharge Name</span></div>
                                  <div class="nk-tb-col"><span class="sub-text">Amount</span></div>
                                  <div class="nk-tb-col"><span class="sub-text">Surcharge Type</span></div>
                                  <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                                  <div class="nk-tb-col"><span class="sub-text">Action</span></div>
                               </div>
                               @forelse ($surcharges as $surcharge)
                               <div class="nk-tb-item">
                                   <div class="nk-tb-col">
                                       <span>{{ $surcharge->id }}</span>
                                   </div>
                                   <div class="nk-tb-col">
                                       <span>{{ $surcharge->name }}</span>
                                   </div>
                                   <div class="nk-tb-col">
                                       <span>{{ $surcharge->amount }}</span>
                                   </div>
                                   <div class="nk-tb-col">
                                        <span>{{ $surcharge->surcharge_type }}</span>
                                   </div>
                                   <div class="nk-tb-col">
                                        <span class="tb-status text-{{ $surcharge->is_active ? 'success' : 'danger' }}">
                                            {{ $surcharge->is_active ? 'Active' : 'Inactive' }}
                                        </span>
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
                                                                <a
                                                                href="#edit-surcharge"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-surcharge"
                                                                data-surcharge-id="{{ $surcharge->id }}"
                                                                data-surcharge-name="{{ $surcharge->name }}"
                                                                data-surcharge-amount="{{ $surcharge->amount }}"
                                                                data-surcharge-surcharge_type="{{ $surcharge->surcharge_type }}"
                                                                data-surcharge-is_active="{{ $surcharge->is_active }}"
                                                                >

                                                                <em class="icon ni ni-edit"></em>
                                                                <span>Edit</span>
                                                              </a>

                                                            </li>
                                                            <li>
                                                                <form id="delete-surcharge-{{ $surcharge->id }}" action="{{ route('admin.surcharge.destroy', $surcharge->id) }}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>

                                                                <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('delete-surcharge-{{ $surcharge->id }}').submit();">
                                                                    <em class="icon ni ni-trash"></em>
                                                                    <span>Delete</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                               </div>
                               @empty
                               <div class="nk-tb-item">
                                   <div class="nk-tb-col">
                                       <span class="tb-sub">No Surcharges Available.</span>
                                   </div>
                               </div>
                               @endforelse
                            </div>
                        </div>
                     <!-- .card-inner -->
                     <div class="card-inner">
                        <div class="nk-block-between-md g-3">
                            @if ($surcharges->lastPage() >= 1)
                            <div class="g">
                                <ul class="pagination justify-content-center justify-content-md-start">
                                    {{-- Previous Page Link --}}
                                    @if ($surcharges->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $surcharges->previousPageUrl() }}" rel="prev">Prev</a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($surcharges->getUrlRange(1, $surcharges->lastPage()) as $page => $url)
                                        {{-- "Three Dots" Separator --}}
                                        @if ($page == $surcharges->currentPage() - 1 || $page == $surcharges->currentPage() + 1)
                                            <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                        @endif

                                        {{-- Page Number Links --}}
                                        @if ($page == $surcharges->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @elseif ($page == $surcharges->currentPage() + 1 || $page == $surcharges->currentPage() - 1)
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($surcharges->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $surcharges->nextPageUrl() }}" rel="next">Next</a></li>
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
                                            <option value="{{ request()->fullUrlWithQuery(['page' => $page]) }}" {{ $surcharges->currentPage() == $page ? 'selected' : '' }}>
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
                     <!-- .card-inner -->
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

<!-- Add Surcharges Modal -->
<div class="modal fade" id="add-surcharge" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Surcharge</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.surcharge.store') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Surcharge Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                    <div class="form-group">
                        <label>Days of the Week</label>
                        <select multiple class="form-control" name="days_of_week[]" id="days_of_week">
                            <option value="0">Sunday</option>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                        </select>
                        <small class="form-text text-muted">Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.</small>
                    </div>
                    <div class="form-group">
                        <label for="surcharge_type">Surcharge Type</label>
                        <select class="form-control" id="surcharge_type" name="surcharge_type">
                            <option value="date-based">Date-based</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Surcharge</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Surcharges Modal -->
<div class="modal fade" id="edit-surcharge" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Surcharge</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-surcharge-form" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_surcharge_id" name="id">
                    <div class="form-group">
                        <label for="edit_name">Surcharge Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_amount">Amount</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_start_date">Start Date</label>
                        <input type="date" class="form-control" id="edit_start_date" name="start_date">
                    </div>
                    <div class="form-group">
                        <label for="edit_end_date">End Date</label>
                        <input type="date" class="form-control" id="edit_end_date" name="end_date">
                    </div>
                    <div class="form-group">
                        <label for="edit_days_of_week">Days of the Week</label>
                        <select multiple class="form-control" id="edit_days_of_week" name="days_of_week[]">
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_surcharge_type">Surcharge Type</label>
                        <select class="form-control" id="edit_surcharge_type" name="surcharge_type">
                            <option value="date-based">Date-based</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_is_active">Status</label>
                        <select class="form-control" id="edit_is_active" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Surcharge</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-target="#edit-surcharge"]').forEach(button => {
        button.addEventListener('click', function() {
            const surchargeId = this.getAttribute('data-surcharge-id');
            const surchargeName = this.getAttribute('data-surcharge-name');
            const surchargeAmount = this.getAttribute('data-surcharge-amount');
            const surchargeStartDate = this.getAttribute('data-surcharge-start_date');
            const surchargeEndDate = this.getAttribute('data-surcharge-end_date');
            const surchargeDaysOfWeek = this.getAttribute('data-surcharge-days_of_week');
            const surchargeType = this.getAttribute('data-surcharge-surcharge_type');
            const surchargeIsActive = this.getAttribute('data-surcharge-is_active');

            // Populate form fields
            document.getElementById('edit_surcharge_id').value = surchargeId;
            document.getElementById('edit_name').value = surchargeName;
            document.getElementById('edit_amount').value = surchargeAmount;
            document.getElementById('edit_start_date').value = surchargeStartDate;
            document.getElementById('edit_end_date').value = surchargeEndDate;
            const daysOfWeekSelect = document.getElementById('edit_days_of_week');

            // Clear all selections first
            Array.from(daysOfWeekSelect.options).forEach(option => option.selected = false);

            // Select the right options based on the surcharge days of week
            if (surchargeDaysOfWeek) {
                const daysArray = surchargeDaysOfWeek.split(',');
                Array.from(daysOfWeekSelect.options).forEach(option => {
                    if (daysArray.includes(option.value)) {
                        option.selected = true;
                    }
                });
            }

            document.getElementById('edit_surcharge_type').value = surchargeType;

            // Set the correct status
            document.getElementById('edit_is_active').value = surchargeIsActive === '1' ? '1' : '0';

            // Update form action
            const form = document.getElementById('edit-surcharge-form');
            form.action = `/admin/dashboard/surcharges/${surchargeId}`;
        });
    });
});
</script>

@endsection
