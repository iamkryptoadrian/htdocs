@extends('admin.layouts.main')
@php
$pageTitle = "All Rooms";
@endphp
@section('main-container')
<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">All Rooms</h3>
                     <div class="nk-block-des text-soft">
                        <p>Add / Update / Delete Room</p>
                     </div>
                  </div>
                  <!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">
                     <ul class="nk-block-tools g-3">
                        <li>
                           <div class="drodown">
                              <a href="#add-room" class="btn btn-icon btn-primary" data-bs-toggle="modal" ><em class="icon ni ni-plus"></em></a>
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
                                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-dim btn-outline-light">Reset Filters</a>
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
                                                            <li class="{{ $recordsPerPage == 10 ? 'active' : '' }}"><a href="{{ route('admin.rooms.index', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a></li>
                                                            <li class="{{ $recordsPerPage == 20 ? 'active' : '' }}"><a href="{{ route('admin.rooms.index', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a></li>
                                                            <li class="{{ $recordsPerPage == 50 ? 'active' : '' }}"><a href="{{ route('admin.rooms.index', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a></li>
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
                            <form method="GET" action="{{ route('admin.rooms.index') }}">
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
                              <div class="nk-tb-col"><span class="sub-text">Room Name</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Max Guest</span></div>
                              <div class="nk-tb-col"><span class="sub-text">No of Beds</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Room Quantity</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Empty Bed Charges</span></div>
                              <div class="nk-tb-col"><span class="sub-text">Action</span></div>
                           </div>
                           <!-- .nk-tb-item -->
                           @forelse ($rooms as $room)
                           <div class="nk-tb-item">
                               <div class="nk-tb-col">
                                   <span><a href="#">{{ $loop->iteration }}</a></span>
                               </div>
                               <div class="nk-tb-col">
                                   <span>{{ $room->room_type }}</span>
                               </div>
                               <div class="nk-tb-col">
                                <span>{{ $room->max_guest }}</span>
                               </div>
                               <div class="nk-tb-col">
                                <span>{{ $room->beds }}</span>
                               </div>
                               <div class="nk-tb-col">
                                <span>{{ $room->room_quantity }}</span>
                               </div>
                               <div class="nk-tb-col">
                                 <span>{{ $room->empty_bed_charge }}</span>
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
                                                        href="#edit-room"
                                                        data-bs-target="#edit-room"
                                                        data-room-id="{{ $room->id }}"
                                                        data-room-name="{{ $room->room_type }}"
                                                        data-beds-number="{{ $room->beds }}"
                                                        data-room_quantity="{{ $room->room_quantity }}"
                                                        data-max_guest="{{ $room->max_guest }}"
                                                        data-room_description="{{ $room->room_description }}"
                                                        data-empty_bed_charge="{{ $room->empty_bed_charge }}"
                                                        data-room_img="{{ Storage::url($room->room_img) }}"
                                                        data-room_gallery="{{ $room->room_gallery }}"
                                                      >
                                                        <em class="icon ni ni-edit"></em>
                                                        <span>Edit</span>
                                                      </a>
                                                    </li>
                                                    <li>
                                                        <form id="delete-room-{{ $room->id }}" action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('delete-room-{{ $room->id }}').submit();">
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
                     <!-- Pagination -->
                     <div class="card-inner">
                        <div class="nk-block-between-md g-3">
                            @if ($rooms->lastPage() >= 1)
                            <div class="g">
                                <ul class="pagination justify-content-center justify-content-md-start">
                                    {{-- Previous Page Link --}}
                                    @if ($rooms->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $rooms->previousPageUrl() }}" rel="prev">Prev</a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($rooms->getUrlRange(1, $rooms->lastPage()) as $page => $url)
                                        {{-- "Three Dots" Separator --}}
                                        @if ($page == $rooms->currentPage() - 1 || $page == $rooms->currentPage() + 1)
                                            <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                        @endif

                                        {{-- Page Number Links --}}
                                        @if ($page == $rooms->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @elseif ($page == $rooms->currentPage() + 1 || $page == $rooms->currentPage() - 1)
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($rooms->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $rooms->nextPageUrl() }}" rel="next">Next</a></li>
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
                                            <option value="{{ request()->fullUrlWithQuery(['page' => $page]) }}" {{ $rooms->currentPage() == $page ? 'selected' : '' }}>
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

<!-- Add Room-->
<div class="modal fade" tabindex="-1" role="dialog" id="add-room">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
          <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
          <div class="modal-body modal-body-md">
             <h5 class="modal-title">Add Room Details</h5>
             <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf
                <div class="row g-gs">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label" for="room_name">Room Name</label>
                           <input type="text" class="form-control" id="room_name" name="room_name" placeholder="Room Name">
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label" for="beds_number">No of Beds</label>
                           <input type="number" class="form-control" id="beds_number" name="beds_number" placeholder="Enter number of beds">
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="max_guest">Max Guest</label>
                          <input type="number" class="form-control" id="max_guest" name="max_guest" placeholder="Max Guest">
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label" for="room_quantity">Room Quantity</label>
                           <input type="number" class="form-control" id="room_quantity" name="room_quantity" placeholder="Room Quantity">
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label" for="empty_bed_charge">Empty Bed Charges</label>
                           <input type="number" class="form-control" id="empty_bed_charge" name="empty_bed_charge" placeholder="Empty Bed Charges">
                        </div>
                     </div>

                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="form-label" for="room-description">Room Description</label>
                           <textarea class="form-control" id="room-description" name="room_description" placeholder="Room Description" required></textarea>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="form-label" for="roomImg">Main Room Image</label>
                        <div class="form-control-wrap">
                            <div class="form-file">
                                <input type="file" class="form-file-input" id="roomImg" name="room_img" accept="image/png, image/jpeg">
                                <label class="form-file-label" for="roomImg">Choose file</label>
                            </div>
                        </div>
                     </div>

                     <!-- Other Images Upload -->
                     <div class="form-group">
                        <label class="form-label" for="room_gallery">Room Gallery Image</label>
                        <div class="form-control-wrap">
                              <div class="form-file">
                              <input type="file" accept="image/png, image/jpeg"	class="form-file-input" id="room_gallery" name="room_gallery[]" multiple>
                              <label class="form-file-label" for="room_gallery">Choose file</label>
                           </div>
                        </div>
                     </div>


                   <div class="col-12">
                      <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                         <li>
                            <!-- Updated type to submit -->
                            <button type="submit" class="btn btn-primary">Add Room</button>
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
</div>

<style>
   .gallery-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Creates four columns */
    gap: 20px; /* Space between images */
    margin-bottom: 20px;
   }

   .gallery-image {
     width: 100%;
     display: block;
     border-radius: 4px;
     box-shadow: 0 4px 8px rgba(0,0,0,0.1);
   }

   .remove_gallery_btn {
     position: absolute;
     top: 5px;
     right: 5px;
     z-index: 9999;
   }

   #roomImgPreview {
      width: 40%;
      display: block;
      margin-top: 10px;
      border-radius: 5px;
   }
</style>

<!-- Edit Room-->
<div class="modal fade" tabindex="-1" role="dialog" id="edit-room">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
         <div class="modal-body modal-body-md">
            <h5 class="modal-title">Edit Room Details</h5>
            <form id="edit-room-form" method="POST" enctype="multipart/form-data" class="mt-2">
               @csrf
               @method('PUT')
               <div class="row g-gs">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label" for="room-name-edit">Room Name</label>
                        <input type="text" class="form-control" id="room-name-edit" name="room_name" placeholder="Room Name">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label" for="beds_number_edit">No of Beds</label>
                        <input type="number" class="form-control" id="beds_number_edit" name="beds_number" placeholder="Enter number of beds">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label" for="max_guest_edit">Max Guest</label>
                        <input type="number" class="form-control" id="max_guest_edit" name="max_guest" placeholder="Max Guest">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label" for="room_quantity_edit">Room Quantity</label>
                        <input type="number" class="form-control" id="room_quantity_edit" name="room_quantity" placeholder="Room Quantity">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label" for="empty_bed_charge_edit">Empty Bed Charges</label>
                        <input type="number" class="form-control" id="empty_bed_charge_edit" name="empty_bed_charge" placeholder="Empty Bed Charges" step="0.01" value="0.00">
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="form-label" for="room_description_edit">Room Description</label>
                        <textarea class="form-control" id="room_description_edit" name="room_description" placeholder="Room Description" required></textarea>
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="form-label" for="roomImgEdit">Main Room Image</label>
                        <div class="form-control-wrap">
                           <div class="form-file">
                              <input type="file" class="form-file-input" id="roomImgEdit" name="room_img" accept="image/png, image/jpeg">
                              <label class="form-file-label" for="roomImgEdit">Choose file</label>
                           </div>
                           <img id="roomImgPreview" src="" alt="Room Image Preview" style="max-width: 100%; display: none;">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="form-label" for="roomGalleryEdit">Room Gallery Images</label>
                        <div class="form-control-wrap">
                           <div id="galleryImages" class="gallery-container">
                              <!-- Existing gallery images will be appended here -->
                           </div>

                           <div class="form-file">
                              <input type="file" accept="image/png, image/jpeg" class="form-file-input" id="roomGalleryEdit" name="room_gallery[]" multiple>
                              <label class="form-file-label" for="roomGalleryEdit">Choose file</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12">
                     <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                        <li>
                           <button type="submit" class="btn btn-primary">Update Room</button>
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


<script>
   document.addEventListener("DOMContentLoaded", function() {
       const modal = document.getElementById('edit-room'); // Get the modal element
       document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#edit-room"]').forEach(button => {
           button.addEventListener('click', function() {
               const room_id = this.getAttribute('data-room-id');
               const roomName = this.getAttribute('data-room-name');
               const bedsNumber = this.getAttribute('data-beds-number');
               const room_quantity = this.getAttribute('data-room_quantity');
               const max_guest = this.getAttribute('data-max_guest');
               const empty_bed_charge = this.getAttribute('data-empty_bed_charge');
               const room_description = this.getAttribute('data-room_description');
               const imagePath = this.getAttribute('data-room_img');
               const roomGalleryString = this.getAttribute('data-room_gallery');

               let roomGallery = [];
               try {
                  roomGallery = JSON.parse(roomGalleryString.replace(/\//g, '/'));
               } catch(e) {
                  console.error("Error parsing gallery data:", e);
               }

               const form = document.getElementById('edit-room-form');
               form.action = `/admin/dashboard/rooms/${room_id}`; // Set form action
               document.getElementById('roomImgPreview').src = imagePath;
               document.getElementById('roomImgPreview').style.display = 'block';

               // Populate form fields with the room data
               document.getElementById('room-name-edit').value = roomName;
               document.getElementById('beds_number_edit').value = bedsNumber;
               document.getElementById('room_quantity_edit').value = room_quantity;
               document.getElementById('max_guest_edit').value = max_guest;
               document.getElementById('empty_bed_charge_edit').value = empty_bed_charge;
               document.getElementById('room_description_edit').value = room_description;

               // Clear existing gallery images and repopulate
               const galleryContainer = document.getElementById('galleryImages');
               galleryContainer.innerHTML = '';
               if (Array.isArray(roomGallery) && roomGallery.length) {
                   roomGallery.forEach((image, index) => {
                       const imageElement = document.createElement('div');
                       imageElement.className = 'gallery-item';
                       imageElement.innerHTML = `
                           <div class="position-relative">
                               <img src="/storage/${image}" alt="Room Image" class="gallery-image">
                               <button type="button" class="btn btn-danger btn-sm btn-remove remove_gallery_btn" data-room-id="${room_id}" data-index="${index}">Remove</button>
                           </div>
                       `;
                       galleryContainer.appendChild(imageElement);
                   });
               }

               // Attach event listeners to new remove buttons
               document.querySelectorAll('.remove_gallery_btn').forEach(button => {
                   button.onclick = function() { // Use onclick to ensure no duplicate handlers
                       const imageIndex = this.getAttribute('data-index');
                       const self = this; // 'self' refers to the button in this context

                       // AJAX request to delete the image
                       const url = `/admin/dashboard/rooms/deleteGalleryImage/${room_id}`;
                       fetch(url, {
                           method: 'POST',
                           headers: {
                               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                               'Content-Type': 'application/json',
                           },
                           body: JSON.stringify({ index: imageIndex })
                       })
                       .then(response => {
                           if (!response.ok) {
                               throw new Error('Network response was not ok');
                           }
                           return response.json();
                       })
                       .then(data => {
                           console.log(data.message); // Log success message
                           self.closest('.gallery-item').remove(); // Ensure removal from '.gallery-item'
                       })
                       .catch(error => console.error('Error:', error));
                   };
               });
           });
       });
   });
</script>



@endsection
