@extends('admin.layouts.main')
@php
$pageTitle = "All Service";
@endphp
@section('main-container')
<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">All Services</h3>
                     <div class="nk-block-des text-soft">
                        <p>Add / Update / Delete Services</p>
                     </div>
                  </div>
                  <!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">
                     <ul class="nk-block-tools g-3">
                        <li>
                           <div class="drodown">
                              <a href="#add-service" class="btn btn-icon btn-primary" data-bs-toggle="modal" ><em class="icon ni ni-plus"></em></a>
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
                                        <a href="{{ route('admin.services.index') }}" class="btn btn-dim btn-outline-light">Reset Filters</a>
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
                                                         <li class="{{ $recordsPerPage == 10 ? 'active' : '' }}"><a href="{{ route('admin.services.index', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a></li>
                                                         <li class="{{ $recordsPerPage == 20 ? 'active' : '' }}"><a href="{{ route('admin.services.index', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a></li>
                                                         <li class="{{ $recordsPerPage == 50 ? 'active' : '' }}"><a href="{{ route('admin.services.index', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a></li>
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
                            <form method="GET" action="{{ route('admin.services.index') }}">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" name="search" placeholder="Search by product name or id">
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
                              <div class="nk-tb-col"><span class="sub-text">Service Name</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Guest Selection</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Price</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Image</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Action</span></div>
                           </div>
                           <!-- .nk-tb-item -->
                           @forelse ($services as $service)
                           <div class="nk-tb-item">
                               <div class="nk-tb-col">
                                   <span><a href="#">{{ $loop->iteration }}</a></span>
                               </div>
                               <div class="nk-tb-col">
                                   <span>{{ $service->service_name }}</span>
                               </div>
                               <div class="nk-tb-col">
                                 @if($service->allowed_selection)
                                     <span class="text-teal">Enabled</span>
                                 @else
                                     <span class="text-danger">Disabled</span>
                                 @endif
                               </div>
                             
                               <div class="nk-tb-col">
                                   <span>RM {{ number_format($service->price, 2) }}</span>
                               </div>
                               <div class="nk-tb-col">
                                    <img src="{{ Storage::url($service->image_path) }}" alt="service-image" style="width: auto; height: auto;">
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
                                                          href="#edit-service"
                                                          data-bs-target="#edit-service"
                                                          data-service-id="{{ $service->id }}"
                                                          data-service-name="{{ $service->service_name }}"
                                                          data-service-description="{{ $service->description }}"
                                                          data-service-price="{{ $service->price }}"
                                                          data-image-path="{{ Storage::url($service->image_path) }}"
                                                          data-allowed-selection="{{ $service->allowed_selection ? '1' : '0' }}"
                                                      >
                                                          <em class="icon ni ni-edit"></em>
                                                          <span>Edit</span>
                                                      </a>
                                                  

                                                    </li>
                                                    <li>
                                                        <form id="delete-service-{{ $service->id }}" action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('delete-service-{{ $service->id }}').submit();">
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
                            @if ($services->lastPage() >= 1)
                            <div class="g">
                                <ul class="pagination justify-content-center justify-content-md-start">
                                    {{-- Previous Page Link --}}
                                    @if ($services->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $services->previousPageUrl() }}" rel="prev">Prev</a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                                        {{-- "Three Dots" Separator --}}
                                        @if ($page == $services->currentPage() - 1 || $page == $services->currentPage() + 1)
                                            <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                        @endif

                                        {{-- Page Number Links --}}
                                        @if ($page == $services->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @elseif ($page == $services->currentPage() + 1 || $page == $services->currentPage() - 1)
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($services->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $services->nextPageUrl() }}" rel="next">Next</a></li>
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
                                            <option value="{{ request()->fullUrlWithQuery(['page' => $page]) }}" {{ $services->currentPage() == $page ? 'selected' : '' }}>
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

<!-- Add Service-->
<div class="modal fade" tabindex="-1" role="dialog" id="add-service">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
          <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
          <div class="modal-body modal-body-md">
             <h5 class="modal-title">Add Service Details</h5>
             <!-- Update the action attribute to point to your store route -->
             <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf <!-- Include CSRF token -->
                <div class="row g-gs">
                   <div class="col-md-6">
                      <div class="form-group">
                         <label class="form-label" for="service-name-add">Service Name</label>
                         <!-- Updated id and name -->
                         <input type="text" class="form-control" id="service-name-add" name="service_name" placeholder="Service Name">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                         <label class="form-label" for="short-description-add">Short Description</label>
                         <!-- Updated id and name -->
                         <input type="text" class="form-control" id="short-description-add" name="description" placeholder="Short Description">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                         <label class="form-label" for="price-add">Price</label>
                         <!-- Updated id and name -->
                         <input type="number" class="form-control" id="price-add" name="price" placeholder="Price in RM">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                         <label class="form-label" for="customFile">Service Image ( 24px X 24px )</label>
                         <div class="form-control-wrap">
                             <div class="form-file">
                                 <input type="file" class="form-file-input" id="customFile" name="image_path">
                                 <label class="form-file-label" for="customFile">Choose file</label>
                             </div>
                         </div>
                      </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label" for="allowed-selection-add">Allowed Selection</label>
                        <div class="custom-control custom-switch">
                           <input type="checkbox" class="custom-control-input" id="allowed-selection-add" name="allowed_selection">
                           <label class="custom-control-label" for="allowed-selection-add">Yes / No</label>
                        </div>
                     </div>
                   </div>
                   <div class="col-12">
                      <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                         <li>
                            <!-- Updated type to submit -->
                            <button type="submit" class="btn btn-primary">Add Service</button>
                         </li>
                         <li>
                            <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                         </li>
                      </ul>
                   </div>
                </div>
             </form>
          </div>
          <!-- .modal-body -->
       </div>
       <!-- .modal-content -->
    </div>
    <!-- .modal-dialog -->
</div>


<!-- Edit Service-->
<div class="modal fade" tabindex="-1" role="dialog" id="edit-service">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
          <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
          <div class="modal-body modal-body-md">
             <h5 class="modal-title">Edit Service Details</h5>
             <form id="edit-service-form" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf
                @method('PUT')
                <div class="row g-gs">
                   <div class="col-md-6">
                      <div class="form-group">
                         <label class="form-label" for="service-name-edit">Service Name</label>
                         <input type="text" class="form-control" id="service-name-edit" name="service_name" placeholder="Service Name">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                         <label class="form-label" for="short-description-edit">Short Description</label>
                         <input type="text" class="form-control" id="short-description-edit" name="description" placeholder="Short Description">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                         <label class="form-label" for="price-edit">Price</label>
                         <input type="number" class="form-control" id="price-edit" name="price" placeholder="Price in RM">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                         <label class="form-label" for="customFileEdit">Service Image ( 24px X 24px )</label>
                         <div class="form-control-wrap">
                             <div class="form-file">
                                 <input type="file" class="form-file-input" id="customFileEdit" name="image_path">
                                 <label class="form-file-label" for="customFileEdit">Choose file</label>
                             </div>
                         </div>
                         <div class="mt-3">
                           <img src="" alt="Service Image" style="width: 100px; height: auto; display: none;">
                         </div>
                      </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label" for="allowed-selection-edit">Allowed Selection</label>
                        <div class="custom-control custom-switch">
                           <input type="checkbox" class="custom-control-input" id="allowed-selection-edit" name="allowed_selection">
                           <label class="custom-control-label" for="allowed-selection-edit">Yes / No</label>
                        </div>
                     </div>
                   </div>
                   <div class="col-12">
                      <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                         <li>
                            <button type="submit" class="btn btn-primary">Update Service</button>
                         </li>
                         <li>
                            <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                         </li>
                      </ul>
                   </div>
                </div>
             </form>
          </div>
          <!-- .modal-body -->
       </div>
       <!-- .modal-content -->
    </div>
    <!-- .modal-dialog -->
</div>
<!-- .modal -->


<script>
   document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#edit-service"]').forEach(button => {
        button.addEventListener('click', function() {
            const serviceId = this.getAttribute('data-service-id');
            const serviceName = this.getAttribute('data-service-name');
            const serviceDescription = this.getAttribute('data-service-description');
            const servicePrice = this.getAttribute('data-service-price');
            const serviceImagePath = this.getAttribute('data-image-path');
            const allowedSelection = this.getAttribute('data-allowed-selection') === '1';                

            const form = document.getElementById('edit-service-form');
            const serviceNameInput = document.getElementById('service-name-edit');
            const shortDescriptionInput = document.getElementById('short-description-edit');
            const priceInput = document.getElementById('price-edit');
            const imagePreview = form.querySelector('img');
            const allowedSelectionInput = document.getElementById('allowed-selection-edit');

            // Set form action
            form.action = `/admin/dashboard/services/${serviceId}`;

            // Populate form fields with the service data
            serviceNameInput.value = serviceName;
            shortDescriptionInput.value = serviceDescription;
            priceInput.value = servicePrice;
            allowedSelectionInput.checked = allowedSelection;

            // Update image preview if path is provided
            if(serviceImagePath && imagePreview) {
                imagePreview.src = serviceImagePath;
                imagePreview.style.display = 'block';
            } else if(imagePreview) {
                imagePreview.style.display = 'none';
            }
        });
    });
   });
</script>

@endsection
