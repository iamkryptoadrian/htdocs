@extends('layouts.main')
@php
    $pageTitle = "Resturant";
@endphp
@section('main-container')

<section data-anim-wrap class="pageHero -type-2 -items-center">
    <div data-anim-child="img-right cover-white delay-1" class="pageHero__bg">
      <img src="img/pageHero/6.png" alt="image">
    </div>

    <div class="container">
      <div class="row justify-center">
        <div class="col-12">
          <div class="pageHero__content text-center">
            <div data-split='lines' data-anim-child="split-lines delay-3">
              <div class="pageHero__subtitle text-white uppercase mb-20">
                RESTAURANT
              </div>
              <h1 class="pageHero__title lh-11 capitalize text-white">
                Zuma Restaurant
              </h1>
            </div>

            <div data-anim-child="slide-up delay-8" class="row y-gap-40 x-gap-60 md:x-gap-20 justify-between md:justify-center pt-50 md:pt-30">

              <div class="col-lg-auto col-6">
                <div class="text-center text-white">
                  <i class="d-flex justify-center text-40 icon-phone mb-20"></i>
                  <div class="fw-500">+41-96567-7854</div>
                </div>
              </div>

              <div class="col-lg-auto col-6">
                <div class="text-center text-white">
                  <i class="d-flex justify-center text-40 icon-email-2 mb-20"></i>
                  <div class="fw-500">restaurant@swiss-resort.com</div>
                </div>
              </div>

              <div class="col-lg-auto col-6">
                <div class="text-center text-white">
                  <i class="d-flex justify-center text-40 icon-phone mb-20"></i>
                  <div class="fw-500">Monday - Sunday</div>
                </div>
              </div>

              <div class="col-lg-auto col-6">
                <div class="text-center text-white">
                  <i class="d-flex justify-center text-40 icon-phone mb-20"></i>
                  <div class="fw-500">06:00 am - 22:30 pm</div>
                </div>
              </div>

              <div class="col-lg-auto col-6">
                <div class="text-center text-white">
                  <i class="d-flex justify-center text-40 icon-phone mb-20"></i>
                  <div class="fw-500">$50 - $450</div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
</section>

  <section class="layout-pt-lg">
    <div class="container">
      <div class="row justify-center">
        <div data-split='lines' data-anim="split-lines delay-3" class="col-xl-8 col-lg-10">
          <h2 class="text-40 md:text-30">An integral part of relax and perfect experience of your stay is exceptional gastronomy. Chefs’ team under my leadership prepares daily delicious meals from domestic and international cuisine with love for you.</h2>

          <p class="lh-17 mt-40">
            Quality of the food in our hotel starts with buying of quality ingredients and therefore is our cuisine focused on regional producers, growers and farmers.
            <br><br>
            Do not expect to be served in 10 minutes, because I lay emphasis particular on preparation, strict adherence to recipes and preservation of traditional practices that have already disappeared from the restaurant. For busy guests we offer daily menu, dinner is served in a rich buffet style. I am looking forward to welcoming you in our hotel restaurant and in Original Restaurant & Wine Bar. ”
          </p>
        </div>
      </div>
    </div>
  </section>

  <div class="layout-pt-lg px-60 sm:px-0">
    <div data-anim-wrap class="relative">
      <div class="overflow-hidden js-section-slider" data-gap="15" data-slider-cols="xl-4 lg-3 md-2 sm-1 base-1" data-loop data-nav-prev="js-slider1-prev" data-nav-next="js-slider1-next">
        <div class="swiper-wrapper">

          <div class="swiper-slide">
            <div class="ratio ratio-44:60" data-anim-child="img-right cover-white delay-2">
              <img src="img/restSingle/1/1.png" alt="image" class="img-ratio">
            </div>
          </div>

          <div class="swiper-slide">
            <div class="ratio ratio-44:60" data-anim-child="img-right cover-white delay-4">
              <img src="img/restSingle/1/2.png" alt="image" class="img-ratio">
            </div>
          </div>

          <div class="swiper-slide">
            <div class="ratio ratio-44:60" data-anim-child="img-right cover-white delay-6">
              <img src="img/restSingle/1/3.png" alt="image" class="img-ratio">
            </div>
          </div>

          <div class="swiper-slide">
            <div class="ratio ratio-44:60" data-anim-child="img-right cover-white delay-8">
              <img src="img/restSingle/1/4.png" alt="image" class="img-ratio">
            </div>
          </div>

        </div>
      </div>

      <div class="navAbsolute -type-3">
        <button class="size-80 flex-center bg-accent-1-50 blur-1 rounded-full js-slider1-prev">
          <i class="icon-arrow-left text-24 text-white"></i>
        </button>

        <button class="size-80 flex-center bg-accent-1-50 blur-1 rounded-full js-slider1-next">
          <i class="icon-arrow-right text-24 text-white"></i>
        </button>
      </div>
    </div>
  </div>

  <section class="layout-pt-lg layout-pb-lg">
    <div data-anim-wrap class="container">
      <div class="row justify-center text-center">
        <div class="col-auto">
          <div class="text-15 uppercase mb-30 sm:mb-10">OUR MENU</div>
          <h2 class="text-64 md:text-40">Menu Highlights</h2>
        </div>
      </div>

      <div class="tabs -type-1 mt-100 sm:mt-50 js-tabs">
        <div data-anim-child="slide-up delay-4" class="tabs__controls row y-gap-20 items-center justify-center js-tabs-controls">


          <div class="col-auto">
            <button class="tabs__button text-sec text-24 fw-500 js-tabs-button is-tab-el-active" data-tab-target=".-tab-item-1">Dinner</button>
          </div>


          <div class="col-auto">
            <div class="-circle-2 bg-accent-2"></div>
          </div>


          <div class="col-auto">
            <button class="tabs__button text-sec text-24 fw-500 js-tabs-button " data-tab-target=".-tab-item-2">Drinks</button>
          </div>


          <div class="col-auto">
            <div class="-circle-2 bg-accent-2"></div>
          </div>


          <div class="col-auto">
            <button class="tabs__button text-sec text-24 fw-500 js-tabs-button " data-tab-target=".-tab-item-3">Dishes</button>
          </div>

        </div>

        <div data-anim-child="slide-up delay-4" class="tabs__content mt-100 sm:mt-50 js-tabs-content">

          <div class="tabs__pane -tab-item-1 is-tab-el-active">
            <div class="row y-gap-40 x-gap-100 justify-between">

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/1.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Lemon thyme chicken</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/2.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Pistachio crusted lamb</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/3.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">French Croissant</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/4.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Chia Oatmeal</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/5.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Avocado Toast</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/6.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Marmalade Selection</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/7.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Garlic shrimp scampi</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/8.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Fruit Parfait</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="tabs__pane -tab-item-2 ">
            <div class="row y-gap-40 x-gap-100 justify-between">

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/1.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Lemon thyme chicken</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/2.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Pistachio crusted lamb</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/3.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">French Croissant</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/4.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Chia Oatmeal</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/5.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Avocado Toast</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/6.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Marmalade Selection</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/7.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Garlic shrimp scampi</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/8.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Fruit Parfait</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="tabs__pane -tab-item-3 ">
            <div class="row y-gap-40 x-gap-100 justify-between">

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/1.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Lemon thyme chicken</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/2.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Pistachio crusted lamb</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/3.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">French Croissant</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/4.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Chia Oatmeal</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/5.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Avocado Toast</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/6.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Marmalade Selection</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/7.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Garlic shrimp scampi</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row y-gap-20 x-gap-20 items-center">
                  <div class="col-auto">
                    <img src="img/restSingle/2/8.png" alt="image">
                  </div>

                  <div class="col-sm">
                    <div class="row justify-between items-center">
                      <div class="col-auto">
                        <h4 class="text-30">Fruit Parfait</h4>
                      </div>

                      <div class="col">
                        <div class="line -horizontal bg-border"></div>
                      </div>

                      <div class="col-auto">
                        <div class="fw-500">$40</div>
                      </div>
                    </div>

                    <div class="mt-10">
                      Honey Vinaigrette / House Cheese Crouton / Fine Herbs
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

@endsection
