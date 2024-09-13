@extends('layouts.main')
@php
    $pageTitle = "Search Result";
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
                <h1 class="pageHero__title text-white">All Packages</h1>
                <p class="pageHero__text text-white">Indulge in luxury in our rooms and suites, featuring stunning views, elegant furnishings, and modern amenities.</p>
             </div>
          </div>
       </div>
    </div>
 </section>
 <section class="mt-50">
    <div data-anim-wrap class="container">
       <div class="row">
          <div class="col-auto">
             <h2 class="text-64 md:text-40 lh-11">
                Choose Your Package
             </h2>
          </div>
       </div>
       <div class="row x-gap-30 y-gap-60">
          @foreach($packages as $package)
          <div class="col-lg-4 col-md-6">
            <a href="{{ url('package_details', $package->id) }}?{{ request()->getQueryString() }}" data-anim-child="slide-up delay-2" class="roomCard -type-2 -hover-button-center d-block bg-accent-1 rounded-16 overflow-hidden">
                  <div class="roomCard__image -no-line ratio ratio-45:43 -hover-button-center__wrap">
                      @if($package->main_image)
                          <img src="{{ asset('storage/'.$package->main_image) }}" alt="image" class="img-ratio">
                      @else
                          <img src="{{ asset('img/default-package.jpg') }}" alt="image" class="img-ratio">
                      @endif
                      <div style="font-size: 12px" class="roomCard__price fw-500 bg-white text-accent-1 rounded-8">STARTING WITH - RM {{ (float)$package->package_initial_price }} / PAX</div>
                      <div class="-hover-button-center__button flex-center size-130 rounded-full bg-accent-1-50 blur-1 border-white-10">
                          <span class="text-15 fw-500 text-white">BOOK NOW</span>
                      </div>
                  </div>
                  <div class="roomCard__content text-center px-30 py-30">
                    <h3 class="roomCard__title lh-065 text-40 md:text-24 text-white">{{ Str::title($package->package_name) }}</h3>
                        <p class="text-white mt-30">
                            {{ $package->short_description }}
                        </p>
                  </div>
              </a>
          </div>
          @endforeach

       </div>
    </div>
 </section>

 <section class="layout-pt-md layout-pb-md bg-light-1 mt-100">
    <div data-anim-wrap class="container">
       <div class="row justify-center text-center">
          <div data-split='lines' data-anim-child="split-lines delay-2" class="col-auto">
             <div class="text-15 uppercase mb-30 sm:mb-10">OUR SERVICES</div>
             <h2 class="text-64 md:text-40">Resort Facilities</h2>
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
                   <i class="icon-boat"></i>
                </div>
                <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Boat Transfer</h4>
             </div>
          </div>
          <div data-anim-child="slide-up delay-6" class="col-lg-auto col-md-4 col-6">
             <div class="iconCard -type-1 -hover-1 text-center">
                <div class="iconCard__icon text-50">
                   <div class="iconCard__icon__circle bg-white"></div>
                   <img src="{{ asset('/icons/karaoke.png') }}" style="width: 52px">
                </div>
                <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Karaoke Lounge</h4>
             </div>
          </div>
          <div data-anim-child="slide-up delay-7" class="col-lg-auto col-md-4 col-6">
             <div class="iconCard -type-1 -hover-1 text-center">
                <div class="iconCard__icon text-50">
                   <div class="iconCard__icon__circle bg-white"></div>
                   <img src="{{ asset('/icons/fasting-meal.png') }}" style="width: 52px">
                </div>
                <h4 class="text-24 sm:text-21 lh-1 mt-30 sm:mt-15">Breakfast on Hill</h4>
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

 <section data-anim-wrap class="layout-pt-md layout-pb-md">
    <div class="container">
        <div class="row y-gap-30 justify-center text-center">
            <div data-anim-child="slide-up delay-1" class="col-xl-4 col-lg-6">
                <div class="text-15 uppercase mb-30 sm:mb-10">
                    <a style="color: #0d6efd;" target="_blank" href="https://www.instagram.com/therockresorts.pulauaur/">
                        @therockresorts.pulauaur
                    </a>
                </div>
                <h2 class="text-64 md:text-40">Follow us on Instagram</h2>
            </div>
        </div>
    </div>

    <!-- Instagram Section -->
    <div class="imageGrid -type-2">
        @foreach ($instagramImages->take(5) as $index => $image)
        <div class="imageGrid__item">
            <div data-anim-child="img-right cover-white delay-{{ ($index + 1) * 2 }}">
                <a href="#" class="ratio ratio-1:1">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="image" class="img-ratio">
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>




@endsection
