@extends('admin.layouts.main')
@php
$pageTitle = "Add Testimonial Section";
@endphp
@section('main-container')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Update Testimonial Section</h3>
                            <div class="nk-block-des text-soft">
                                <p></p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="nk-block-tools g-3">
                                <li>
                                    <div class="drodown">
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-icon btn-primary"><em class="icon ni ni-chevron-left-c"></em></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Section for Title and Subtitle -->
                <div class="nk-block mb-5">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h3>Section Title and Subtitle</h3>
                            <form action="{{ route('admin.frontend.testimonials.save') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="section_sub_title">Section Sub Title</label>
                                    <input type="text" class="form-control" id="section_sub_title" name="section_sub_title" value="{{ $testimonial->sub_title ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="section_title">Section Title</label>
                                    <input type="text" class="form-control" id="section_title" name="section_title" value="{{ $testimonial->title ?? '' }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Title & Subtitle</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Section for Adding/Editing Testimonial -->
                <div class="nk-block mb-5">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h3 id="form-title">Add/Edit Testimonial</h3>
                            <form action="{{ route('admin.frontend.testimonials.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="testimonial-id" value="{{ $testimonial->id ?? '' }}">
                                <input type="hidden" name="review_index" id="review-index">
                                <div class="form-group">
                                    <label for="review">Write Review</label>
                                    <textarea class="form-control" id="review" name="review"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="person_name">Name of Person</label>
                                    <input type="text" class="form-control" id="person_name" name="person_name">
                                </div>
                                <div class="form-group">
                                    <label for="person_image">Picture of Person</label>
                                    <input type="file" class="form-control" id="person_image" name="person_image">
                                </div>
                                <button type="submit" class="btn btn-primary" id="form-submit-button">Save Testimonial</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Section for Displaying Existing Testimonials -->
                <div class="nk-block mb-5">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="nk-block">
                                <div class="row">
                                    @foreach($reviews as $index => $review)
                                        <div class="col-md-4">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="team">
                                                        <div class="user-card user-card-s2">
                                                            <div class="user-avatar md bg-info">
                                                                @if($review['person_image'])
                                                                    <img src="{{ asset('storage/' . $review['person_image']) }}" alt="Image" class="rounded-circle" style="width: 50px; height: 50px;">
                                                                @else
                                                                    <span>{{ strtoupper(substr($review['person_name'], 0, 2)) }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="user-info">
                                                                <h6>{{ $review['person_name'] }}</h6>
                                                            </div>
                                                        </div>
                                                        <div class="team-details pt-0">
                                                            <p>{{ $review['review'] }}</p>
                                                        </div>
                                                        <div class="team-view">
                                                            <button class="btn btn-round btn-outline-light" onclick="editTestimonial({{ $index }}, '{{ addslashes(json_encode($review['review'])) }}', '{{ addslashes(json_encode($review['person_name'])) }}', '{{ addslashes(json_encode($review['person_image'] ?? '')) }}')">Edit Review</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editTestimonial(index, review, personName, personImage) {
        document.getElementById('review-index').value = index;
        document.getElementById('review').value = JSON.parse(review);
        document.getElementById('person_name').value = JSON.parse(personName);
        document.getElementById('form-title').innerText = 'Edit Testimonial';
        document.getElementById('form-submit-button').innerText = 'Update Testimonial';

        if (personImage && personImage !== 'null') {
            document.getElementById('person_image').style.display = 'block';
        } else {
            document.getElementById('person_image').style.display = 'block';
        }
    }
</script>
@endsection
