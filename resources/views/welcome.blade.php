<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">

    <meta name="description"
        content="The Rock Resorts at Aur Island is a beautiful tropical paradise, surrounded by crystal clear waters and pristine white sand beaches. Its beach resort offers an unforgettable experience for those seeking relaxation and adventure.">
    <meta name="keywords"
        content="the rock resorts, rock resort, pulav aur, the rock resorts pulav aur, best resort in malaysia, best resort in mersing, best beach resort, the rock, scuba diving, scuba diving resort, snorkling resort">
    <meta name="author" content="Vynzio.co">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ url('img/general/favicon.png') }}">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&amp;family=Jost:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/vendors.css') }}">
    <link rel="stylesheet" href="{{ url('css/main.css') }}">

    <title>The Rock Resort - Where luxary and nature merge</title>

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
                <a href="/"><img src="img/general/logo-white.svg" alt="logo"></a>
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
                    <a href="/"><img src="img/general/logo-black.svg" alt="image"></a>
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
            <button class="button rounded-200 w-1/1 py-20 -light-1 bg-accent-2">
                BOOK YOUR STAY
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
        <header class="header -mx-60 js-header" data-add-bg="bg-accent-1" data-x="header"
            data-x-toggle="-is-menu-opened" data-anim="fade delay-3">
            <div class="header__container py-60 lg:py-40 md:py-25 items-center">
                <div class="header__left d-flex items-center">
                    <div class="items-center d-none lg:d-flex js-menuFullScreen-toggle">
                        <i class="icon-menu text-9 text-white"></i>
                        <div class="text-15 uppercase text-white ml-30 sm:d-none">Menu</div>
                    </div>

                    <div class="d-flex items-center text-white lg:d-none">
                        <i class="icon-map text-20 mr-10"></i>
                        Johor Pulau Aur, Teluk Baai, Malaysia
                    </div>
                </div>

                <div class="header__center">
                    <div class="header__logo">
                        <a href="/"><img src="img/general/logo-white.svg" class="logo_desktop" alt="logo"></a>
                    </div>
                </div>

                <div class="header__right d-flex items-center h-full">
                    <div class="d-flex items-center mr-20 xl:d-none">
                        <i class="icon-phone text-20 text-white mr-30"></i>
                        <div class="text-15 uppercase text-white">+60 12-6289056</div>
                    </div>

                    <div class="flex-center size-60 rounded-full bg-accent-2 lg:d-none js-menuFullScreen-toggle">
                        <i class="icon-menu text-9"></i>
                    </div>
                </div>
            </div>
        </header>

        {{-- Top Banner Section --}}
        <section data-anim-wrap class="hero -type-5">
            <div class="hero__slider js-section-slider" data-gap="0" data-slider-cols="xl-1 lg-1 md-1 sm-1 base-1"
                data-nav-prev="js-sliderHero-prev" data-nav-next="js-sliderHero-next"
                data-pagination="js-sliderHero-pagination">

                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide">
                            <div class="hero__content">
                                <div data-anim-child="img-right cover-white delay-1" class="hero__bg">
                                    <img src="{{ asset('images/' . $slider->background_picture) }}" alt="image" class="img-ratio">
                                </div>

                                <div data-anim-child="split-lines delay-3" class="container title_up">
                                    <div class="hero__subtitle text-white">
                                        {!! $slider->subtitle !!}
                                    </div>

                                    <h1 class="hero__title text-white">
                                        {!! $slider->title !!}
                                    </h1>
                                    <button onclick="window.location.href='/search_results'" class="custom-search-button">BOOK NOW</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>


        <section class="layout-pt-xlg">
            <div data-anim-wrap class="imageGrid__wrap -type-6">
                <div class="imageGrid -type-6">

                    <div>
                        <div data-anim-child="img-right cover-white delay-2">
                            <img src="img/homepage/second_section/top_view.png" alt="top_view">
                        </div>
                    </div>

                    <div>
                        <div data-anim-child="img-right cover-white delay-4">
                            <img src="img/homepage/second_section/kayak.png" alt="kayak">
                        </div>
                    </div>

                    <div>
                        <div data-anim-child="img-right cover-white delay-6">
                            <img src="img/homepage/second_section/yoga.png" alt="yoga">
                        </div>
                    </div>

                    <div>
                        <div data-anim-child="img-right cover-white delay-8">
                            <img src="img/homepage/second_section/picnic.png" alt="picnic">
                        </div>
                    </div>

                </div>

                <div class="container">
                    <div class="row justify-center text-center">
                        <div class="col-xl-10 col-lg-11">
                            <div data-split='lines' data-anim-child="split-lines delay-2">
                                <h2 class="text-64 md:text-40 home_text">
                                    Explore serene beauty, enjoy island adventures, and revel in our <br
                                        class="lg:d-none">
                                    bespoke care.
                                </h2>
                            </div>

                            <div data-anim-child="slide-up delay-5" class="d-flex justify-center">
                                <button class="button -md -type-2 bg-accent-2 -accent-1 rounded-200 mt-50 md:mt-20" onclick="window.location.href='/search_results'">
                                    DINING WITH US
                                </button>
                            </div>

                            <p data-anim-child="slide-up delay-6" class="text-19 text-sec fw-500 mt-50 md:mt-20">
                                As our valued guests always expect the best, our relentless<br class="md:d-none">
                                pursuit for perfection never ends.
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="layout-pt-lg layout-pb-lg">
            <div data-anim-wrap class="container">
                <div class="row justify-center text-center">
                    <div class="col-xl-10 col-lg-11">
                        <div class="row y-gap-30 justify-between">

                            <div data-split='lines' data-anim-child="split-lines delay-2" class="col-auto">
                                <h3 class="text-92 lg:text-60 md:text-30 lh-11">8k+</h3>
                                <div class="uppercase lh-1 mt-20">Happy Customers</div>
                            </div>

                            <div data-split='lines' data-anim-child="split-lines delay-4" class="col-auto">
                                <h3 class="text-92 lg:text-60 md:text-30 lh-11">26</h3>
                                <div class="uppercase lh-1 mt-20">Luxary ROOMS</div>
                            </div>

                            <div data-split='lines' data-anim-child="split-lines delay-6" class="col-auto">
                                <h3 class="text-92 lg:text-60 md:text-30 lh-11">1</h3>
                                <div class="uppercase lh-1 mt-20">Private Pool</div>
                            </div>

                            <div data-split='lines' data-anim-child="split-lines delay-8" class="col-auto">
                                <h3 class="text-92 lg:text-60 md:text-30 lh-11">2</h3>
                                <div class="uppercase lh-1 mt-20">Resturants</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="layout-pt-lg layout-pb-lg bg-light-1">
            <div data-anim-wrap class="container">
                <div class="hoverTitleInteraction">
                    <div class="row y-gap-30 justify-between items-center">
                        <div class="col-lg-6 offset-lg-1 lg:order-2 lg:pt-50">
                            <div class="d-flex justify-end">
                                <div class="hoverTitleInteraction__images d-flex justify-end">
                                    @foreach ($rooms->take(4) as $room)
                                        <div class="{{ $loop->first ? 'is-active' : '' }}">
                                            <div class="imageGrid -type-1">
                                                <div>
                                                    <div data-anim-child="img-right cover-light-1 delay-1">
                                                        <img src="{{ asset('storage/' . $room->room_img) }}"
                                                            alt="image" class="">
                                                    </div>
                                                </div>
                                                @if (is_array($room->room_gallery) && count($room->room_gallery) > 0)
                                                    <div>
                                                        <div data-anim-child="img-right cover-light-1 delay-3">
                                                            <img src="{{ asset('storage/' . $room->room_gallery[0]) }}"
                                                                alt="image" class="">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 lg:order-1">
                            <div data-anim-child="slide-up delay-5" class="row y-gap-60 hoverTitleInteraction__links">
                                @foreach ($rooms->take(4) as $room)
                                    <div class="col-12">
                                        <a href="{{ route('rooms.show', $room->id) }}"
                                            class="hoverTitle flex-column items-start">
                                            <div class="d-flex items-center text-sec text-40 md:text-40 fw-500">
                                                {{ $room->room_type }}
                                                <i class="icon-arrow-right text-40 ml-50"></i>
                                            </div>
                                            <div class="row y-gap-10 pt-10">
                                                <div class="col-auto">
                                                    <div class="d-flex items-center text-accent-1">
                                                        <div>{{ $room->max_guest }} GUEST</div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="d-flex items-center">
                                                        {{ Str::limit($room->room_description, 50, '...') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <a href="{{ route('all_rooms') }}">View More Rooms</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="layout-pb-lg">
            <div class="container">

                <div data-anim-wrap class="row y-gap-30 items-center pt-100 sm:pt-50">
                    <div class="col-md-6">
                        <div class="ratio ratio-1:1" data-anim-child="img-right cover-white delay-2">
                            <img src="img/homepage/restaurant_section/1.png" alt="sea shell savoury" class="img-ratio">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-5 offset-md-1">
                        <i data-anim-child="slide-up delay-5" class="d-block icon-restaurant text-30 mb-30"></i>
                        <h3 data-anim-child="slide-up delay-6" class="text-40 md:text-30 lh-065">Sea Shell Savory</h3>
                        <p data-anim-child="slide-up delay-7" class="text-17 lh-17 mt-30">
                            Savor the symphony of flavors at The Rock Resorts, where each dish is a masterpiece and
                            every sip whispers of the tropics.
                            From sunrise meals to twilight cocktails, your culinary journey is accompanied by the
                            soothing murmur of the sea.
                            Delight in our local and international cuisine, crafted with a passion for sustainability
                            and a touch of island charm.
                            Join us for an intimate dining experience where the horizon meets indulgence.
                        </p>


                        <div data-anim-child="slide-up delay-8">
                            <div class="text-17 fw-500 mt-50 md:mt-30">Open Daily: 11:00 am - 09:00pm</div>
                        </div>


                        <div data-anim-child="slide-up delay-8">
                            <a href="{{ route('search_results') }}"
                                class="button -md -type-2 bg-accent-2 -accent-1 rounded-200 mt-50 md:mt-30">Join Us for
                                a Meal</a>
                        </div>

                    </div>
                </div>

                <div data-anim-wrap class="row y-gap-30 items-center pt-100 sm:pt-50">
                    <div class="col-md-6">
                        <div class="ratio ratio-1:1" data-anim-child="img-right cover-white delay-2">
                            <img src="/img/homepage/spa/spa.png" alt="spa" class="img-ratio">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-5 offset-md-1">
                        <i data-anim-child="slide-up delay-5" class="d-block icon-rocks text-30 mb-30"></i>
                        <h3 data-anim-child="slide-up delay-6" class="text-40 md:text-30 lh-065">Harbor of Harmony Spa
                        </h3>
                        <p data-anim-child="slide-up delay-7" class="text-17 lh-17 mt-30">
                            Escape to the Harbor of Harmony Spa, where tranquility meets rejuvenation.
                            Allow our skilled therapists to guide you through a bespoke selection of soothing massages
                            and wellness services,
                            designed to revitalize your spirit amidst the island's natural splendor.
                            Pause, indulge, and emerge renewed every day between 11:00 am and 9:00 pm
                        </p>


                        <div data-anim-child="slide-up delay-8">
                            <a href="{{ route('search_results') }}"
                                class="button -md -type-2 -outline-accent-2 rounded-200 mt-50 md:mt-30">Unwind With
                                Us</a>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        {{-- Activity Section --}}
        <section>
            <div class="row x-gap-0">
                @foreach ($activities as $index => $activity)
                    <div data-anim-wrap class="col-lg-3 col-sm-6">
                        <div class="cardImage -type-1">
                            <div data-anim-child="img-right cover-white delay-{{ ($index + 1) * 2 }}"
                                class="cardImage__image">
                                <img src="{{ asset('storage/' . $activity->image) }}" alt="image">
                            </div>

                            <div class="cardImage__content text-center">
                                <div class="cardImage__subtitle text-white mb-30 md:mb-20">{{ $activity->sub_title }}
                                </div>
                                <h3 class="cardImage__title text-52 lg:text-40 text-white">{{ $activity->title }}</h3>

                                <p class="cardImage__text text-white mt-40 md:mt-20">
                                    {{ $activity->description }}
                                </p>

                                <div class="cardImage__button">
                                    <a href="{{ route('search_results') }}"
                                        class="button -md -type-2 col-12 -outline-white text-white rounded-200 mt-50 md:mt-30">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- POOL SECTION --}}
        <section class="relative layout-pt-lg layout-pb-lg xl:pb-50 xl:pt-50 sm:pb-40 sm:pt-0 xl:mt-50">
            <div class="sectionBg col-12">
                <div class="container h-full">
                    <div class="h-full bg-light-1"></div>
                </div>
            </div>

            <div data-anim-wrap class="container">
                <div class="sideImages -type-2">
                    <div class="sideImages__item">
                        <div data-anim-child="fade delay-3" class="d-flex items-center mb-30 md:mb-10">
                            <i class="icon-fish text-30 mr-20"></i>
                            <div class="text-sec text-30 md:text-21 fw-500">Best Sea Food</div>
                        </div>
                        <div data-anim-child="img-right cover-white delay-1">
                            <img src="/img/homepage/pool_section/pool_bar.png" alt="pool_bar">
                        </div>
                    </div>

                    <div class="sideImages__item">
                        <div data-anim-child="img-right cover-white delay-1">
                            <img src="/img/homepage/pool_section/pool.png" alt="pool_bar">
                        </div>
                        <div data-anim-child="fade delay-3" class="d-flex items-center mt-30 md:mt-10">
                            <i class="icon-bar text-30 mr-20"></i>
                            <div class="text-sec text-30 md:text-21 fw-500">Pool Bar</div>
                        </div>
                    </div>
                </div>

                <div class="row justify-center text-center">
                    <div class="col-xl-6">
                        <div class="sm:px-20">
                            <div data-split='lines' data-anim-child="split-lines delay-3">
                                <div class="text-15 uppercase mb-30 sm:mb-10">
                                    The Rock Resort
                                </div>
                                <h2 class="text-64 lg:text-52 md:text-30 capitalize">
                                    Culinary Elegance, Scenic Dining<br class="lg:d-none">
                                </h2>
                                <p class="text-17 lh-18 mt-50 md:mt-20">
                                    We merge gourmet dining with awe-inspiring views. Relish in the freshness of seaside
                                    fare, perfected by our chefs'
                                    touch in a venue that frames the ocean's vast beauty. <br class="md:d-none">
                                    Connect with the essence of coastal living while savoring flavors that only true
                                    proximity to the sea can offer.
                                </p>
                            </div>

                            <div data-anim-child="slide-up delay-4">
                                <button onclick="window.location.href='{{ route('search_results') }}'"
                                    class="button -md -type-2 bg-accent-2 -accent-1 rounded-200 mt-50 md:mt-30 mx-auto">
                                    Taste the View
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Testimonial Section --}}
        <section data-anim-wrap class="layout-pt-lg">
            <div class="container">
                <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
                    <div class="col-auto">
                        <div class="mb-40">
                            <svg width="45" height="44" viewBox="0 0 45 44" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d_428_953)">
                                    <path
                                        d="M9.67883 38C6.64234 38 4.27007 36.9524 2.56204 34.8571C0.854015 32.6667 0 29.4286 0 25.1429C0 20.6667 0.99635 16.381 2.98905 12.2857C5.07664 8.19048 8.01825 4.14286 11.8139 0.142864C11.9088 0.0476213 12.0511 0 12.2409 0C12.5255 0 12.7153 0.142858 12.8102 0.428574C13 0.619048 13.0474 0.857143 12.9526 1.14286C10.6752 4.19048 9.10949 7.14286 8.25548 10C7.49635 12.7619 7.11679 15.8571 7.11679 19.2857C7.11679 21.8571 7.44891 23.8571 8.11314 25.2857C8.77737 26.7143 9.67883 28 10.8175 29.1429L5.40876 30.1429C5.31387 28.5238 5.74088 27.2857 6.68978 26.4286C7.73358 25.5714 9.06205 25.1429 10.6752 25.1429C12.6679 25.1429 14.1861 25.7143 15.2299 26.8571C16.3686 28 16.938 29.5714 16.938 31.5714C16.938 33.6667 16.2737 35.2857 14.9453 36.4286C13.7117 37.4762 11.9562 38 9.67883 38ZM31.5985 38C28.562 38 26.1898 36.9524 24.4818 34.8571C22.8686 32.6667 22.062 29.4286 22.062 25.1429C22.062 20.5714 23.0584 16.2381 25.0511 12.1429C27.0438 8.04762 29.9854 4.04762 33.8759 0.142864C33.9708 0.0476213 34.1131 0 34.3029 0C34.5876 0 34.7774 0.142858 34.8723 0.428574C35.062 0.619048 35.1095 0.857143 35.0146 1.14286C32.7372 4.19048 31.1715 7.14286 30.3175 10C29.5584 12.7619 29.1788 15.8571 29.1788 19.2857C29.1788 21.8571 29.4635 23.9048 30.0328 25.4286C30.6971 26.8571 31.5985 28.0952 32.7372 29.1429L27.4708 30.1429C27.3759 28.5238 27.8029 27.2857 28.7518 26.4286C29.7007 25.5714 31.0292 25.1429 32.7372 25.1429C34.7299 25.1429 36.2482 25.7143 37.292 26.8571C38.4307 28 39 29.5714 39 31.5714C39 33.6667 38.3358 35.2857 37.0073 36.4286C35.7737 37.4762 33.9708 38 31.5985 38Z"
                                        fill="#122223" />
                                </g>
                                <defs>
                                    <filter id="filter0_d_428_953" x="0" y="0" width="45" height="44"
                                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feColorMatrix in="SourceAlpha" type="matrix"
                                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                        <feOffset dx="6" dy="6" />
                                        <feComposite in2="hardAlpha" operator="out" />
                                        <feColorMatrix type="matrix"
                                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
                                        <feBlend mode="normal" in2="BackgroundImageFix"
                                            result="effect1_dropShadow_428_953" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_428_953"
                                            result="shape" />
                                        </feBlend>
                                </defs>
                            </svg>
                        </div>

                        <div class="text-15 uppercase mb-30 sm:mb-15">VOICE FROM OUR GUESTS</div>
                        <h2 class="text-64 md:text-40 lh-065">Testimonials</h2>
                    </div>
                </div>
            </div>

            <div class="relative container">
                <div class="row justify-center pt-100 sm:pt-50">
                    <div class="col-xl-8 col-lg-10 col-9">
                        <div class="overflow-hidden js-testimonialsSlider-1">
                            <div class="swiper-wrapper">
                                @foreach ($reviews as $review)
                                    <div class="swiper-slide">
                                        <div data-split='lines' data-anim-child="split-lines delay-2"
                                            class="text-center">
                                            <div class="text-sec text-40 md:text-24">
                                                {{ $review['review'] }}
                                            </div>
                                            <div class="mt-50">{{ $review['person_name'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="navAbsolute">
                                <button class="size-80 flex-center rounded-full js-testimonialsSlider-1-prev">
                                    <i class="icon-arrow-left text-24"></i>
                                </button>

                                <button class="size-80 flex-center rounded-full js-testimonialsSlider-1-next">
                                    <i class="icon-arrow-right text-24"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-anim-child="slide-up delay-5"
                    class="testimonialsPagination -type-1 pt-100 js-testimonialsSlider-1-pagination">
                    @foreach ($reviews as $review)
                        <div class="testimonialsPagination__item {{ $loop->first ? 'is-active' : '' }}">
                            <div><img src="{{ asset('storage/' . $review['person_image']) }}" alt="person"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <section data-anim-wrap class="layout-pt-lg">
            <div class="row justify-center text-center">
                <div data-anim-child="slide-up delay-1" class="col-auto">
                    <div class="text-15 uppercase mb-30 sm:mb-10"><a style="color: #0d6efd;" target="_blank"
                            href="https://www.instagram.com/therockresorts.pulauaur/">@therockresorts.pulauaur</a>
                    </div>
                    <h2 class="text-64 md:text-40">Follow us on Instagram</h2>
                </div>
            </div>

            <!-- Instagram Section -->
            <div class="row x-gap-0 pt-100 sm:pt-50">
                @foreach ($instagramImages as $index => $image)
                    <div class="col">
                        <a href="#" class="ratio ratio-1:1"
                            data-anim-child="img-right cover-white delay-{{ ($index + 1) * 2 }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="image"
                                class="img-ratio">
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        <footer class="footer -type-1 -bottom-border-dark">
            <div class="footer__main">
                <div class="container">
                    <div class="footer__grid">
                        <div class="">
                            <h4 class="text-30 fw-500 ">About Us</h4>
                            <div class=" text-15 lh-17 mt-60 md:mt-20">
                                Discover The Rock Resort on Aur Island,
                                where luxury harmonizes with the untouched
                                splendor of nature's masterpiece.
                            </div>
                        </div>

                        <div class="">
                            <h4 class="text-30 fw-500 ">Contact</h4>

                            <div class="d-flex flex-column mt-60 md:mt-20">
                                <div class="">
                                    <a class="d-block text-15  lh-17" href="#">
                                        The Rock Resorts, MY Johor Pulau Aur, Teluk Baai, Aur Island, 86800
                                    </a>
                                </div>
                                <div class="mt-10">
                                    <a class="d-block text-15 " href="#">
                                        enquiry@therockresorts.com
                                    </a>
                                </div>
                                <div class="mt-10">
                                    <a class="d-block text-15 " href="#">
                                        +60 12-6289056
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <h4 class="text-30 fw-500 ">Links</h4>

                            <div class="row x-gap-50 y-gap-15">
                                <div class="col-sm-6">
                                    <div class="y-gap-15 text-15  mt-60 md:mt-20">

                                        <a class="d-block" href="#">
                                            About Rock Resort
                                        </a>

                                        <a class="d-block" href="#">
                                            Our Rooms
                                        </a>

                                        <a class="d-block" href="#">
                                            Restaurant &amp; Bar
                                        </a>

                                        <a class="d-block" href="#">
                                            Spa &amp; Wellness
                                        </a>

                                        <a class="d-block" href="#">
                                            Contact
                                        </a>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="y-gap-15 text-15  mt-60 md:mt-20">

                                        <a class="d-block" href="#">
                                            Privacy Policy
                                        </a>

                                        <a class="d-block" href="#">
                                            Terms &amp; Conditions
                                        </a>

                                        <a class="d-block" href="#">
                                            Get Directions
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <h4 class="text-30 fw-500 ">Newsletter Sign Up</h4>

                            <p class="text-15  mt-60 md:mt-20">Sign up for our news, deals and special offers.</p>

                            <div class="footer__newsletter mt-30">
                                <input type="Email" placeholder="Your email address" class="border-1">
                                <button><i class="icon-arrow-right  text-20"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer__bottom">
                <div class="container">
                    <div class="row y-gap-30 justify-between md:justify-center items-center">
                        <div class="col-sm-auto">
                            <div class="text-15 text-center">Copyright © 2024 The Rock Resort | All rights reserved |
                                Made with ♥ <a target="_blank" href="https://Vynzio.co">Vynzio.co</a></div>
                        </div>

                        <div class="col-sm-auto">
                            <div class="footer__bottom_center">
                                <div class="d-flex justify-center">
                                    <img src="img/general/logo-black.svg" class="" alt="logo">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-auto">
                            <div class="row x-gap-25 y-gap-10 items-center justify-center">

                                <div class="col-auto">
                                    <a href="#" class="d-block">
                                        <i class="icon-facebook text-13"></i>
                                    </a>
                                </div>

                                <div class="col-auto">
                                    <a href="#" class="d-block">
                                        <i class="icon-twitter text-13"></i>
                                    </a>
                                </div>

                                <div class="col-auto">
                                    <a href="#" class="d-block">
                                        <i class="icon-instagram text-13"></i>
                                    </a>
                                </div>

                                <div class="col-auto">
                                    <a href="#" class="d-block">
                                        <i class="icon-linkedin text-13"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>


    </main>

    <!-- JavaScript -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAz77U5XQuEME6TpftaMdX0bBelQxXRlM" defer></script>
    <script src="{{ url('js/dist/markerclusterer.min.js') }}" defer></script>
    <script src="{{ url('js/vendors.js') }}" defer></script>
    <script src="{{ url('js/main.js') }}" defer></script>

</body>

</html>
