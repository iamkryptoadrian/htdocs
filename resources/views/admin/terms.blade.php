@extends('admin.layouts.main')
@php
    $pageTitle = "Terms & Condition";
@endphp
@section('main-container')

<div class="nk-content">
    <div class="container-fluid">
       <div class="nk-content-inner">
          <div class="nk-content-body">
             <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Manage Terms and Conditions</h3>
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
                        <form action="{{ route('admin.terms.save') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" name="content" rows="10">{{ old('content', $terms->content ?? '') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
@endsection
