@extends('admin.layouts.main')
@php
$pageTitle = "Update Activity Section";
@endphp
@section('main-container')
<div class="nk-content ">
   <div class="container-fluid">
      <div class="nk-content-inner">
         <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
               <div class="nk-block-between g-3">
                  <div class="nk-block-head-content">
                     <h3 class="nk-block-title page-title">Update Activity Section</h3>
                     <div class="nk-block-des text-soft">
                        <p></p>
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
            <form action="{{ route('admin.frontend.activities.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="row gy-4">
                                @foreach($activities as $index => $activity)
                                    <div class="col-md-12">
                                        <h5>Activity {{ $index + 1 }}</h5>
                                    </div>

                                    <!-- Activity ID (Hidden) -->
                                    <input type="hidden" name="activities[{{ $index }}][id]" value="{{ $activity->id }}">

                                    <!-- Sub Title -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="sub_title_{{ $index }}">Sub Title</label>
                                            <input type="text" class="form-control" id="sub_title_{{ $index }}" name="activities[{{ $index }}][sub_title]" value="{{ old("activities.$index.sub_title", $activity->sub_title) }}" placeholder="Sub Title" required>
                                        </div>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="title_{{ $index }}">Title</label>
                                            <input type="text" class="form-control" id="title_{{ $index }}" name="activities[{{ $index }}][title]" value="{{ old("activities.$index.title", $activity->title) }}" placeholder="Title" required>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="description_{{ $index }}">Description</label>
                                            <textarea class="form-control" id="description_{{ $index }}" name="activities[{{ $index }}][description]" placeholder="Description" required>{{ old("activities.$index.description", $activity->description) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="image_{{ $index }}">Image</label>
                                            <input type="file" class="form-control" id="image_{{ $index }}" name="activities[{{ $index }}][image]">
                                            @if($activity->image)
                                                <img src="{{ asset('storage/' . $activity->image) }}" alt="Current Image" style="max-width: 100px; margin-top: 10px;">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Submit Button -->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
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
