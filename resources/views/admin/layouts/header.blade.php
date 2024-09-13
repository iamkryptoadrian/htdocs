<!DOCTYPE html>
<html lang="en" class="js">
   <head>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <meta name="author" content="Softnio">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="The Rock Resorts &#8211; Where luxary and nature merge">
      <link rel="shortcut icon" href="{{url('admin/images/favicon.png')}}">
      <title>{{ $pageTitle }}</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" href="{{url('admin/assets/css/dashlite.css')}}">
      <link id="skin-default" rel="stylesheet" href="{{url('admin/assets/css/theme.css')}}">
   </head>
   <body class="nk-body bg-lighter npc-general has-sidebar " >
      <div class="nk-app-root">
      <div class="nk-main ">
      <div class="nk-sidebar nk-sidebar-fixed is-dark" data-content="sidebarMenu">
         <div class="nk-sidebar-element nk-sidebar-head">
            <div class="nk-menu-trigger"><a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
               <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-sidebar-brand">
               <a href="/admin/dashboard/" class="logo-link nk-sidebar-logo">
               <img class="logo-light logo-img" src="{{url('admin/images/logo-white.svg')}}" alt="logo">
               <img class="logo-dark logo-img" src="{{url('admin/images/logo-white.svg')}}"alt="logo-dark">
               </a>
            </div>
         </div>
         <div class="nk-sidebar-element nk-sidebar-body">
            <div class="nk-sidebar-content">
               <div class="nk-sidebar-menu" data-simplebar>
                  <ul class="nk-menu">
                     <li class="nk-menu-item"><a href="{{route('admin.dashboard')}}" class="nk-menu-link"><span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span><span class="nk-menu-text">Dashboard</span></a></li>
                     <li class="nk-menu-item has-sub {{ Route::currentRouteName() == 'admin.packages.index' || Route::currentRouteName() == 'admin.bookings.view' ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-calendar-booking-fill"></em></span><span class="nk-menu-text">Bookings</span></a>
                        <ul class="nk-menu-sub">
                           <li class="nk-menu-item"><a href="{{route('admin.bookings.index')}}" class="nk-menu-link"><span class="nk-menu-text">All Bookings</span></a></li>
                        </ul>
                     </li>
                     <li class="nk-menu-item has-sub {{ Route::currentRouteName() == 'admin.packages.index' || Route::currentRouteName() == 'admin.packages.create' ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-layout"></em></span><span class="nk-menu-text">Packages</span></a>
                        <ul class="nk-menu-sub">
                           <li class="nk-menu-item"><a href="{{route('admin.packages.index')}}" class="nk-menu-link"><span class="nk-menu-text">All Packages</span></a></li>
                        </ul>
                     </li>
                     <li class="nk-menu-item has-sub {{ Route::currentRouteName() == 'admin.rooms.index' ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-home-fill"></em></span><span class="nk-menu-text">Room</span></a>
                        <ul class="nk-menu-sub">
                           <li class="nk-menu-item"><a href="{{route('admin.rooms.index')}}" class="nk-menu-link"><span class="nk-menu-text">All Rooms</span></a></li>
                        </ul>
                     </li>
                     <li class="nk-menu-item has-sub {{ Route::currentRouteName() == 'admin.services.index' ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-layers"></em></span><span class="nk-menu-text">Services</span></a>
                        <ul class="nk-menu-sub">
                           <li class="nk-menu-item"><a href="{{route('admin.services.index')}}" class="nk-menu-link"><span class="nk-menu-text">All Services</span></a></li>
                        </ul>
                     </li>
                     <li class="nk-menu-item has-sub {{ (Route::currentRouteName() == 'admin.coupon' || Route::currentRouteName() == 'admin.surcharge.index') ? 'active' : '' }}"><a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-layers"></em></span><span class="nk-menu-text">Booking Settings</span></a>
                        <ul class="nk-menu-sub">
                           <li class="nk-menu-item"><a href="{{route('admin.coupon')}}" class="nk-menu-link"><span class="nk-menu-text">Coupons</span></a></li>
                           <li class="nk-menu-item"><a href="{{route('admin.surcharge.index')}}" class="nk-menu-link"><span class="nk-menu-text">Surcharge</span></a></li>
                           <li class="nk-menu-item"><a href="{{route('admin.ageSettings.index')}}" class="nk-menu-link"><span class="nk-menu-text">Age Settings</span></a></li>                           
                        </ul>
                     </li>
                     <li class="nk-menu-item"><a href="{{ route('admin.portcalender.index') }}" class="nk-menu-link {{ (Route::currentRouteName() == 'admin.portcalender.index' || Route::currentRouteName() == 'admin.portDetails.setup') ? 'active' : '' }}"><span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span><span class="nk-menu-text">Boat/Port Settings</span></a></li>                    
                     <li class="nk-menu-item"><a href="{{ route('admin.userlist') }}" class="nk-menu-link"><span class="nk-menu-icon {{ (Route::currentRouteName() == 'admin.userlist')}}"><em class="icon ni ni-users-fill"></em></span><span class="nk-menu-text">Customers</span></a></li>
                     <li class="nk-menu-item"><a href="{{ route('admin.agentlist') }}" class="nk-menu-link"><span class="nk-menu-icon {{ (Route::currentRouteName() == 'admin.agentlist')}}"><em class="icon ni ni-users-fill"></em></span><span class="nk-menu-text">Agents</span></a></li>
                     <li class="nk-menu-item"><a href="{{ route('admin.agent_cashout') }}" class="nk-menu-link"><span class="nk-menu-icon {{ (Route::currentRouteName() == 'admin.agent_cashout')}}"><em class="icon ni ni-users-fill"></em></span><span class="nk-menu-text">Agents Cashout Request</span></a></li>
                     <li class="nk-menu-item"><a href="{{route('admin.general_settings.index')}}" class="nk-menu-link {{ (Route::currentRouteName() == 'admin.general_settings.index')}}"><span class="nk-menu-icon"><em class="icon ni ni-setting-alt-fill"></em></span><span class="nk-menu-text">General Settings</span></a></li>
                     <li class="nk-menu-item has-sub {{ (Route::currentRouteName() == 'admin.sliders.index' || Route::currentRouteName() == 'admin.frontend.activity' || Route::currentRouteName() == 'admin.frontend.testimonials' || Route::currentRouteName() == 'admin.frontend.instagram_section') ? 'active' : '' }}"><a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-layers"></em></span><span class="nk-menu-text">Frontend Sections</span></a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item"><a href="{{route('admin.sliders.index')}}" class="nk-menu-link"><span class="nk-menu-text">Main Homepage Banner</span></a></li>
                            <li class="nk-menu-item"><a href="{{route('admin.frontend.activity')}}" class="nk-menu-link"><span class="nk-menu-text">Activity Section</span></a></li>
                            <li class="nk-menu-item"><a href="{{route('admin.frontend.testimonials')}}" class="nk-menu-link"><span class="nk-menu-text">Testimonial Section</span></a></li>
                            <li class="nk-menu-item"><a href="{{route('admin.frontend.instagram_section')}}" class="nk-menu-link"><span class="nk-menu-text">Instagram Section</span></a></li>
                        </ul>
                     </li>
                     <li class="nk-menu-item"><a href="{{route('admin.terms.manage')}}" class="nk-menu-link {{ (Route::currentRouteName() == 'admin.terms.manage')}}"><span class="nk-menu-icon"><em class="icon ni ni-quote-left"></em></span><span class="nk-menu-text">Terms & Conditions</span></a></li>
                    </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="nk-wrap ">
      <div class="nk-header nk-header-fixed is-light">
         <div class="container-fluid">
            <div class="nk-header-wrap">
               <div class="nk-menu-trigger d-xl-none ms-n1"><a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a></div>
               <div class="nk-header-brand d-xl-none">
                  <a href="/admin/dashboard/" class="logo-link">
                  <img class="logo-light logo-img" src="{{url('admin/images/logo-white.svg')}}" alt="logo">
                  <img class="logo-dark logo-img" src="{{url('admin/images/logo-black.svg')}}"alt="logo-dark">
                  </a>
               </div>
               <div class="nk-header-news d-none d-xl-block">
                  <div class="nk-news-list">
                     <a class="nk-news-item" target="_blank" href="/">
                        <div class="nk-news-icon"><em class="icon ni ni-card-view"></em></div>
                        <div class="nk-news-text">
                           <p>View Website <span>The Rock Resorts</span></p>
                           <em class="icon ni ni-external"></em>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="nk-header-tools">
                  <ul class="nk-quick-nav">
                     <li class="dropdown language-dropdown d-none d-sm-block me-n1">
                     <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                           <div class="user-toggle">
                              <div class="user-avatar sm"><em class="icon ni ni-user-alt"></em></div>
                              <div class="user-info d-none d-md-block">
                                 <div class="user-status">Welcome</div>
                                 <div class="user-name dropdown-indicator">{{ Auth::guard('admin')->user()->name }}</div>
                              </div>
                           </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                           <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                              <div class="user-card">
                                 <div class="user-avatar"><span>RR</span></div>
                                 <div class="user-info"><span class="lead-text">{{ Auth::guard('admin')->user()->name }}</span>
                                    <span class="sub-text">{{ Auth::guard('admin')->user()->email }}</span></div>
                              </div>
                           </div>
                           <div class="dropdown-inner">
                              <ul class="link-list">
                                 <li><a href="{{route('admin.adminprofile')}}"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                              </ul>
                           </div>
                           <div class="dropdown-inner">
                              <ul class="link-list">
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <a style="cursor: pointer;" onclick="event.preventDefault();this.closest('form').submit();"><em class="icon ni ni-signout"></em><span>Sign out</span></a>
                                    </form>
                                </li>
                              </ul>
                           </div>
                        </div>
                     </li>
                     <li class="dropdown notification-dropdown me-n1">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                           <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                           <div class="dropdown-head"><span class="sub-title nk-dropdown-title">Notifications</span><a href="#">Mark All as Read</a></div>
                           <div class="dropdown-body">
                              <div class="nk-notification">
                                 <div class="nk-notification-item dropdown-inner">
                                    <div class="nk-notification-icon"><em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em></div>
                                    <div class="nk-notification-content">
                                       <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                       <div class="nk-notification-time">2 hrs ago</div>
                                    </div>
                                 </div>
                                 <div class="nk-notification-item dropdown-inner">
                                    <div class="nk-notification-icon"><em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em></div>
                                    <div class="nk-notification-content">
                                       <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                       <div class="nk-notification-time">2 hrs ago</div>
                                    </div>
                                 </div>
                                 <div class="nk-notification-item dropdown-inner">
                                    <div class="nk-notification-icon"><em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em></div>
                                    <div class="nk-notification-content">
                                       <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                       <div class="nk-notification-time">2 hrs ago</div>
                                    </div>
                                 </div>
                                 <div class="nk-notification-item dropdown-inner">
                                    <div class="nk-notification-icon"><em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em></div>
                                    <div class="nk-notification-content">
                                       <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                       <div class="nk-notification-time">2 hrs ago</div>
                                    </div>
                                 </div>
                                 <div class="nk-notification-item dropdown-inner">
                                    <div class="nk-notification-icon"><em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em></div>
                                    <div class="nk-notification-content">
                                       <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                       <div class="nk-notification-time">2 hrs ago</div>
                                    </div>
                                 </div>
                                 <div class="nk-notification-item dropdown-inner">
                                    <div class="nk-notification-icon"><em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em></div>
                                    <div class="nk-notification-content">
                                       <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                       <div class="nk-notification-time">2 hrs ago</div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="dropdown-foot center"><a href="#">View All</a></div>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
