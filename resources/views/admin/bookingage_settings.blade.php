@extends('admin.layouts.main')

@php
$pageTitle = "Customer Age Settings";
@endphp

@section('main-container')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Age Settings</h3>
                            <div class="nk-block-des text-soft">
                                <p>Adjust age settings and associated discounts for all guest categories and manage port configurations.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="row gy-4">
                                    <input type="hidden" name="id" value="{{ $setting->id }}">

                                    <!-- Adult Age and Discount -->
                                    <div class="col-md-6">
                                        <label for="adult_age" class="form-label">Adult Age</label>
                                        <input type="text" class="form-control" id="adult_age" name="adult_age" value="{{ $setting->adult_age }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="adult_discount" class="form-label">Adult Discount (%)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">%</span></div>
                                            <input type="number" class="form-control" id="adult_discount" name="adult_discount" value="{{ $setting->adult_discount }}" step="0.01">
                                        </div>
                                    </div>

                                    <!-- Children Age and Discount -->
                                    <div class="col-md-6">
                                        <label for="children_age" class="form-label">Children Age</label>
                                            <input type="text" class="form-control" id="children_age" name="children_age" value="{{ $setting->children_age }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="children_discount" class="form-label">Children Discount (%)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">%</span></div>
                                            <input type="number" class="form-control" id="children_discount" name="children_discount" value="{{ $setting->children_discount }}" step="0.01">
                                        </div>
                                    </div>

                                    <!-- Kids Age and Discount -->
                                    <div class="col-md-6">
                                        <label for="kids_age" class="form-label">Kids Age</label>
                                        <input type="text" class="form-control" id="kids_age" name="kids_age" value="{{ $setting->kids_age }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kids_discount" class="form-label">Kids Discount (%)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">%</span></div>
                                            <input type="number" class="form-control" id="kids_discount" name="kids_discount" value="{{ $setting->kids_discount }}" step="0.01">
                                        </div>
                                    </div>

                                    <!-- Toddlers Age and Discount -->
                                    <div class="col-md-6">
                                        <label for="Toddlers_age" class="form-label">Toddlers Age</label>
                                        <input type="text" class="form-control" id="Toddlers_age" name="Toddlers_age" value="{{ $setting->Toddlers_age }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Toddlers_discount" class="form-label">Toddlers Discount (%)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">%</span></div>
                                            <input type="number" class="form-control" id="Toddlers_discount" name="Toddlers_discount" value="{{ $setting->Toddlers_discount }}" step="0.01">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-md-6">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Update Settings</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
