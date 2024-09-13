@extends('admin.layouts.main')

@php
$pageTitle = "General Settings";
@endphp

@section('main-container')

<div class="nk-content">
    <div class="container-fluid">
       <div class="nk-content-inner">
          <div class="nk-content-body">
             <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">General Settings</h3>
                        <div class="nk-block-des text-soft">
                           <p>Update Site Settings</p>
                        </div>
                    </div>
                   <!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <a href="#" id="previous-page-link" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                            <em class="icon ni ni-arrow-left"></em>
                            <span>Back</span>
                        </a>
                    </div>
                   <!-- .nk-block-head-content -->
                </div>
                <!-- .nk-block-between -->
             </div>
             <div class="nk-block nk-block-lg">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">Website Setting</h5>
                        </div>
                        <form action="{{ route('admin.general_settings.update', $settings->id) }}" method="POST" class="gy-3">
                            @csrf
                            @method('PUT')
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label" for="site-name">Site Name</label>
                                        <span class="form-note">Specify the name of your website.</span>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="site-name" name="site_name" value="{{ $settings->site_name ?? 'The Rock Resorts' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label" for="support-email">Support Email</label>
                                        <span class="form-note">Specify the email address for support.</span>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control" id="support-email" name="support_email" value="{{ $settings->support_email ?? 'enquiry@therockresorts.com' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label" for="agent-commission">Agent Commission</label>
                                        <span class="form-note">Enter the commission % for agents.</span>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="agent-commission" name="agent_commission" max="100" min="0" value="{{ $settings->agent_commission ?? 8 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label" for="user-rewards">User Rewards</label>
                                        <span class="form-note">Enter the reward % for users after successful booking.</span>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="user-rewards" name="user_rewards" max="100" min="0" value="{{ $settings->user_rewards ?? 1 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label" for="envi-coin-price">ENVI Coin Price</label>
                                        <span class="form-note">Enter the price ratio for envi coin. e.g., if you want to set 1$ = 100 coins, enter 100.</span>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="envi-coin-price" name="envi_coin_price" value="{{ $settings->envi_coin_price ?? 100 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label" for="total_nights">Total Nights</label>
                                        <span class="form-note">Enter the number of total nights available to book in a year for resort.</span>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="total_nights" name="total_nights" value="{{ $settings->total_nights ?? 0 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label" for="agent_withdrawal_method">
                                            Agent Withdrawal Methods
                                            <em class="icon ni ni-plus-circle" data-bs-toggle="modal" data-bs-target="#modalAddWithdrawMethod"></em>
                                        </label>
                                        <span class="form-note">Add, update, or delete methods for agent to withdraw commission.</span>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <ul class="custom-control-group g-3 align-center">
                                                @foreach ($methods as $index => $method)
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                            <input  onclick="return false;" type="checkbox" class="custom-control-input" id="method-{{ $index }}" name="agent_withdrawal_methods[{{ $index }}][enabled]" {{ $method['enabled'] ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="method-{{ $index }}">{{ $method['name'] }}</label>
                                                            <em class="icon ni ni-edit-alt" data-bs-toggle="modal" data-bs-target="#modalEditWithdrawMethod{{ $index }}"></em>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-7 offset-lg-5">
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-lg btn-primary">Update</button>
                                    </div>
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

<!-- Add Withdraw Method Modal -->
<div class="modal fade" id="modalAddWithdrawMethod" tabindex="-1" role="dialog" aria-labelledby="addWithdrawMethodLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWithdrawMethodLabel">Add Withdraw Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.general_settings.add_withdraw_method', $settings->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="method-name">Name</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="method-name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="method-min-withdrawal">Minimum Withdrawal</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control" id="method-min-withdrawal" name="min_withdrawal" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Withdraw Method Modals -->
@foreach ($methods as $index => $method)
<div class="modal fade" id="modalEditWithdrawMethod{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="editWithdrawMethodLabel{{ $index }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWithdrawMethodLabel{{ $index }}">Edit Withdraw Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.general_settings.update_withdraw_method', ['id' => $settings->id, 'methodIndex' => $index]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label" for="method-name-{{ $index }}">Name</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="method-name-{{ $index }}" name="name" value="{{ $method['name'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="method-min-withdrawal-{{ $index }}">Minimum Withdrawal</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control" id="method-min-withdrawal-{{ $index }}" name="min_withdrawal" value="{{ $method['min_withdrawal'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="method-status-{{ $index }}">Status</label>
                        <div class="form-control-wrap">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="method-status-{{ $index }}" name="status" {{ $method['enabled'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="method-status-{{ $index }}">Enabled</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-withdraw-method-{{ $index }}').submit();">Delete</a>
                    </div>
                </form>
                <form id="delete-withdraw-method-{{ $index }}" action="{{ route('admin.general_settings.delete_withdraw_method', ['id' => $settings->id, 'methodIndex' => $index]) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
