@extends('admin.layouts.main')
@php
$pageTitle = "All Coupons";
@endphp
@section('main-container')
<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">All Coupons</h3>
                     <div class="nk-block-des text-soft">
                        <p>Add / Update / Delete Coupons</p>
                     </div>
                  </div>
                  <!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">
                     <ul class="nk-block-tools g-3">
                        <li>
                           <div class="drodown">
                              <a href="#add-coupon" class="btn btn-icon btn-primary" data-bs-toggle="modal" ><em class="icon ni ni-plus"></em></a>
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
                                        <a href="{{ route('admin.coupon') }}" class="btn btn-dim btn-outline-light">Reset Filters</a>
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
                                                         <li class="{{ $recordsPerPage == 10 ? 'active' : '' }}"><a href="{{ route('admin.coupon', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a></li>
                                                         <li class="{{ $recordsPerPage == 20 ? 'active' : '' }}"><a href="{{ route('admin.coupon', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a></li>
                                                         <li class="{{ $recordsPerPage == 50 ? 'active' : '' }}"><a href="{{ route('admin.coupon', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a></li>
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
                            <form method="GET" action="{{ route('admin.coupon') }}">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" name="search" placeholder="Search by coupon name or id">
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
                              <div class="nk-tb-col"><span class="sub-text">ID</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Coupons Code</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Discount %</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Expiry</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Action</span></div>
                           </div>
                           <!-- .nk-tb-item -->
                           @forelse ($coupons as $coupon)
                           <div class="nk-tb-item">
                               <div class="nk-tb-col">
                                   <span><a href="#">{{ $loop->iteration }}</a></span>
                               </div>
                               <div class="nk-tb-col">
                                   <span>{{ $coupon->code }}</span>
                               </div>
                               <div class="nk-tb-col">
                                   <span>{{ $coupon->discount_percent }}</span>
                               </div>
                               <div class="nk-tb-col">
                                    <span>{{ $coupon->expiry_date }}</span>
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
                                                        data-bs-toggle="modal"
                                                        href="#edit-coupon"
                                                        data-bs-target="#edit-coupon"
                                                        data-coupon-id="{{ $coupon->id }}"
                                                        data-coupon-code="{{ $coupon->code }}"
                                                        data-coupon-discount="{{ $coupon->discount_percent }}"
                                                        data-coupon-expiry="{{ $coupon->expiry_date }}"
                                                        data-coupon-package-id="{{ $coupon->package_id }}"
                                                        data-coupon-max-discount="{{ $coupon->max_discount_amount }}"

                                                      >
                                                        <em class="icon ni ni-edit"></em>
                                                        <span>Edit</span>
                                                      </a>

                                                    </li>
                                                    <li>
                                                        <form id="delete-coupon-{{ $coupon->id }}" action="{{ route('admin.coupon.destroy', $coupon->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('delete-coupon-{{ $coupon->id }}').submit();">
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

                           </div><!-- .nk-tb-item  -->
                           @empty
                           <div class="nk-tb-item">
                               <div class="nk-tb-col">
                                   <span class="tb-sub">Not Available.</span>
                               </div>
                           </div>
                           @endforelse
                           <!-- .nk-tb-item  -->
                        </div>
                        <!-- .nk-tb-list -->
                     </div>
                     <!-- .card-inner -->
                     <div class="card-inner">
                        <div class="nk-block-between-md g-3">
                            @if ($coupons->lastPage() >= 1)
                            <div class="g">
                                <ul class="pagination justify-content-center justify-content-md-start">
                                    {{-- Previous Page Link --}}
                                    @if ($coupons->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $coupons->previousPageUrl() }}" rel="prev">Prev</a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($coupons->getUrlRange(1, $coupons->lastPage()) as $page => $url)
                                        {{-- "Three Dots" Separator --}}
                                        @if ($page == $coupons->currentPage() - 1 || $page == $coupons->currentPage() + 1)
                                            <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                        @endif

                                        {{-- Page Number Links --}}
                                        @if ($page == $coupons->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @elseif ($page == $coupons->currentPage() + 1 || $page == $coupons->currentPage() - 1)
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($coupons->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $coupons->nextPageUrl() }}" rel="next">Next</a></li>
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
                                            <option value="{{ request()->fullUrlWithQuery(['page' => $page]) }}" {{ $coupons->currentPage() == $page ? 'selected' : '' }}>
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
<!-- Add Coupon-->
<div class="modal fade" id="add-coupon" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Coupon</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.coupon.store') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="code">Coupon Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <div class="form-group">
                        <label for="discount_percent">Discount Percent</label>
                        <input type="number" class="form-control" id="discount_percent" name="discount_percent" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">Expiry Date</label>
                        <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                    </div>
                    <div class="form-group">
                        <label for="max_discount_amount">Max Discount Amount</label>
                        <input type="number" class="form-control" id="max_discount_amount" name="max_discount_amount">
                    </div>
                    <div class="form-group">
                        <label for="package_id">Assigned To Package</label>
                        <select class="form-control" id="package_id" name="package_id">
                            <option value="">Select Package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Service-->
<div class="modal fade" id="edit-coupon" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Coupon</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-coupon-form" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_coupon_id" name="id">
                    <div class="form-group">
                        <label for="edit_code">Coupon Code</label>
                        <input type="text" class="form-control" id="edit_code" name="code" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_discount_percent">Discount Percent</label>
                        <input type="number" class="form-control" id="edit_discount_percent" name="discount_percent" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_expiry_date">Expiry Date</label>
                        <input type="date" class="form-control" id="edit_expiry_date" name="expiry_date" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_max_discount_amount">Max Discount Amount</label>
                        <input type="number" class="form-control" id="edit_max_discount_amount" name="max_discount_amount">
                    </div>
                    <div class="form-group">
                        <label for="edit_package_id">Assigned To Package</label>
                        <select class="form-control" id="edit_package_id" name="package_id">
                            <option value="">Select Package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- .modal -->

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-target="#edit-coupon"]').forEach(button => {
        button.addEventListener('click', function() {
            // Extract the data attributes from the button
            const couponId = this.dataset.couponId;
            const couponCode = this.dataset.couponCode;
            const discountPercent = this.dataset.couponDiscount;
            const expiryDate = this.dataset.couponExpiry;
            const packageId = this.dataset.couponPackageId;
            const maxDiscountAmount = this.dataset.couponMaxDiscount;

            // Populate form fields
            document.getElementById('edit_coupon_id').value = couponId;
            document.getElementById('edit_code').value = couponCode;
            document.getElementById('edit_discount_percent').value = discountPercent;
            document.getElementById('edit_expiry_date').value = expiryDate;
            document.getElementById('edit_max_discount_amount').value = maxDiscountAmount;

            // Set package as selected
            const packageSelect = document.getElementById('edit_package_id');
            if (packageSelect) {
                packageSelect.value = packageId;
            } else {
                console.error('Package select element not found');
            }

            // Update form action
            const form = document.getElementById('edit-coupon-form');
            form.action = `/admin/dashboard/coupons/${couponId}`;
        });
    });
});
</script>

@endsection
