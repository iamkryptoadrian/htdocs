@extends('user.layouts.main')
@php
    $pageTitle = "All Members";
    $user = auth()->user();
@endphp
@section('main-container')

<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">All Members</h3>
                     <div class="nk-block-des text-soft">
                        <p>Add / Update / Remove Member</p>
                     </div>
                  </div>
                  <!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">
                     <ul class="nk-block-tools g-3">
                        <li>
                           <div class="drodown">
                              {{--<a href="#add-member" class="btn btn-icon btn-primary" data-bs-toggle="modal" ><em class="icon ni ni-plus"></em></a>--}}
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
                                        <a href="{{ route('family.index') }}" class="btn btn-dim btn-outline-light">Reset Filters</a>
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
                                                            <li class="{{ $recordsPerPage == 10 ? 'active' : '' }}"><a href="{{ route('family.index', ['show' => 10, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">10</a></li>
                                                            <li class="{{ $recordsPerPage == 20 ? 'active' : '' }}"><a href="{{ route('family.index', ['show' => 20, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">20</a></li>
                                                            <li class="{{ $recordsPerPage == 50 ? 'active' : '' }}"><a href="{{ route('family.index', ['show' => 50, 'order' => $sortOrder, 'sortBy' => $sortBy]) }}">50</a></li>
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
                            <form method="GET" action="{{ route('family.index') }}">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" name="search" placeholder="Search by Name">
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
                                <div class="nk-tb-col"><span class="sub-text">ID/Passport</span></div>
                                <div class="nk-tb-col"><span class="sub-text">Action</span></div>
                            </div>
                           <!-- .nk-tb-item -->
                           @forelse ($members as $member)
                           <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span><a href="#">{{ $loop->iteration }}</a></span>
                                </div>
                                <div class="nk-tb-col">
                                     <span>{{ $member->first_name }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span>{{ $member->last_name }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span>{{ $member->email }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span>{{ $member->id_number }}</span>
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
                                                        href="#edit-member"
                                                        data-bs-target="#edit-member"
                                                        data-member-id="{{ $member->id }}"
                                                        data-member-first-name="{{ $member->first_name }}"
                                                        data-member-last-name="{{ $member->last_name }}"
                                                        data-member-phone-number="{{ $member->phone_number }}"
                                                        data-member-email="{{ $member->email }}"
                                                        data-member-date-of-birth="{{ $member->date_of_birth ? $member->date_of_birth->toDateString() : '' }}"
                                                        data-member-id-number="{{ $member->id_number }}"
                                                        data-member-street-address="{{ $member->street_address }}"
                                                        data-member-city="{{ $member->city }}"
                                                        data-member-state="{{ $member->state }}"
                                                        data-member-zip-code="{{ $member->zip_code }}"
                                                        data-member-country="{{ $member->country }}"
                                                        >
                                                     <em class="icon ni ni-edit"></em>
                                                     Edit
                                                     </a>
                                                    </li>
                                                    <li>
                                                        <form id="delete-member-{{ $member->id }}" action="{{ route('family.destroy', $member->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('delete-member-{{ $member->id }}').submit();">
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
                            @if ($members->lastPage() >= 1)
                            <div class="g">
                                <ul class="pagination justify-content-center justify-content-md-start">
                                    {{-- Previous Page Link --}}
                                    @if ($members->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $members->previousPageUrl() }}" rel="prev">Prev</a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($members->getUrlRange(1, $members->lastPage()) as $page => $url)
                                        {{-- "Three Dots" Separator --}}
                                        @if ($page == $members->currentPage() - 1 || $page == $members->currentPage() + 1)
                                            <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                        @endif

                                        {{-- Page Number Links --}}
                                        @if ($page == $members->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @elseif ($page == $members->currentPage() + 1 || $page == $members->currentPage() - 1)
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($members->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $members->nextPageUrl() }}" rel="next">Next</a></li>
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
                                            <option value="{{ request()->fullUrlWithQuery(['page' => $page]) }}" {{ $members->currentPage() == $page ? 'selected' : '' }}>
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
             <!-- Update the action attribute to point to your store route -->
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
                         <label class="form-label" for="max_adults">Max Adults</label>
                         <input type="number" class="form-control" id="max_adults" name="max_adults" placeholder="Max Adults">
                      </div>
                   </div>
                   <div class="col-md-6">
                    <div class="form-group">
                       <label class="form-label" for="max_children">Max Children</label>
                       <input type="number" class="form-control" id="max_children" name="max_children" placeholder="Max Children">
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label" for="room_quantity">Room Quantity</label>
                           <input type="number" class="form-control" id="room_quantity" name="room_quantity" placeholder="Room Quantity">
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
    <!-- .modal-dialog -->
</div>


<!-- Edit Family Member Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit-member">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="modal-title">Edit Family Member Details</h5>
                <form id="edit-member-form" method="POST" enctype="multipart/form-data" class="mt-2">
                    @csrf
                    @method('PUT')
                    <div class="row g-gs">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="first-name-edit">First Name</label>
                                <input type="text" class="form-control" id="first-name-edit" name="first_name" placeholder="First Name">
                            </div>
                        </div>
                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="last-name-edit">Last Name</label>
                                <input type="text" class="form-control" id="last-name-edit" name="last_name" placeholder="Last Name">
                            </div>
                        </div>
                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="phone-number-edit">Phone Number</label>
                                <input type="text" class="form-control" id="phone-number-edit" name="phone_number" placeholder="Phone Number">
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="email-edit">Email</label>
                                <input type="email" class="form-control" id="email-edit" name="email" placeholder="Email">
                            </div>
                        </div>
                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="dob-edit">Date of Birth</label>
                                <input type="date" class="form-control" id="dob-edit" name="date_of_birth" placeholder="Date of Birth">
                            </div>
                        </div>
                        <!-- ID Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="id-number-edit">ID Number</label>
                                <input type="text" class="form-control" id="id-number-edit" name="id_number" placeholder="ID Number">
                            </div>
                        </div>
                        <!-- Address -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="street-address-edit">Street Address</label>
                                <input type="text" class="form-control" id="street-address-edit" name="street_address" placeholder="Street Address">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="city-edit">City</label>
                                <input type="text" class="form-control" id="city-edit" name="city" placeholder="City">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="state-edit">State</label>
                                <input type="text" class="form-control" id="state-edit" name="state" placeholder="State">
                            </div>
                        </div>
                        <div class="col-md 12">
                            <div class="form-group">
                                <label class="form-label" for="zip-code-edit">Zip Code</label>
                                <input type="text" class="form-control" id="zip-code-edit" name="zip_code" placeholder="Zip Code">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label the="form-label" for="country-edit">Country</label>
                                <input type="text" class="form-control" id="country-edit" name="country" placeholder="Country">
                            </div>
                        </div>
                        <!-- Save and Cancel Buttons -->
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button type="submit" class="btn btn-primary">Update Member</button>
                                </li>
                                <li>
                                    <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
         </div>
   </div>
</div>
<!-- .modal -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#edit-member"]').forEach(button => {
            button.addEventListener('click', function() {
                const memberId = this.getAttribute('data-member-id');
                const firstName = this.getAttribute('data-member-first-name');
                const lastName = this.getAttribute('data-member-last-name');
                const phoneNumber = this.getAttribute('data-member-phone-number');
                const email = this.getAttribute('data-member-email');
                const dateOfBirth = this.getAttribute('data-member-date-of-birth');
                const idNumber = this.getAttribute('data-member-id-number');
                const streetAddress = this.getAttribute('data-member-street-address');
                const city = this.getAttribute('data-member-city');
                const state = this.getAttribute('data-member-state');
                const zipCode = this.getAttribute('data-member-zip-code');
                const country = this.getAttribute('data-member-country');

                const form = document.getElementById('edit-member-form');
                const firstNameInput = document.getElementById('first-name-edit');
                const lastNameInput = document.getElementById('last-name-edit');
                const phoneNumberInput = document.getElementById('phone-number-edit');
                const emailInput = document.getElementById('email-edit');
                const dobInput = document.getElementById('dob-edit');
                const idNumberInput = document.getElementById('id-number-edit');
                const streetAddressInput = document.getElementById('street-address-edit');
                const cityInput = document.getElementById('city-edit');
                const stateInput = document.getElementById('state-edit');
                const zipCodeInput = document.getElementById('zip-code-edit');
                const countryInput = document.getElementById('country-edit');

                // Set form action for updating member, ensure your endpoint matches
                form.action = `/user/family/update/${memberId}`;

                // Populate form fields with the member data
                firstNameInput.value = firstName;
                lastNameInput.value = lastName;
                phoneNumberInput.value = phoneNumber;
                emailInput.value = email;
                dobInput.value = dateOfBirth;
                idNumberInput.value = idNumber;
                streetAddressInput.value = streetAddress;
                cityInput.value = city;
                stateInput.value = state;
                zipCodeInput.value = zipCode;
                countryInput.value = country;
            });
        });
    });
</script>


@endsection
