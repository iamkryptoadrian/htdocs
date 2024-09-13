@php
$user = auth()->user();
@endphp
<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">
   <head>
      <!-- Required meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Google fonts -->
      <link rel="shortcut icon" href="{{url('img/general/favicon.png')}}">
      <link rel="preconnect" href="https://fonts.googleapis.com/">
      <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&amp;family=Jost:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Stylesheets -->
      <link rel="stylesheet" href="{{url('/css/main.css')}}" />
      <link rel="stylesheet" href="{{url('/css/vendors.css')}}" />
      <title>{{ $pageTitle }}</title>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   </head>
   <body>
      <div class="menuFullScreen js-menuFullScreen">
         <div class="menuFullScreen__topMobile js-menuFullScreen-topMobile">
            <div class="d-flex items-center text-white js-menuFullScreen-toggle">
               <i class="icon-menu text-9"></i>
               <div class="text-15 uppercase ml-30 sm:d-none">Menu</div>
            </div>
            <div class="">
               <a href="/"><img src="{{ asset('img/general/logo-white.svg') }}" alt="logo"></a>
            </div>
         </div>
         <div class="menuFullScreen__mobile__bg js-menuFullScreen-mobile-bg"></div>
         <div class="menuFullScreen__left">
            <div class="menuFullScreen__bg js-menuFullScreen-bg">
              <img src="img/menu/bg.png" alt="image">
            </div>

            <button class="menuFullScreen__close js-menuFullScreen-toggle js-menuFullScreen-close-btn">
              <span class="icon">
                <span></span>
                <span></span>
              </span>
              CLOSE
            </button>

            <div class="menuFullScreen-links js-menuFullScreen-links">

              <div class="menuFullScreen-links__item js-menuFullScreen-has-children">
                <a href="/">
                  Home
                </a>
              </div>

              <div class="menuFullScreen-links__item js-menuFullScreen-has-children">
                <a href="/rooms">
                  Rooms
                </a>
              </div>

              <div class="menuFullScreen-links__item js-menuFullScreen-has-children">
                <a href="/search_results">
                  All Packages
                </a>
              </div>

              <div class="menuFullScreen-links__item js-menuFullScreen-has-children">
                <a href="/restaurant">
                    Restaurant
                </a>
              </div>

              <div class="menuFullScreen-links__item js-menuFullScreen-has-children">
                <a href="/login">
                  My Account
                </a>
              </div>

              <div class="menuFullScreen-links__item">
                <a href="#">
                  Contact
                </a>
              </div>
            </div>
          </div>
         <div class="menuFullScreen__right js-menuFullScreen-right">
            <div class="text-center">
               <div class="mb-100">
                <a href="/"><img src="{{ asset('img/general/logo-black.svg') }}" alt="image"></a>
               </div>
               <div class="text-sec lh-11 fw-500 text-40">
                  The Rock Resorts<br>
                  Where luxary and nature merge
               </div>
               <div class="mt-40">
                  <div class="text-30 text-sec fw-500">
                     Location
                  </div>
                  <div class="mt-10">
                     Johor Pulau Aur, Teluk Baai<br>
                     Malaysia
                  </div>
               </div>
               <div class="mt-40">
                  <div class="text-30 text-sec fw-500">
                     Phone Support
                  </div>
                  <div class="mt-10">
                     <div>
                        <a href="#"> +60 12-6289056</a>
                     </div>
                     <div>
                        <a href="#">enquiry@therockresorts.com</a>
                     </div>
                  </div>
               </div>
               <div class="mt-40">
                  <div class="text-30 text-sec fw-500">
                     Connect With Us
                  </div>
                  <div class="mt-10">
                     <a href="#"> +60 12-6289056</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="menuFullScreen__bottomMobile js-menuFullScreen-buttomMobile">
            <button onclick="window.location.href='/login/'" class="button rounded-200 w-1/1 py-20 -light-1 bg-accent-2">
                MY ACCOUNT
            </button>
            <a href="#" class="d-flex items-center mt-40">
            <i class="icon-phone mr-10"></i>
            <span>+60 12-6289056</span>
            </a>
            <a href="#" class="d-flex mt-20">
            <i class="icon-map mr-10"></i>
            <span>
            Johor Pulau Aur, Teluk Baai,
            Malaysia
            </span>
            </a>
            <a href="#" class="d-flex items-center mt-20">
            <i class="icon-mail mr-10"></i>
            <span>enquiry@therockresorts.com</span>
            </a>
         </div>
      </div>
      <!-- cursor start -->
      <div class="cursor js-cursor">
         <div class="cursor__wrapper">
            <div class="cursor__follower js-follower"></div>
            <div class="cursor__label js-label"></div>
            <div class="cursor__icon js-icon"></div>
         </div>
      </div>
      <!-- cursor end -->
      <main>
      <header class="header -h-110 -mx-60 -blur -border-bottom-1 js-header" data-add-bg="bg-accent-1" data-x="header" data-x-toggle="-is-menu-opened">
         <div class="header__container h-full items-center">
            <div class="header__left d-flex items-center">
               <button class="d-flex items-center cursor-pointer js-menuFullScreen-toggle">
                  <i class="icon-menu text-9 text-white"></i>
                  <div class="text-15 uppercase text-white ml-30 sm:d-none">Menu</div>
               </button>
               <div class="d-flex items-center ml-90 xl:d-none">
                  <i class="icon-phone text-20 text-white mr-30"></i>
                  <div class="text-15 uppercase text-white">+60 12-6289056</div>
               </div>
            </div>
            <div class="header__center">
               <div class="header__logo">
                <a href="/"><img src="{{ asset('img/general/logo-white.svg') }}" class="logo_desktop" alt="logo"></a>
               </div>
            </div>
            <div class="header__right d-flex items-center h-full">
               <div class="line -vertical bg-white-10 h-full ml-90 mr-90 xl:d-none"></div>
               <button onclick="window.location.href='/search_results'" class="button text-white mr-30 xl:d-none">BOOK YOUR STAY</button>
            </div>
         </div>
      </header>
      <!--notfication slider-->
      <div id="success-notification" class="notification-alert success-alert">
        <span id="success-message"></span>
      </div>
      <div id="error-notification" class="notification-alert error-alert">
        <span id="error-message"></span>
      </div>

