@extends('admin.layouts.main')
@php
$pageTitle = "Instagram Section";
@endphp
@section('main-container')
<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">Instagram Section</h3>
                     <div class="nk-block-des text-soft">
                        <p>Use Image Size 175px x 175px</p>
                     </div>
                  </div>
                  <div class="nk-block-head-content">
                     <ul class="nk-block-tools g-3">
                        <li>
                           <div class="drodown">
                              <a href="{{route('admin.dashboard')}}" class="btn btn-icon btn-primary" ><em class="icon ni ni-chevron-left-c"></em></a>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
                <form action="{{ route('admin.frontend.instagram_section.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="col-md-4 mb-2">
                                <div class="card card-bordered">
                                    <div class="card-inner text-center">
                                        @if(isset($images[$i]))
                                            <img src="{{ asset('storage/' . $images[$i]->image_path) }}" alt="Image" class="img-fluid mb-3">
                                            <input type="hidden" name="image_ids[{{ $i }}]" value="{{ $images[$i]->id }}">
                                        @else
                                            <img src="{{ asset('img/placeholder.png') }}" alt="Placeholder" class="img-fluid mb-3">
                                            <input type="hidden" name="image_ids[{{ $i }}]" value="">
                                        @endif
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="images[{{ $i }}]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update Images</button>
                </form>
         </div>
      </div>
   </div>
</div>

@endsection
