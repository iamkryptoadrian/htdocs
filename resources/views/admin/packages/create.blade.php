@extends('admin.layouts.main')
@php
$pageTitle = "Add New Package";
@endphp
@section('main-container')
<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">Add New Package</h3>
                     <div class="nk-block-des text-soft">
                        <p>Add / Update Packages</p>
                     </div>
                  </div>
                  <div class="nk-block-head-content">
                     <ul class="nk-block-tools g-3">
                        <li>
                           <div class="drodown">
                              <a href="{{route('admin.packages.index')}}" class="btn btn-icon btn-primary" ><em class="icon ni ni-chevron-left-c"></em></a>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="row gy-4">
                                <!-- Package Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="package-name">Package Name</label>
                                        <input type="text" class="form-control" id="package-name" name="package_name" placeholder="Package Name" required>
                                    </div>
                                </div>


                                <div class="col-md-6" id="durations-container">
                                    <label class="form-label">Package Durations</label>
                                    <!-- Placeholder for dynamic duration inputs -->
                                    <button type="button" id="add-duration" class="btn btn-icon btn-primary" style="padding: 2px 0px 2px 0px"><em class="icon ni ni-plus-circle"></em></button>
                                </div>

                                <!-- Service Charge Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="service-charge">Service Charge</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">%</span></div>
                                            <input type="number" class="form-control" id="service-charge" name="service_charge" placeholder="Service Charge" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Marine Charge Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="marine_charges">Marine Fees</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">RM</span></div>
                                            <input type="number" class="form-control" id="marine_charges" name="marine_charges" placeholder="Marine Charge" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tax Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tax">Tax</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">%</span></div>
                                            <input type="number" class="form-control" id="tax" name="tax" placeholder="Tax" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Short Description -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="short-description">Short Description</label>
                                        <input type="text" class="form-control" id="short-description" name="short_description" placeholder="Short Description" required>
                                    </div>
                                </div>

                                <!-- Long Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="long-description">Long Description</label>
                                        <textarea class="form-control" id="long-description" name="long_description" placeholder="Long Description" required></textarea>
                                    </div>
                                </div>
                                <!-- Main Image Upload -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="main-image">Main Image</label>
                                        <input type="file" class="form-control" id="main-image" name="main_image" required>
                                    </div>
                                </div>

                                <!-- Other Images Upload -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="other-images">Other Images</label>
                                        <input type="file" class="form-control" id="other-images" name="other_images[]" multiple>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Rooms</label>
                                    @foreach($rooms as $room)
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input room-checkbox" id="room_{{ $room->id }}" name="rooms[{{ $room->id }}][selected]" data-room-id="{{ $room->id }}" data-max-guest="{{ $room->max_guest }}">
                                                <label class="custom-control-label" for="room_{{ $room->id }}">{{ $room->room_type }}</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                @for ($i = 1; $i <= $rooms->max('max_guest'); $i++)
                                                <div class="input-group-prepend"><span class="input-group-text">Price for {{ $i }}</span></div>
                                                <input type="number" class="form-control room-price" name="rooms[{{ $room->id }}][price_for_{{ $i }}]" id="price_room_{{ $room->id }}_{{ $i }}" min="0" step="0.01" disabled>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Services (Included In Package, for price can put 1 for each service)</label>
                                    @foreach($services as $service)
                                    <div class="form-group row">
                                        <div class="col-8 col-md-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input service-checkbox" id="service_{{ $service->id }}" data-service-id="{{ $service->id }}">
                                                <label class="custom-control-label" for="service_{{ $service->id }}">{{ $service->service_name }}</label>
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">Qty</span></div>
                                                <input type="number" class="form-control service-quantity" id="quantity_service_{{ $service->id }}" name="services[{{ $service->id }}][quantity]" placeholder="Quantity" min="1" step="1" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Add-on Services (Services which customer can add as an add-on)</label>
                                    @foreach($services as $service)
                                    <div class="form-group row">
                                        <div class="col-8 col-md-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input addon-service-checkbox" id="addon_service_{{ $service->id }}" name="addon_services[]" value="{{ $service->id }}" data-service-id="{{ $service->id }}">
                                                <label class="custom-control-label" for="addon_service_{{ $service->id }}">{{ $service->service_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>


                                <!-- Submit Button -->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Add Package</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.room-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var roomId = this.getAttribute('data-room-id');
            var maxGuest = parseInt(this.getAttribute('data-max-guest'), 10);

            for (let i = 1; i <= 10; i++) { // Assuming 10 is the maximum number of guests for any room
                var priceInput = document.getElementById(`price_room_${roomId}_${i}`);
                if (i <= maxGuest && this.checked) {
                    priceInput.disabled = false;
                    priceInput.name = `rooms[${roomId}][price_for_${i}]`;
                } else {
                    priceInput.disabled = true;
                    priceInput.value = '';
                    priceInput.name = '';
                }
            }
        });
    });

    document.getElementById('add-duration').addEventListener('click', function() {
        const container = document.getElementById('durations-container');
        const index = container.children.length; // Get the current number of children to assign a unique index
        const newInput = document.createElement('div');
        newInput.setAttribute('id', `duration-row-${index}`);
        newInput.classList.add('row', 'gy-4', 'duration-row');
        newInput.innerHTML = `
            <div class="col-md-5">
                <input type="number" class="form-control" name="duration[days][]" placeholder="Number of Days" required min="1">
            </div>
            <div class="col-md-5">
                <input type="number" class="form-control" name="duration[nights][]" placeholder="Number of Nights" required min="1">
            </div>
        `;
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('btn', 'btn-danger', 'remove-duration');
        deleteButton.textContent = 'Delete';
        deleteButton.addEventListener('click', function() {
            removeDurationRow(index);
        });

        const buttonContainer = document.createElement('div');
        buttonContainer.classList.add('col-md-2');
        buttonContainer.appendChild(deleteButton);

        newInput.appendChild(buttonContainer);
        container.appendChild(newInput);
    });

    // Handle service selection changes, including enabling/disabling the quantity input
    document.querySelectorAll('.service-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var serviceId = this.getAttribute('data-service-id');
            var quantityInput = document.getElementById('quantity_service_' + serviceId); // Get the quantity input element
            if (this.checked) {
                quantityInput.disabled = false; // Enable the quantity input
                quantityInput.name = `services[${serviceId}][quantity]`; // Set the name for form submission
            } else {
                quantityInput.disabled = true; // Disable the quantity input
                quantityInput.name = ''; // Clear the name to prevent submission
            }
        });
    });
});

function removeDurationRow(index) {
    const row = document.getElementById(`duration-row-${index}`);
    if (row) {
        row.remove();
    }
}


</script>

@endsection
