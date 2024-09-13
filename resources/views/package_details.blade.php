@extends('layouts.main2')
   @php
      $pageTitle = "Package Details";
   @endphp
@section('main-container')
<style>
    .modal {
       display: none;
       position: fixed;
       z-index: 999999;
       left: 0;
       top: 0;
       width: 100%;
       height: 100%;
       overflow: auto;
       background-color: rgb(0,0,0);
       background-color: rgba(0,0,0,0.9);
    }

    .modal-content {
       position: relative;
       margin-top: 10%;
       padding: 0;
       width: 80%;
       max-width: 1200px;
       margin-right: auto;
       margin-left: auto;
    }

    .close {
       color: white;
       position: absolute;
       top: 10px;
       right: 25px;
       font-size: 35px;
       font-weight: bold;
       cursor: pointer;
    }

    .prev, .next {
       cursor: pointer;
       position: absolute;
       top: 50%;
       width: auto;
       padding: 16px;
       margin-top: -50px;
       color: white;
       background:#000;
       font-weight: bold;
       font-size: 20px;
       transition: 0.6s ease;
       border-radius: 0 3px 3px 0;
       user-select: none;
       -webkit-user-select: none;
    }

    .next {
       right: 0;
       border-radius: 3px 0 0 3px;
    }
    .prev:hover, .next:hover {
       background-color: rgba(0,0,0,0.8);
    }

    .services-container {
       display: grid;
       grid-template-columns: repeat(4, 1fr);
       gap: 20px; /* Adjust the gap between items as needed */
       text-align: center;
    }

    .service-item img {
       max-width: 100%; /* Ensure images are responsive */
    }


    /*FOR ROOM SELECTION*/
    .custom-modal {
       display: none;
       position: fixed;
       z-index: 9999;
       left: 0;
       top: 0;
       width: 100%;
       height: 100%;
       overflow: auto;
       background-color: rgba(0, 0, 0, 0.4);
       padding-top: 60px;
    }

    .custom-modal-content {
       background-color: #fefefe;
       margin: 5% auto;
       padding: 20px;
       border: 1px solid #888;
       width: 99%;
       max-width: 640px;
    }

    .custom-modal-footer {
       text-align: right;
       margin-top: 20px;
    }

    .room-allocation {
       margin-bottom: 20px;
    }
    .guest-selection {
       display: flex;
       flex-wrap: nowrap;
       gap: 10px;
    }
    .guest-input-group {
       display: flex;
       flex-direction: column;
       flex: 1 1 100%;
    }
    .guest-input-group label {
       margin-bottom: 5px;
    }
    .guest-input-group select {
       padding: 5px;
       border: 1px solid #ccc;
       border-radius: 5px;
    }
    .custom-button {
       padding: 10px 20px;
       background-color: #f7b7a3;
       border: none;
       border-radius: 5px;
       cursor: pointer;
    }
    .custom-button:hover {
       background-color: #f6a085;
    }

    @media (min-width: 600px) {
        .guest-input-group {
            flex: 1 1 22%;
        }
    }

    @media (max-width:575px){

        .roomsSingleGrid.-type-1 .roomsSingleGrid__button {
            bottom: 15px;
            right: 5px;
            border-radius: 4px;
            height: 28px;
            padding: 0px 5px;
        }

        .modal-content {
            margin-top: 50%;
            width: 80%;
        }

        .prev, .next {
            top: 70%;
            width: auto;
            padding: 10px;
            margin-top: -50px;
            font-size: 8px;
        }
    }

</style>

<script>
   // Function to get query parameters from the URL
   function getQueryParam(param) {
   var urlParams = new URLSearchParams(window.location.search);
   return urlParams.get(param);
   }
</script>

<section class="layout-pt-md sm:pt-100">
   <div data-anim-wrap class="container">
      <div class="row y-gap-30 justify-between items-end">
         <div class="col-auto">
            <h1 data-anim-child="slide-up delay-1" class="text-64 md:text-40">{{ Str::title($package->package_name) }}</h1>
         </div>
      </div>
      <div data-anim-child="slide-up delay-4" class="row">
         <div class="col-12">
            <div class="roomsSingleGrid -type-1">
               @if($package->main_image)
               <img src="{{ Storage::url($package->main_image) }}" alt="{{ $package->package_name }}">
               @endif
               @php
               $otherImages = json_decode($package->other_images, true);
               @endphp
               @if($otherImages)
               @foreach(array_slice($otherImages, 0, 4) as $image)
               <img src="{{ Storage::url($image) }}" alt="Additional Image">
               @endforeach
               @endif
               <!-- Button that triggers the gallery modal -->
               <div class="col-12">
                  <div class="roomsSingleGrid__button" data-toggle="modal" data-target="#packageGalleryModal">
                     <div class="icon-photo text-20 mr-10"></div>
                     <button class="text-15 fw-500" id="viewAllPhotos">View All Photos</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Package Gallery Modal -->
      <div id="packageGalleryModal" class="modal">
         <span class="close">&times;</span>
         <div class="modal-content">
            <div id="imagesSlide" class="slides">
               <!-- Images will be inserted here dynamically -->
            </div>
            <!-- Add arrows for navigation if needed -->
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
         </div>
      </div>
      <div class="row y-gap-40 justify-between">
         <div class="col-xl-7 col-lg-7">
            <h2 class="text-40">About {{ Str::title($package->package_name) }}</h2>
            <div class="mt-40" style="white-space: pre-wrap;">{{ $package->long_description }}</div>

            <div class="line -horizontal bg-border mt-50 mb-50"></div>
            <h2 class="text-40">Package Amenities</h2>
            <div class="row x-gap-50 y-gap-20 justify-between">
               <div class="col-sm-5">
                  <div class="row y-gap-30">
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-wifi text-30 mr-30"></div>
                           <div>Wifi &amp; Internet</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-safe text-30 mr-30"></div>
                           <div>Safe Box</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-conditioner text-30 mr-30"></div>
                           <div>Air conditioner</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-breakfast text-30 mr-30"></div>
                           <div>Breakfast Included</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-breakfast text-30 mr-30"></div>
                           <div>Lunch & Supper Included</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-breakfast text-30 mr-30"></div>
                           <div>Dinner Included</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-5">
                  <div class="row y-gap-30">
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-mini-bar text-30 mr-30"></div>
                           <div>MiniBar</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-shampoo text-30 mr-30"></div>
                           <div>Shampoo</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-hair-dryer text-30 mr-30"></div>
                           <div>Hair Dryer</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-welcome-drinks text-30 mr-30"></div>
                           <div>Welcome Drinks</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-shower-bath text-30 mr-30"></div>
                           <div>Hot Shower</div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="d-flex items-center">
                           <div class="icon-housekeeper-services text-30 mr-30"></div>
                           <div>Housekeeper Services</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="line -horizontal bg-border mt-50 mb-50"></div>
            <h2 class="text-40">What's included in this suite?</h2>
            <div class="row x-gap-50 y-gap-20">
               <div class="col-sm-6">
                  <ul class="ulList -type-1">
                     <li>240v electrical sockets with USb port</li>
                     <li>Safety box</li>
                     <li>5 Star Mattress</li>
                  </ul>
               </div>
               <div class="col-sm-6">
                  <ul class="ulList -type-1">
                     <li>Bath Towel</li>
                     <li>Kangen Water</li>
                     <li>Water Kettle</li>
                  </ul>
               </div>
            </div>
            
            <div class="line -horizontal bg-border mt-50 mb-50"></div>
            <h2 class="text-40">Room Rules</h2>
            <ul class="ulList -type-1 pt-40">
               <li>Check-in from 1:00 PM - anytime</li>
               <li>Check-out: 10:00 AM</li>
               <li>Smoking Now Allowed (Penalty RM1000)</li>
               <li>No Pets Allowed</li>
               <li>Durian Not Allowed</li>
               <li>No rubbish in the toilet.</li>
               <li>Do not use towels as floor mats or cleaning cloths. Penalty applies.</li>
            </ul>
         </div>
         <div class="col-xl-4 col-lg-5">
            <form action="{{ route('booking.preRoomSelection') }}" method="POST">
               @csrf
               <div class="sidebar -rooms-single px-40 py-40 md:px-30 md:py-30 border-1 shadow-1">
                   <h3 class="text-30 mb-30">Book Your Package</h3>

                   <div style="margin-bottom: 10px;">
                       <label for="checkInCheckOut" style="display: block; margin-bottom: 5px;">Check In - Check Out</label>
                       <input type="text" id="checkInCheckOut" name="check_in_check_out" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Select date range">
                       <input type="hidden" id="minDurationDays" value="{{ $minDuration['days'] }}">
                       <input type="hidden" id="minDurationNights" value="{{ $minDuration['nights'] }}">
                       @error('check_in_check_out')
                       <span class="text-danger">{{ $message }}</span>
                       @enderror
                   </div>

                   <p id="daysNights" class="daysNights"></p>
                   <input type="hidden" name="package_id" value="{{ $package->id }}">

                   <div style="margin-bottom: 20px;">
                       <label for="no_of_rooms" style="display: block; margin-bottom: 5px;">Select Number of Rooms</label>
                       <select id="no_of_rooms" name="no_of_rooms" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                           @for($i = 0; $i <= 10; $i++)
                               <option value="{{ $i }}">{{ $i }}</option>
                           @endfor
                       </select>
                   </div>

                   <button type="button" id="editGuestAllocationBtn" style="padding: 5px 10px 5px 10px; border-radius: 10px;" class="button -type-2 -outline-accent-2 bg-white mb-20">Edit Guest Allocation</button>
                   <button type="submit" id="next-step-btn" class="button -md bg-accent-2 -dark-1 w-1/1">Proceed To Next Step</button>
                   <h3 class="text-30 mb-20 mt-40">Services Included</h3>
                   <div class="extra-services-container" style="display: flex; align-items: center; justify-content: start; gap: 25px;">
                       <div class="services-container">
                           @foreach ($includedServices as $service)
                           <div class="service-item">
                               <span>
                                   <img src="/storage/{{ $service->image_path }}">
                                   <br>{{ $service->service_name }}
                               </span>
                           </div>
                           @endforeach
                       </div>
                   </div>
               </div>
            </form>

            <div id="guestAllocationModal" class="custom-modal">
               <div class="custom-modal-content">
                  <h4>Enter Guest Numbers for Each Room</h4>
                  <form id="guestAllocationForm">
                     <!-- Dynamic content will be added here by JavaScript -->
                  </form>
                  <div class="custom-modal-footer">
                     <button type="button" class="custom-button" onclick="saveGuestAllocation()">Save</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="layout-pt-md layout-pb-md">
   <div data-anim-wrap class="container">
      <div class="row y-gap-30 justify-between items-end">
         <div data-anim-child="slide-up delay-1" class="col-auto">
            <div class="text-15 uppercase mb-30 sm:mb-10">EXPLORE</div>
            <h2 class="text-64 md:text-40 lh-065">Similar Packages</h2>
         </div>
         <div data-anim-child="slide-up delay-1" class="col-auto">
            <button onclick="window.location.href='{{ route('search_results') }}'" class="button -type-1">
            <i class="-icon icon-arrow-circle-right text-30"></i>
            VIEW ALL MORE
            </button>
         </div>
      </div>
      <div class="relative mt-100 sm:mt-50">
         <div class="overflow-hidden js-section-slider" data-gap="30" data-slider-cols="xl-3 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider2-prev" data-nav-next="js-slider2-next">
            <div class="swiper-wrapper">
                @if($similarPackages && $similarPackages->isNotEmpty())
                @foreach ($similarPackages as $package)
                <div class="swiper-slide">
                   <div data-anim-child="slide-up delay-4">
                      <a href="{{ route('package_details', $package->id) }}" class="roomCard -type-2 -hover-button-center">
                         <div class="roomCard__image -no-rounded ratio ratio-45:54 -hover-button-center__wrap">
                            <img src="/storage/{{ $package->main_image }}" alt="image" class="img-ratio">
                            <div class="roomCard__price round-0 text-15 fw-500 bg-white text-accent-1">
                                RM{{ $package->package_initial_price }} / PAX
                            </div>
                            <div class="-hover-button-center__button flex-center size-130 rounded-full bg-accent-1-50 blur-1 border-white-10">
                               <span class="text-15 fw-500 text-white">BOOK NOW</span>
                            </div>
                         </div>
                         <div class="roomCard__content mt-30">
                            <div class="d-flex justify-between items-end">
                               <h3 class="roomCard__title lh-065 text-40 md:text-24">{{ $package->package_name }}</h3>
                            </div>
                         </div>
                      </a>
                   </div>
                </div>
                @endforeach
            @else
            <div class="swiper-slide">
                <div data-anim-child="slide-up delay-4">
                    <p>No Other Packages Available</p>
                </div>
            </div>
            @endif

            </div>
         </div>
         <div class="navAbsolute -type-2">
            <button class="button -outline-accent-1 size-80 md:size-60 flex-center rounded-full js-slider2-prev">
            <i class="icon-arrow-left text-24"></i>
            </button>
            <button class="button -outline-accent-1 size-80 md:size-60 flex-center rounded-full js-slider2-next">
            <i class="icon-arrow-right text-24"></i>
            </button>
         </div>
      </div>
   </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    localStorage.removeItem('guestAllocation');

    const checkInCheckOutInput = document.getElementById('checkInCheckOut');
    const daysNightsParagraph = document.getElementById('daysNights');

    // For service images structure
    const serviceItems = document.querySelectorAll('.service-item');
    const servicesContainer = document.querySelector('.services-container');
    if (serviceItems.length > 8) {
        for (let i = 8; i < serviceItems.length; i++) {
            let clone = serviceItems[i % 8].cloneNode(true);
            servicesContainer.appendChild(clone);
        }
    }

    const noOfRoomsSelect = document.getElementById('no_of_rooms');
    const guestAllocationModal = document.getElementById('guestAllocationModal');
    const guestAllocationForm = document.getElementById('guestAllocationForm');
    const editGuestAllocationBtn = document.getElementById('editGuestAllocationBtn');
    const mainForm = document.querySelector('form[action="{{ route('booking.preRoomSelection') }}"]');
    const nextStepBtn = document.getElementById('next-step-btn');

    noOfRoomsSelect.addEventListener('change', function() {
        generateGuestAllocationFields(this.value);
        showGuestAllocationModal();
    });

    editGuestAllocationBtn.addEventListener('click', function() {
        if (noOfRoomsSelect.value == 0) {
            alert('Please select the number of rooms first.');
        } else {
            showGuestAllocationModal();
        }
    });

    function generateGuestAllocationFields(roomCount) {
        const storedGuestData = JSON.parse(localStorage.getItem('guestAllocation')) || {};
        guestAllocationForm.innerHTML = '';
        for (let i = 1; i <= roomCount; i++) {
            const roomDiv = document.createElement('div');
            roomDiv.classList.add('room-allocation');
            roomDiv.innerHTML = `
               <h5>Room ${i}</h5>
               <div class="guest-selection">
                  <div class="guest-input-group">
                    <label>Adults <span class="lbl_small-text">(13+) years:</span></label>
                    <select name="room_${i}_adults">
                        ${generateOptions(10, storedGuestData[`room_${i}_adults`])}
                    </select>
                  </div>
                  <div class="guest-input-group">
                     <label>Children <span class="lbl_small-text">(7-12) years:</span></label>
                     <select name="room_${i}_children">
                        ${generateOptions(10, storedGuestData[`room_${i}_children`])}
                     </select>
                  </div>
                  <div class="guest-input-group">
                     <label>Young Kids <span class="lbl_small-text">(3-6) years:</span></label>
                     <select name="room_${i}_kids">
                        ${generateOptions(10, storedGuestData[`room_${i}_kids`])}
                     </select>
                  </div>
                  <div class="guest-input-group">
                     <label>Toddlers <span class="lbl_small-text">(0-2) years:</span></label>
                     <select name="room_${i}_toddlers">
                        ${generateOptions(10, storedGuestData[`room_${i}_toddlers`])}
                     </select>
                  </div>
               </div>
            `;
            guestAllocationForm.appendChild(roomDiv);
        }
    }

    window.saveGuestAllocation = function() {
        // Save the guest allocation data
        const formData = new FormData(guestAllocationForm);
        const guestData = {};
        let valid = true;

        formData.forEach((value, key) => {
            guestData[key] = value;
        });

        // Validate that each room has at least 1 guest (adult, child, toddler, or infant)
        const roomCount = noOfRoomsSelect.value;
        for (let i = 1; i <= roomCount; i++) {
            const totalGuests =
                parseInt(guestData[`room_${i}_adults`] || 0) +
                parseInt(guestData[`room_${i}_children`] || 0) +
                parseInt(guestData[`room_${i}_kids`] || 0) +
                parseInt(guestData[`room_${i}_toddlers`] || 0);

            if (totalGuests == 0) {
                alert(`Room ${i} must have at least 1 guest.`);
                valid = false;
                break;
            }
        }

        if (valid) {
            localStorage.setItem('guestAllocation', JSON.stringify(guestData));
            guestAllocationModal.style.display = 'none';
            updateNextStepButton(true);
        }
    }

    function updateNextStepButton(isValid) {
        if (isValid) {
            nextStepBtn.style.setProperty('background-color', 'green', 'important');
            nextStepBtn.style.setProperty('color', 'white', 'important');
            nextStepBtn.disabled = false;
        } else {
            nextStepBtn.style.backgroundColor = '';
            nextStepBtn.style.color = '';
        }
    }

    window.onclick = function(event) {
        if (event.target == guestAllocationModal) {
            guestAllocationModal.style.display = 'none';
        }
    }

    // Prepopulate data if available
    const storedGuestData = JSON.parse(localStorage.getItem('guestAllocation'));
    if (storedGuestData) {
        const roomCount = Object.keys(storedGuestData).length / 4; // Assuming 4 fields per room
        generateGuestAllocationFields(roomCount);
        updateNextStepButton(true); // Assuming the prepopulated data is valid
    } else {
        updateNextStepButton(false);
    }

    mainForm.addEventListener('submit', function(event) {
        const storedGuestData = JSON.parse(localStorage.getItem('guestAllocation'));
        if (!storedGuestData) {
            alert('Please complete the guest allocation.');
            event.preventDefault();
        } else {
            for (const key in storedGuestData) {
                if (storedGuestData.hasOwnProperty(key)) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = key;
                    hiddenInput.value = storedGuestData[key];
                    this.appendChild(hiddenInput);
                }
            }
        }
    });

    function generateOptions(max, selectedValue = 0) {
        let options = '';
        for (let i = 0; i <= max; i++) {
            options += `<option value="${i}" ${i == selectedValue ? 'selected' : ''}>${i}</option>`;
        }
        return options;
    }

    function showGuestAllocationModal() {
        guestAllocationModal.style.display = 'block';
    }
});



function generateOptions(max, selectedValue = 0) {
   let options = '';
   for (let i = 0; i <= max; i++) {
      options += `<option value="${i}" ${i == selectedValue ? 'selected' : ''}>${i}</option>`;
   }
   return options;
}

function showGuestAllocationModal() {
   guestAllocationModal.style.display = 'block';
}


function calculateDaysNights(startDate, endDate) {
   if (!startDate || !endDate) {
       return { days: 0, nights: 0 };
   }
   const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
   const diffDays = Math.round(Math.abs((endDate - startDate) / oneDay)) + 1; // +1 to include the start day
   const nights = diffDays - 1;
   return { days: diffDays, nights: nights };
}

//required for gallery
var otherImages = [
   @foreach($otherImagesArray as $imagePath)
      "{{ Storage::url($imagePath) }}",
   @endforeach
];


// Parse the check-in and check-out dates from the URL
var checkInCheckOut = getQueryParam('checkincheckout');
if (checkInCheckOut) {
    var dates = checkInCheckOut.split(' to ');
    var checkInDate = dates[0];
    var checkOutDate = dates[1];
    var checkInCheckOutInput = document.getElementById('checkInCheckOut');
    if (checkInCheckOutInput && checkInDate && checkOutDate) {
        checkInCheckOutInput.value = checkInDate + ' to ' + checkOutDate;
    }
}

</script>

<script src="{{asset('js/gallery.js')}}"></script>

@endsection
