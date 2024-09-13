@extends('layouts.main')
   @php
      $pageTitle = "All Rooms";
   @endphp
@section('main-container')


<section data-anim-wrap class="pageHero -type-1" style="height: 420px; padding-top:160px;">
   <div class="pageHero__bg" data-anim-child="img-right cover-white delay-1">
      <img src="/img/search_result/search_result_hero.png" alt="search_result_hero">
   </div>
   <div class="container">
      <div class="row justify-center">
         <div class="col-auto" style="backdrop-filter: blur(2px); padding: 20px;">
            <div class="pageHero__content text-center">
               <h1 class="pageHero__title text-white">All Rooms</h1>
               <p class="pageHero__text text-white">Indulge in luxury in our rooms and suites, featuring stunning
                  views, elegant furnishings, and modern amenities.</p>
            </div>
         </div>
      </div>
   </div>
</section>

 <section class="mt-100">
    <div data-anim-wrap class="container">
       <div class="row">
          <div class="col-auto">
             <h2 class="text-64 md:text-40 lh-11">
                Choose Your Room
             </h2>
          </div>
       </div>
       @foreach($rooms as $room)
       <div data-anim-wrap class="roomCard -type-2">
         <div class="row x-gap-30 y-gap-40 items-center pt-100 sm:pt-50">
           <div class="col-lg-6 col-md-6">
             <div data-anim-child="img-right cover-white delay-1">
               <a href="{{ route('rooms.show', $room->id) }}" class="roomCard__image -no-rounded ratio ratio-68:50">
                 <img src="{{ asset('storage/' . $room->room_img) }}" alt="image" class="img-ratio">
               </a>
             </div>
           </div>

           <div data-anim-child="slide-up delay-3" class="col-xl-4 col-lg-5 offset-lg-1 col-md-6">
             <div class="roomCard__content">
               <div class="d-flex justify-between items-end">
                 <h3 class="roomCard__title lh-065 text-40 md:text-40">{{ $room->room_type }}</h3>
               </div>

               <div class="d-flex x-gap-20 pt-40 md:pt-30">
                 <div class="d-flex items-center text-accent-1">
                   <i class="icon-guest text-20 mr-10"></i>
                   {{ $room->max_guest }} GUESTS
                 </div>

                 <div class="d-flex items-center text-accent-1">
                   <i class="icon-bed-2 text-20 mr-10"></i>
                   {{ $room->beds }} BEDS
                 </div>

               </div>

               <p class="mt-40 md:mt-30">
                 {{ $room->room_description }}
               </p>

               <a href="{{ route('rooms.show', $room->id) }}" class="button -md -type-2 -outline-accent-1 mt-40 md:mt-30">ROOM DETAIL</a>
             </div>
           </div>
         </div>
       </div>
       @endforeach
    </div>
 </section>

 <section class="layout-pt-lg layout-pb-lg bg-light-1 mt-100">
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

 <section data-anim-wrap class="layout-pt-lg layout-pb-lg">
    <div class="container">
       <div class="row y-gap-30 justify-center text-center">
          <div data-anim-child="slide-up delay-1" class="col-xl-4 col-lg-6">
             <div class="text-15 uppercase mb-30 sm:mb-10">@swiss-resort</div>
             <h2 class="text-64 md:text-40">Follow us on Instagram</h2>
          </div>
       </div>
    </div>
    <div class="imageGrid -type-2">
       <div class="imageGrid__item">
          <div data-anim-child="img-right cover-white delay-2">
             <a href="#" class="ratio ratio-1:1">
             <img src="img/inst/1/1.png" alt="image" class="img-ratio">
             </a>
          </div>
       </div>
       <div class="imageGrid__item">
          <div data-anim-child="img-right cover-white delay-4">
             <a href="#" class="ratio ratio-1:1">
             <img src="img/inst/1/2.png" alt="image" class="img-ratio">
             </a>
          </div>
       </div>
       <div class="imageGrid__item">
          <div data-anim-child="img-right cover-white delay-6">
             <a href="#" class="ratio ratio-1:1">
             <img src="img/inst/1/3.png" alt="image" class="img-ratio">
             </a>
          </div>
       </div>
       <div class="imageGrid__item">
          <div data-anim-child="img-right cover-white delay-8">
             <a href="#" class="ratio ratio-1:1">
             <img src="img/inst/1/4.png" alt="image" class="img-ratio">
             </a>
          </div>
       </div>
       <div class="imageGrid__item">
          <div data-anim-child="img-right cover-white delay-10">
             <a href="#" class="ratio ratio-1:1">
             <img src="img/inst/1/5.png" alt="image" class="img-ratio">
             </a>
          </div>
       </div>
    </div>
 </section>

@endsection
