@extends('admin.layouts.main')
@php
$pageTitle = "Edit Package";
@endphp
@section('main-container')
<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">Edit Package</h3>
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
            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="row gy-4">
                                <!-- Package Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="package-name">Package Name</label>
                                        <input type="text" class="form-control" id="package-name" name="package_name" placeholder="Package Name" value="{{ $package->package_name }}" required>
                                    </div>
                                </div>

                                <!--Duration-->
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
                                            <input type="number" value="{{ $package->service_charge }}" class="form-control" id="service-charge" name="service_charge" placeholder="Service Charge" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Marine Charge Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="marine_charges">Marine Fees</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">RM</span></div>
                                            <input value="{{ $package->marine_charges }}" type="number" class="form-control" id="marine_charges" name="marine_charges" placeholder="Marine Charge" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tax Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tax">Tax</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">%</span></div>
                                            <input value="{{ $package->tax }}" type="number" class="form-control" id="tax" name="tax" placeholder="Tax" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Short Description -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="short-description">Short Description</label>
                                        <input value="{{ $package->short_description }}" type="text" class="form-control" id="short-description" name="short_description" placeholder="Short Description" required>
                                    </div>
                                </div>
                                <!-- Long Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="long-description">Long Description</label>
                                        <textarea class="form-control" id="long-description" name="long_description" placeholder="Long Description" required>{{ $package->long_description }}</textarea>
                                    </div>
                                </div>

                                <!-- Main Image Upload -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="main-image">Main Image</label>
                                        <input type="file" class="form-control" id="main-image" name="main_image">
                                        @if($package->main_image)
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($package->main_image) }}" alt="Main Image" id="main_image-preview">
                                            </div>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="delete-main-image" data-package-id="{{ $package->id }}">Delete Image</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Other Images Upload -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="other-images">Other Images</label>
                                        <input type="file" class="form-control" id="other-images" name="other_images[]" multiple>

                                        <div class="other-images-preview mt-2" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                            @if($package->other_images)
                                                @php $otherImages = json_decode($package->other_images, true); @endphp
                                                @foreach($otherImages as $index => $image)
                                                    <div class="other_img-container">
                                                        <img src="{{ Storage::url($image) }}" alt="Image" style="max-width: 100px; height: auto;">
                                                        <button type="button" class="btn btn-danger btn-sm delete-other-image" data-package-id="{{ $package->id }}" data-image-index="{{ $index }}" style="position: absolute; top: 0; right: 0;">X</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Rooms</label>
                                    @foreach($rooms as $room)
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input room-checkbox" id="room_{{ $room->id }}" name="rooms[{{ $room->id }}][selected]" data-room-id="{{ $room->id }}" data-max-guest="{{ $room->max_guest }}" {{ $room->selected ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="room_{{ $room->id }}">{{ $room->room_type }}</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                @for ($i = 1; $i <= $rooms->max('max_guest'); $i++)
                                                <div class="input-group-prepend"><span class="input-group-text">Price for {{ $i }}</span></div>
                                                <input type="number" class="form-control room-price" name="rooms[{{ $room->id }}][price_for_{{ $i }}]" id="price_room_{{ $room->id }}_{{ $i }}" min="0" step="0.01" value="{{ $room->prices['price_for_' . $i] ?? '' }}" {{ $i <= $room->max_guest && $room->selected ? '' : 'disabled' }}>
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
                                                <input type="checkbox" class="custom-control-input service-checkbox" id="service_{{ $service->id }}" name="services[{{ $service->id }}][selected]" data-service-id="{{ $service->id }}" {{ $service->selected ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="service_{{ $service->id }}">{{ $service->service_name }}</label>
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">QTY</span></div>
                                                <input type="number" class="form-control service-quantity" id="quantity_service_{{ $service->id }}" name="services[{{ $service->id }}][quantity]" placeholder="Quantity" min="0" step="1" value="{{ $service->quantity }}" {{ $service->selected ? '' : 'disabled' }}>
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
                                                <input type="checkbox" class="custom-control-input addon-service-checkbox" id="addon_service_{{ $service->id }}" name="addon_services[]" value="{{ $service->id }}" data-service-id="{{ $service->id }}" {{ in_array($service->id, $selectedAddonServices) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="addon_service_{{ $service->id }}">{{ $service->service_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>


                                <!-- Submit Button -->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update Package</button>
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
    const packageDurations = @json($durationArray);
    const packageServices = @json($services);
    const allServices = @json($services);
    console.log(allServices);
    console.log("package service", packageServices);
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteImageButton = document.getElementById('delete-main-image');
    const mainImageInput = document.getElementById('main-image');
    const mainImagePreview = document.getElementById('main-image-preview');

    // Optional: Handle the file input change to preview a new image before upload
    mainImageInput.addEventListener('change', function(event) {
        if (event.target.files.length > 0) {
            const src = URL.createObjectURL(event.target.files[0]);
            mainImagePreview.setAttribute('src', src);
            mainImagePreview.style.display = 'block';
        }
    });

    // Assuming you want to handle the image deletion client-side and server-side
    deleteImageButton.addEventListener('click', function() {
        const packageId = this.getAttribute('data-package-id');

        // Construct the URL for the AJAX request
        const url = `/admin/dashboard/packages/${packageId}/delete-image`;

        // Make the fetch request
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token for security
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                // any data you need to send with the request
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message); // Success or error message
            // Hide the preview and button, clear the input
            mainImagePreview.style.display = 'none';
            deleteImageButton.style.display = 'none';
            mainImageInput.value = '';
        })
        .catch(error => console.error('Error:', error));
    });

    // Handling other images deletion
    document.querySelectorAll('.delete-other-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageIndex = this.getAttribute('data-image-index');
            const packageId = this.getAttribute('data-package-id');

            // Store the button context to use inside fetch promise
            const self = this;

            // Construct the URL for the AJAX request to delete another image
            const url = `/admin/dashboard/packages/${packageId}/delete-other-image`;

            // Make the fetch request to delete the specific image
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    index: imageIndex, // Send the index of the image to be deleted
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data.message); // Success or error message

                // Remove the image container client-side, using 'self' to refer to the button
                self.closest('.other_img-container').remove();
            })
            .catch(error => console.error('Error:', error));
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

    // Function to dynamically create duration inputs and populate them
    function populateDurations(durations) {
        const container = document.getElementById('durations-container');
        durations.forEach((duration, index) => {
            const durationDiv = document.createElement('div');
            durationDiv.setAttribute('id', `duration-row-${index}`);
            durationDiv.classList.add('row', 'gy-4', 'duration-row');

            const dayInputDiv = document.createElement('div');
            dayInputDiv.classList.add('col-md-5');
            dayInputDiv.innerHTML = `
                <input type="number" class="form-control" name="duration[days][]" placeholder="Number of Days" value="${duration.days}" required min="1">
            `;

            const nightInputDiv = document.createElement('div');
            nightInputDiv.classList.add('col-md-5');
            nightInputDiv.innerHTML = `
                <input type="number" class="form-control" name="duration[nights][]" placeholder="Number of Nights" value="${duration.nights}" required min="1">
            `;

            const deleteButtonDiv = document.createElement('div');
            deleteButtonDiv.classList.add('col-md-2');
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'remove-duration');
            deleteButton.textContent = 'Delete';
            deleteButton.addEventListener('click', function() {
                removeDurationRow(index);
            });

            deleteButtonDiv.appendChild(deleteButton);

            durationDiv.appendChild(dayInputDiv);
            durationDiv.appendChild(nightInputDiv);
            durationDiv.appendChild(deleteButtonDiv);

            container.appendChild(durationDiv);
        });
    }

    function removeDurationRow(index) {
        const row = document.getElementById(`duration-row-${index}`);
        if (row) {
            row.remove();
        }
    }

    // Call the function to populate the durations
    if (packageDurations) {
        populateDurations(packageDurations);
    }

    //chek uncehck room
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

    // Handle service selection changes, including enabling/disabling the quantity input
    document.querySelectorAll('.service-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var serviceId = this.getAttribute('data-service-id');
            var quantityInput = document.getElementById('quantity_service_' + serviceId);
            if (this.checked) {
                quantityInput.disabled = false;
                quantityInput.name = `services[${serviceId}][quantity]`;
            } else {
                quantityInput.disabled = true;
                quantityInput.name = '';
            }
        });
    });

    // Populate initial state of services
    function populateServices() {
        @foreach($services as $service)
        var checkbox = document.getElementById('service_{{ $service->id }}');
        var quantityInput = document.getElementById('quantity_service_{{ $service->id }}');
        if (checkbox.checked) {
            quantityInput.disabled = false;
            quantityInput.name = `services[{{ $service->id }}][quantity]`;
        } else {
            quantityInput.disabled = true;
            quantityInput.name = '';
        }
        @endforeach
    }

    populateServices();

    const addonServiceCheckboxes = document.querySelectorAll('.addon-service-checkbox');

});

</script>

@endsection
