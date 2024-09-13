@extends('layouts.main2')
@php
    $pageTitle = "Select Room";
@endphp
@section('main-container')

<style>
    .room-section {
        margin-bottom: 80px;
    }

    .room-header {
        margin-bottom: 20px;
    }

    .room-card {
        background: #f9daba6b;
        padding: 20px;
        border-radius: 20px;
        margin: 10px;
        display: flex;
        flex-direction: column;
        flex: 0 0 auto;
    }

    .card-img-top {
        border-radius: 8px;
        aspect-ratio: 3/3;
        width: 100%;
    }

    .card-body {
        margin-top: 5px;
    }

    .card-text {
        font-size: 14px;
    }

    .room-btn_select {
        display: flex;
        justify-content: space-between;
        padding: 8px 15px 8px 15px;
    }

    #selected-rooms-list {
        padding-left: 0px;
    }

    .card-title {
        font-size: 1.7rem;
    }

    .draggable-row {
        display: flex;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
        padding: 10px 0;
    }

    /* Style the scrollbar */
    .draggable-row::-webkit-scrollbar {
        height: 12px; /* Height of horizontal scrollbar */
    }

    .draggable-row::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .draggable-row::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .draggable-row::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    @media (min-width: 1200px) {
        .room-card {
            width: 23%;
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .room-card {
            width: 32%;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .room-card {
            width: 48%;
        }
    }

    @media (max-width: 767px) {
        .room-card {
            width: 85%;
        }
    }
</style>

<section class="layout-pt-lg layout-pb-lg">
    <div class="container">
        <div class="row justify-center text-center">
            <div class="col-xl-6 col-lg-8 col-md-10" data-split='lines' data-anim="split-lines delay-1">
                <div class="text-15 uppercase mb-30 sm:mb-10">
                    CHOOSE YOUR ROOM TYPE
                </div>
                <h2 class="text-64 md:text-40 lh-11">
                    Discover Our Rooms & Suites
                </h2>
                <p class="mt-40">
                    Come in, take your shoes off and let yourself sink<br class="lg:d-none">
                    into the mattress.
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="tabs -underline-2 pt-50 lg:pt-30 js-tabs">
            <div class="tabs__controls row x-gap-30 lg:x-gap-20 js-tabs-controls">
                @for ($i = 1; $i <= $totalRooms; $i++)
                <div class="col-auto">
                    <button style="background: green; color:#fff; padding-right:5px; padding-left:5px; " class="tabs__button fw-500 pb-10 js-tabs-button {{ $i === 1 ? 'is-tab-el-active' : '' }}" data-tab-target=".-tab-item-{{ $i }}">
                        Room {{ $i }}
                    </button>
                </div>
                @endfor
            </div>

            <div class="tabs__content pt-20 js-tabs-content">
                @for ($i = 1; $i <= $totalRooms; $i++)
                <div class="tabs__pane -tab-item-{{ $i }} {{ $i === 1 ? 'is-tab-el-active' : '' }}">
                    <div class="room-section">
                        <p class="text-15 mb-30 sm:mb-10 {{ session()->has("room_{$i}_selected") ? 'bg-success' : '' }}">Select Room Type For Room {{ $i }}</p>

                        @if (empty($availableRooms[$i]))
                        <p>No rooms available for {{ $i }} guests.</p>
                        @else
                        <div class="draggable-row">
                            @foreach ($availableRooms[$i] as $room)
                            <div class="room-card">
                                <img src="{{ asset('storage/' . $room->room_img) }}" class="card-img-top" alt="{{ $room->room_type }}">
                                <div class="card-body">
                                    <h2 class="card-title">{{ $room->room_type }}</h2>
                                    <p class="card-text">{{ \Illuminate\Support\Str::words($room->room_description, 30, '...') }}</p>
                                    <button class="select-room-btn button -outline-accent-2 bg-white w-1/1 rounded-8" style="display: block;" data-room-id="{{ $room->id }}" data-room-number="{{ $i }}" data-room-price="{{ $room->price * $nights }}" data-room-name="{{ $room->room_type }}">
                                        <span class="room-btn_select"><span> Select Room</span>  <span> RM{{ $room->price * $nights }}</span></span>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endfor
            </div>
        </div>

    <hr>

    <!-- Total of Rooms Price  - Section -->
    <div class="row mt-4 justify-content-end">
      <form id="room-selection-form" method="POST" action="{{ route('booking.store') }}">
          @csrf
          <h4 style="font-family: sans-serif">Stay Duration: <strong>{{ $sessionData['check_in_check_out'] }} ({{ $nights }} Nights)</strong></h4>
          <div id="selected-rooms-summary">
              <h4>Selected Rooms</h4>
              <ul id="selected-rooms-list"></ul>
              <div id="discount-container"></div>
              <h3 id="total-price" style="font-family: sans-serif">Total Stay: RM 0</h3>
          </div>
          <br>
          <input type="hidden" name="check_in_check_out" value="{{ $sessionData['check_in_check_out'] }}">
          <input type="hidden" name="package_id" value="{{ $sessionData['package_id'] }}">
          <input type="hidden" name="no_of_rooms" value="{{ $totalRooms }}">
          <input type="hidden" name="no_of_nights" value="{{ $nights }}">
          @for ($i = 1; $i <= $totalRooms; $i++)
              <input type="hidden" name="room_{{ $i }}" id="room_{{ $i }}_input">
              <input type="hidden" name="room_{{ $i }}_price" id="room_{{ $i }}_price">
              <input type="hidden" name="room_{{ $i }}_name" id="room_{{ $i }}_name">
              <input type="hidden" name="room_{{ $i }}_adults" value="{{ $sessionData["room_{$i}_adults"] }}">
              <input type="hidden" name="room_{{ $i }}_children" value="{{ $sessionData["room_{$i}_children"] }}">
              <input type="hidden" name="room_{{ $i }}_kids" value="{{ $sessionData["room_{$i}_kids"] }}">
              <input type="hidden" name="room_{{ $i }}_toddlers" value="{{ $sessionData["room_{$i}_toddlers"] }}">
          @endfor
          <input type="hidden" name="total_price" id="total_price_input">
          <button type="submit" class="button -md -type-2 -accent-1 bg-accent-2 w-1/1 mb-20">Confirm Room Selection</button>
      </form>
    </div>

  </div>

</section>

<section class="layout-pt-md layout-pb-md bg-light-1">
   <div data-anim-wrap class="container">
     <div class="row justify-center text-center">
       <div data-split='lines' data-anim-child="split-lines delay-2" class="col-auto">
         <div class="text-15 uppercase mb-30 sm:mb-10">OUR SERVICES</div>
         <h2 class="text-64 md:text-40">Hotel Facilities</h2>
       </div>
     </div>

     <div class="row y-gap-40 justify-between pt-100 sm:pt-50">

       <div data-anim-child="slide-up delay-4" class="col-lg-auto col-md-4 col-6">
         <div class="iconCard -type-1 -hover-1 text-center">
           <div class="iconCard__icon text-50">
             <div class="iconCard__icon__circle bg-white"></div>
             <i class="icon-wifi"></i>
           </div>
           <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Wifi &amp; Internet</h4>
         </div>
       </div>

       <div data-anim-child="slide-up delay-5" class="col-lg-auto col-md-4 col-6">
         <div class="iconCard -type-1 -hover-1 text-center">
           <div class="iconCard__icon text-50">
             <div class="iconCard__icon__circle bg-white"></div>
             <i class="icon-bus"></i>
           </div>
           <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Airport Transfer</h4>
         </div>
       </div>

       <div data-anim-child="slide-up delay-6" class="col-lg-auto col-md-4 col-6">
         <div class="iconCard -type-1 -hover-1 text-center">
           <div class="iconCard__icon text-50">
             <div class="iconCard__icon__circle bg-white"></div>
             <i class="icon-tv"></i>
           </div>
           <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Smart TV</h4>
         </div>
       </div>

       <div data-anim-child="slide-up delay-7" class="col-lg-auto col-md-4 col-6">
         <div class="iconCard -type-1 -hover-1 text-center">
           <div class="iconCard__icon text-50">
             <div class="iconCard__icon__circle bg-white"></div>
             <i class="icon-bed"></i>
           </div>
           <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Breakfast in Bed</h4>
         </div>
       </div>

       <div data-anim-child="slide-up delay-8" class="col-lg-auto col-md-4 col-6">
         <div class="iconCard -type-1 -hover-1 text-center">
           <div class="iconCard__icon text-50">
             <div class="iconCard__icon__circle bg-white"></div>
             <i class="icon-laundry"></i>
           </div>
           <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Laundry Services</h4>
         </div>
       </div>

       <div data-anim-child="slide-up delay-9" class="col-lg-auto col-md-4 col-6">
         <div class="iconCard -type-1 -hover-1 text-center">
           <div class="iconCard__icon text-50">
             <div class="iconCard__icon__circle bg-white"></div>
             <i class="icon-housekeeper"></i>
           </div>
           <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Housekeeper Services</h4>
         </div>
       </div>

     </div>
   </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectRoomButtons = document.querySelectorAll('.select-room-btn');
    const selectedRoomsList = document.getElementById('selected-rooms-list');
    const totalPriceElement = document.getElementById('total-price');
    const totalPriceInput = document.getElementById('total_price_input');
    const discountContainer = document.getElementById('discount-container');
    let totalPrice = 0;
    const selectedRooms = {};
    const totalRooms = {{ $totalRooms }};
    const sessionData = @json($sessionData);
    const bookingSettings = @json($bookingSettings);
    const nights = {{ $nights }};

    // Initialize the selected rooms summary with default messages
    function initializeSummary() {
        selectedRoomsList.innerHTML = '';
        for (let i = 1; i <= totalRooms; i++) {
            const listItem = document.createElement('li');
            const guestDetails = getGuestDetails(sessionData, i);
            listItem.setAttribute('id', `room_${i}_summary`);
            listItem.style.color = 'red';
            listItem.textContent = `Room ${i} - Please Select Room ${i} (${guestDetails})`;
            selectedRoomsList.appendChild(listItem);
        }
    }

    function getGuestDetails(sessionData, roomNumber) {
        const adults = parseInt(sessionData[`room_${roomNumber}_adults`]);
        const children = parseInt(sessionData[`room_${roomNumber}_children`]);
        const kids = parseInt(sessionData[`room_${roomNumber}_kids`]);
        const toddlers = parseInt(sessionData[`room_${roomNumber}_toddlers`]);
        let guestDetails = `Adults - ${adults}`;
        if (children > 0) guestDetails += `, Children - ${children}`;
        if (kids > 0) guestDetails += `, Kids - ${kids}`;
        if (toddlers > 0) guestDetails += `, Toddlers - ${toddlers}`;
        return guestDetails;
    }

    selectRoomButtons.forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-room-id');
            const roomNumber = this.getAttribute('data-room-number');
            const roomPrice = parseFloat(this.getAttribute('data-room-price'));
            const roomName = this.getAttribute('data-room-name');

            document.getElementById(`room_${roomNumber}_input`).value = roomId;
            document.getElementById(`room_${roomNumber}_price`).value = roomPrice;
            document.getElementById(`room_${roomNumber}_name`).value = roomName;

            // Unselect previously selected room for this roomNumber
            document.querySelectorAll(`.select-room-btn[data-room-number="${roomNumber}"]`).forEach(btn => {
                btn.classList.remove('button', '-accent-1', 'bg-accent-2');
                btn.classList.add('-outline-accent-2', 'bg-white');
                btn.innerHTML = `<span class="room-btn_select"><span> Select Room</span>  <span> RM${btn.getAttribute('data-room-price')}</span></span>`;
            });

            // Select current room
            this.classList.remove('-outline-accent-2', 'bg-white');
            this.classList.add('button', '-accent-1', 'bg-accent-2');
            this.innerHTML = `<span class="room-btn_select"><span> Selected Room</span>  <span> RM${roomPrice}</span></span>`;

            // Update selected rooms and total price
            if (selectedRooms[roomNumber]) {
                totalPrice -= selectedRooms[roomNumber].price;
            }
            selectedRooms[roomNumber] = { name: roomName, price: roomPrice };
            totalPrice += roomPrice;

            updateSelectedRoomsSummary();
        });
    });

    function applyDiscounts() {
        let totalDiscount = 0;
        let adultDiscountTotal = 0;
        let childrenDiscountTotal = 0;
        let kidsDiscountTotal = 0;
        let toddlersDiscountTotal = 0;

        for (let i = 1; i <= totalRooms; i++) {
            const adults = parseInt(sessionData[`room_${i}_adults`]);
            const children = parseInt(sessionData[`room_${i}_children`]);
            const kids = parseInt(sessionData[`room_${i}_kids`]);
            const toddlers = parseInt(sessionData[`room_${i}_toddlers`]);

            console.log(`Room ${i}: Adults - ${adults}, Children - ${children}, Kids - ${kids}, Toddlers - ${toddlers}`);

            const totalGuests = adults + children + kids + toddlers;
            const roomPricePerPerson = selectedRooms[i] ? selectedRooms[i].price / totalGuests : 0;

            console.log(`Room ${i}: Total Guests - ${totalGuests}, Room Price Per Person - ${roomPricePerPerson}`);

            const adultDiscountAmount = roomPricePerPerson * adults * (bookingSettings.adult_discount / 100);
            const childrenDiscountAmount = roomPricePerPerson * children * (bookingSettings.children_discount / 100);
            const kidsDiscountAmount = roomPricePerPerson * kids * (bookingSettings.kids_discount / 100);
            const toddlersDiscountAmount = roomPricePerPerson * toddlers * (bookingSettings.Toddlers_discount / 100);

            console.log(`Room ${i}: Adult Discount - ${adultDiscountAmount}, Children Discount - ${childrenDiscountAmount}, Kids Discount - ${kidsDiscountAmount}, Toddlers Discount - ${toddlersDiscountAmount}`);

            adultDiscountTotal += adultDiscountAmount;
            childrenDiscountTotal += childrenDiscountAmount;
            kidsDiscountTotal += kidsDiscountAmount;
            toddlersDiscountTotal += toddlersDiscountAmount;

            totalDiscount += adultDiscountAmount + childrenDiscountAmount + kidsDiscountAmount + toddlersDiscountAmount;
        }

        console.log(`Total Discount: ${totalDiscount}`);
        return {
            totalDiscount: totalDiscount,
            adultDiscountTotal: adultDiscountTotal,
            childrenDiscountTotal: childrenDiscountTotal,
            kidsDiscountTotal: kidsDiscountTotal,
            toddlersDiscountTotal: toddlersDiscountTotal
        };
    }

    function updateSelectedRoomsSummary() {
        for (let i = 1; i <= totalRooms; i++) {
            const listItem = document.getElementById(`room_${i}_summary`);
            if (selectedRooms[i]) {
                const room = selectedRooms[i];
                listItem.style.color = 'black';
                listItem.textContent = `Room ${i} - ${room.name} (RM ${room.price}) (${getGuestDetails(sessionData, i)})`;
            } else {
                listItem.style.color = 'red';
                listItem.textContent = `Room ${i} - Please Select Room ${i} (${getGuestDetails(sessionData, i)})`;
            }
        }

        const discounts = applyDiscounts();
        const finalPrice = (totalPrice - discounts.totalDiscount).toFixed(2);

        console.log(`Total Price before discount: ${totalPrice}`);
        console.log(`Final Price after discount: ${finalPrice}`);

        totalPriceElement.textContent = `Total stay: RM ${finalPrice}`;
        totalPriceInput.value = finalPrice;

        // Update the discount container
        discountContainer.innerHTML = '';
        if (discounts.childrenDiscountTotal > 0) {
            discountContainer.innerHTML += `Children Discount: RM ${discounts.childrenDiscountTotal.toFixed(2)}<br>`;
        }
        if (discounts.kidsDiscountTotal > 0) {
            discountContainer.innerHTML += `Kids Discount: RM ${discounts.kidsDiscountTotal.toFixed(2)}<br>`;
        }
        if (discounts.toddlersDiscountTotal > 0) {
            discountContainer.innerHTML += `Toddlers Discount: RM ${discounts.toddlersDiscountTotal.toFixed(2)}<br>`;
        }
        if (discounts.adultDiscountTotal > 0) {
            discountContainer.innerHTML += `Adult Discount: RM ${discounts.adultDiscountTotal.toFixed(2)}<br>`;
        }
        discountContainer.innerHTML += `Total Discount: RM ${discounts.totalDiscount.toFixed(2)}`;
    }

    initializeSummary();

    const form = document.getElementById('room-selection-form');

    form.addEventListener('submit', function(event) {
        let allRoomsSelected = true;
        let unselectedRooms = [];

        for (let i = 1; i <= totalRooms; i++) {
            const roomInput = document.getElementById(`room_${i}_input`);
            if (!roomInput.value) {
                allRoomsSelected = false;
                unselectedRooms.push(i);
            }
        }

        if (!allRoomsSelected) {
            event.preventDefault(); // Prevent form submission
            alert(`Please select a room for Room ${unselectedRooms.join(', ')}`);
        }
    });
});
</script>

</script>

</script>

</script>

@endsection
