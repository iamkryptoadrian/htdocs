@extends('admin.layouts.main')
@php
    $pageTitle = 'Main Slider Section';
@endphp
@section('main-container')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Main Slider Section</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Use Image Size 1400px x 855px | 1200px X 786px</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="drodown">
                                            <a href="{{ route('admin.dashboard') }}" class="btn btn-icon btn-primary"><em
                                                    class="icon ni ni-chevron-left-c"></em></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mb-3" onclick="toggleForm()">Add New Slider</button>

                    <div id="sliderForm" style="display:none;" class="card p-4">
                        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="subtitle">Subtitle</label>
                                <textarea class="form-control" id="subtitle" name="subtitle" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <textarea class="form-control" id="title" name="title" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="background_picture">Background Picture</label>
                                <input type="file" class="form-control" id="background_picture" name="background_picture" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Slider</button>
                        </form>
                    </div>

                    <div id="editSliderForm" class="card p-4" style="display:none;">
                        <form id="editForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="edit_subtitle">Subtitle</label>
                                <textarea class="form-control" id="edit_subtitle" name="subtitle" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_title">Title</label>
                                <textarea class="form-control" id="edit_title" name="title" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_background_picture">Background Picture</label>
                                <input type="file" class="form-control" id="edit_background_picture" name="background_picture">
                                <img id="current_background_picture" src="" alt="Current Background" width="100" class="mt-2">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Slider</button>
                        </form>
                    </div>

                    <div class="scrollable_table">
                        <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subtitle</th>
                                <th>Title</th>
                                <th>Background Picture</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $slider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{!! $slider->subtitle !!}</td>
                                    <td>{!! $slider->title !!}</td>
                                    <td><img src="{{ asset('images/' . $slider->background_picture) }}"
                                            alt="{{ $slider->title }}" width="100"></td>
                                    <td>
                                        <button class="btn btn-warning"
                                            onclick="editSlider({{ $slider->id }})">Edit</button>
                                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>

                    <script>
                        function toggleForm() {
                            var form = document.getElementById('sliderForm');
                            form.style.display = form.style.display === 'none' ? 'block' : 'none';
                        }

                        function editSlider(id) {
                            var form = document.getElementById('editSliderForm');
                            form.style.display = 'block';

                            fetch(`/admin/dashboard/frontend/sliders/${id}/edit`)
                                .then(response => response.json())
                                .then(data => {
                                    document.getElementById('editForm').action = `/admin/dashboard/frontend/sliders/${id}`;
                                    document.getElementById('edit_subtitle').value = data.subtitle;
                                    document.getElementById('edit_title').value = data.title;
                                    document.getElementById('current_background_picture').src = `/images/${data.background_picture}`;
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
