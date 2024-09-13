@extends('agent.layouts.main')

@php
    $pageTitle = 'Agent Profile';
@endphp

@section('main-container')
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-aside-wrap">
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head nk-block-head-lg">
                                        <div class="nk-block-between">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">Personal Information</h4>
                                                <div class="nk-block-des">
                                                    <p>Basic info, like your name and address.</p>
                                                </div>
                                            </div>
                                            <div class="nk-block-head-content align-self-start d-lg-none">
                                                <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                                    data-target="userAside">
                                                    <em class="icon ni ni-menu-alt-r"></em>
                                                </a>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="nk-block">
                                        <div class="nk-data data-list">
                                            <div class="data-head">
                                                <h6 class="overline-title">Basics</h6>
                                            </div>
                                            <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                <div class="data-col">
                                                    <span class="data-label">Full Name</span>
                                                    <span class="data-value">{{ Auth::guard('agent')->user()->name }}</span>
                                                </div>
                                                <div class="data-col data-col-end">
                                                    <span class="data-more"><em class="icon ni ni-forward-ios"></em></span>
                                                </div>
                                            </div><!-- data-item -->
                                            <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                <div class="data-col">
                                                    <span class="data-label">Display Name</span>
                                                    <span class="data-value">{{ Auth::guard('agent')->user()->name }}</span>
                                                </div>
                                                <div class="data-col data-col-end">
                                                    <span class="data-more"><em class="icon ni ni-forward-ios"></em></span>
                                                </div>
                                            </div><!-- data-item -->
                                            <div class="data-item">
                                                <div class="data-col">
                                                    <span class="data-label">Email</span>
                                                    <span
                                                        class="data-value">{{ Auth::guard('agent')->user()->email }}</span>
                                                </div>
                                                <div class="data-col data-col-end">
                                                    <span class="data-more"><em class="icon ni ni-forward-ios"></em></span>
                                                </div>
                                            </div><!-- data-item -->
                                        </div><!-- data-list -->
                                    </div><!-- .nk-block -->
                                </div>
                                <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg"
                                    data-toggle-body="true" data-content="userAside" data-toggle-screen="lg"
                                    data-toggle-overlay="true">
                                    <div class="card-inner-group" data-simplebar>
                                        <div class="card-inner">
                                            <div class="user-card">
                                                <div class="user-avatar bg-primary">
                                                    <span>{{ substr(Auth::guard('agent')->user()->name, 0, 2) }}</span>
                                                </div>
                                                <div class="user-info">
                                                    <span class="lead-text">{{ Auth::guard('agent')->user()->name }}</span>
                                                    <span class="sub-text">{{ Auth::guard('agent')->user()->email }}</span>
                                                </div>
                                                <div class="user-action">
                                                    <div class="dropdown">
                                                        <a class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown"
                                                            href="#">
                                                            <em class="icon ni ni-more-v"></em>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em
                                                                            class="icon ni ni-edit-fill"></em><span>-</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .user-card -->
                                        </div><!-- .card-inner -->
                                        <div class="card-inner">
                                            <div class="user-account-info py-0">
                                                <h6 class="overline-title-alt">Wallet Account</h6>
                                                <div class="user-balance">RM
                                                    {{ Auth::guard('agent')->user()->agent_wallet_balance }}</div>
                                                <div class="user-balance-sub">Pending Cashout: RM
                                                    <span>{{ Auth::guard('agent')->user()->pending_cashout }}</span></div>
                                            </div>
                                        </div><!-- .card-inner -->
                                        <div class="card-inner p-0">
                                            <ul class="link-list-menu">
                                                <li><a class="active" href=""><em
                                                            class="icon ni ni-user-fill-c"></em><span>Personal
                                                            Information</span></a></li>
                                            </ul>
                                        </div><!-- .card-inner -->
                                    </div><!-- .card-inner-group -->
                                </div><!-- card-aside -->
                            </div><!-- .card-aside-wrap -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
        <!-- Profile Edit Modal -->
        <div class="modal fade" id="profile-edit" tabindex="-1" role="dialog" aria-labelledby="profileEditModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em
                            class="icon ni ni-cross-sm"></em></a>
                    <div class="modal-body modal-body-lg">
                        <h5 class="title">Update Profile</h5>
                        <ul class="nk-nav nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personal">Personal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#password">Password</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Personal Information Tab -->
                            <div class="tab-pane active" id="personal">
                                <form method="POST" action="{{ route('agent.profile.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row gy-4">
                                        <!-- Full Name -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="full-name" class="form-label">Full Name</label>
                                                <input id="full-name" type="text" class="form-control form-control-lg"
                                                    name="name" value="{{ old('name', $agent->name) }}"
                                                    placeholder="Enter Full name">
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email</label>
                                                <input id="email" type="text" class="form-control form-control-lg"
                                                    name="email" value="{{ old('email', $agent->email) }}"
                                                    placeholder="Enter New Email">
                                            </div>
                                        </div>
                                        <!-- Company Name -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_name" class="form-label">Company Name</label>
                                                <input id="company_name" type="text"
                                                    class="form-control form-control-lg" name="company_name"
                                                    value="{{ old('company_name', $agent->company_name) }}"
                                                    placeholder="Enter Company Name">
                                            </div>
                                        </div>
                                        <!-- Phone Number -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone_number" class="form-label">Phone Number</label>
                                                <input id="phone_number" type="text"
                                                    class="form-control form-control-lg" name="phone_number"
                                                    value="{{ old('phone_number', $agent->phone_number) }}"
                                                    placeholder="Enter Phone Number">
                                            </div>
                                        </div>
                                        <!-- Street -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="street" class="form-label">Street</label>
                                                <input id="street" type="text" class="form-control form-control-lg"
                                                    name="street" value="{{ old('street', $agent->street) }}"
                                                    placeholder="Enter Street">
                                            </div>
                                        </div>
                                        <!-- City -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="city" class="form-label">City</label>
                                                <input id="city" type="text" class="form-control form-control-lg"
                                                    name="city" value="{{ old('city', $agent->city) }}"
                                                    placeholder="Enter City">
                                            </div>
                                        </div>
                                        <!-- Postcode -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="postcode" class="form-label">Postcode</label>
                                                <input id="postcode" type="text" class="form-control form-control-lg"
                                                    name="postcode" value="{{ old('postcode', $agent->postcode) }}"
                                                    placeholder="Enter Postcode">
                                            </div>
                                        </div>
                                        <!-- Country -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country" class="form-label">Country</label>
                                                <input id="country" type="text" class="form-control form-control-lg"
                                                    name="country" value="{{ old('country', $agent->country) }}"
                                                    placeholder="Enter Country">
                                            </div>
                                        </div>
                                        <!-- Submit Buttons -->
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-lg btn-primary">Update
                                                        Profile</button>
                                                </li>
                                                <li>
                                                    <a href="#" data-bs-dismiss="modal"
                                                        class="link link-light">Cancel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- Password Tab -->
                            <div class="tab-pane" id="password">
                                <form method="POST" action="{{ route('agent.profile.updatePassword') }}">
                                    @csrf
                                    @method('put')
                                    <div class="row gy-4">
                                        <!-- Old Password -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="old_password" class="form-label">Old Password</label>
                                                <input type="password" class="form-control form-control-lg"
                                                    id="old_password" name="old_password" placeholder="Old Password"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- New Password -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new_password" class="form-label">New Password</label>
                                                <input type="password" class="form-control form-control-lg"
                                                    id="new_password" name="new_password" placeholder="New Password"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Confirm New Password -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new_password_confirmation" class="form-label">Confirm New
                                                    Password</label>
                                                <input type="password" class="form-control form-control-lg"
                                                    id="new_password_confirmation" name="new_password_confirmation"
                                                    placeholder="Confirm New Password" required>
                                            </div>
                                        </div>

                                        <!-- Update and Cancel Buttons -->
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-lg btn-primary">Update
                                                        Password</button>
                                                </li>
                                                <li>
                                                    <a href="#" data-bs-dismiss="modal"
                                                        class="link link-light">Cancel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
