@extends('layouts.main2')
@php
$pageTitle = "Room Details";
@endphp
@section('main-container')

<section class="layout-pt-lg md:pt-74">
    <div data-anim="slide-up delay-1" class="relative">
        @if(is_array($currentRoom->room_gallery) && count($currentRoom->room_gallery) > 0)
        <div class="js-section-slider-auto">
            <div class="swiper-wrapper">
                @foreach($currentRoom->room_gallery as $image)
                <div class="swiper-slide w-auto">
                    <img src="{{ asset('storage/' . $image) }}" alt="image" class="Room_slider_image">
                </div>
                @endforeach
            </div>
        </div>
        @else
        <p>No gallery images available.</p>
        @endif

      <div class="navAbsolute -type-3">
        <button class="size-80 flex-center bg-accent-1-50 blur-1 rounded-full js-slider-auto-prev">
          <i class="icon-arrow-left text-24 text-white"></i>
        </button>

        <button class="size-80 flex-center bg-accent-1-50 blur-1 rounded-full js-slider-auto-next">
          <i class="icon-arrow-right text-24 text-white"></i>
        </button>
      </div>
    </div>

    <div data-anim-wrap class="container">
      <div class="row y-gap-40 justify-between pt-20 sm:pt-50">
        <div data-anim="slide-up delay-1" class="">
          <h1 class="text-64 md:text-40">{{$currentRoom->room_type}}</h1>

          <div class="line -horizontal bg-border mt-20 mb-20"></div>

          <p class="mt-40">{{$currentRoom->room_description}}</p>

          <div class="line -horizontal bg-border mt-40 mb-20"></div>
          <h2 class="text-40">Room Amenities</h2>
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
          <h2 class="text-40">What's included in this Room?</h2>
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
      </div>
    </div>
  </section>

  <section class="layout-pt-md layout-pb-md">
    <div data-anim-wrap class="container">
      <div class="row y-gap-30 justify-between items-end">
        <div data-anim-child="slide-up delay-1" class="col-auto">
          <div class="text-15 uppercase mb-30 sm:mb-10">EXPLORE</div>
          <h2 class="text-64 md:text-40 lh-065">Similar Rooms</h2>
        </div>
      </div>

      <div class="relative mt-50 sm:mt-50">
        <div class="overflow-hidden js-section-slider" data-gap="30" data-slider-cols="xl-3 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider2-prev" data-nav-next="js-slider2-next">
            <div class="swiper-wrapper">
                @foreach($suggestedRooms as $room)
                <div class="swiper-slide">
                    <div data-anim-child="slide-up delay-4">
                        <a href="{{ route('rooms.show', $room->id) }}" class="roomCard -type-2 -hover-button-center">
                            <div class="roomCard__image -no-rounded ratio ratio-45:54 -hover-button-center__wrap">
                                <img src="{{ asset('storage/' . $room->room_img) }}" alt="image" class="img-ratio">

                                <div class="roomCard__price round-0 text-15 fw-500 bg-white text-accent-1">
                                    ${{ $room->empty_bed_charge }} / NIGHT
                                </div>

                                <div class="-hover-button-center__button flex-center size-130 rounded-full bg-accent-1-50 blur-1 border-white-10">
                                    <span class="text-15 fw-500 text-white">BOOK NOW</span>
                                </div>
                            </div>

                            <div class="roomCard__content mt-30">
                                <div class="d-flex justify-between items-end">
                                    <h3 class="roomCard__title lh-065 text-40 md:text-24">{{ $room->room_type }}</h3>
                                </div>

                                <div class="d-flex x-gap-30 pt-30">

                                    <div class="d-flex items-center text-accent-1">
                                        <i class="icon-guest text-20 mr-10"></i>
                                        {{ $room->max_guest }} GUESTS
                                    </div>

                                    <div class="d-flex items-center text-accent-1">
                                        <i class="icon-bed-2 text-20 mr-10"></i>
                                        {{ $room->beds }} BEDS
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
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

@endsection
