@extends('admin.layouts.main')

@php
    $pageTitle = 'Manage Restaurant Page';
@endphp

@section('main-container')
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Restaurant Page</h3>
                                <div class="nk-block-des text-soft">
                                    <p>From here you can manage all content of the restaurant page.</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="drodown">
                                            <a href="{{ route('admin.dashboard') }}" class="btn btn-icon btn-primary">
                                                <em class="icon ni ni-chevron-left-c"></em></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if ($restaurant)
                    <form action="{{ route('admin.restaurant.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                    <form action="{{ route('admin.restaurant.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                        @csrf

                        <div class="card">
                            <div class="card-header">
                                <h4>Basic Information</h4>
                            </div>
                            <div class="card-body row">
                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $restaurant->title ?? '' }}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $restaurant->subtitle ?? '' }}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="main_image">Main Image</label>
                                    <input type="file" class="form-control" id="main_image" name="main_image" @if(!$restaurant) required @endif>
                                    @if ($restaurant && $restaurant->main_image)
                                    <img src="{{ asset('images/' . $restaurant->main_image) }}" alt="Main Image" width="100" class="mt-2">
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="icon_textList">Icon Text List</label>
                                    <div id="iconTextListContainer">
                                        @if($restaurant && is_array($restaurant->icon_textList))
                                            @foreach($restaurant->icon_textList as $index => $iconText)
                                            <div class="input-group mb-2">
                                                <input type="file" class="form-control" name="icon_textList[{{ $index }}][icon]" accept="image/*">
                                                <input type="text" class="form-control" name="icon_textList[{{ $index }}][text]" placeholder="Enter Text For Icon" value="{{ $iconText['text'] ?? '' }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-danger remove-icon-text" type="button">Remove</button>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-primary" id="addIconTextButton">Add Icon Text</button>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Description</h4>
                            </div>
                            <div class="card-body row">
                                <div class="form-group col-md-6">
                                    <label for="description_1">Description 1</label>
                                    <textarea class="form-control" id="description_1" name="description_1" rows="3" required>{{ $restaurant->description_1 ?? '' }}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="description_2">Description 2</label>
                                    <textarea class="form-control" id="description_2" name="description_2" rows="3" required>{{ $restaurant->description_2 ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Gallery</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="gallery">Gallery</label>
                                    <div id="galleryContainer">
                                        @if($restaurant && is_array($restaurant->gallery))
                                            @foreach($restaurant->gallery as $image)
                                            <div class="input-group mb-2">
                                                <img src="{{ asset('images/' . $image) }}" alt="Gallery Image" width="100" class="mr-2">
                                                <input type="file" class="form-control" name="gallery[]">
                                                <div class="input-group-append">
                                                    <button class="btn btn-danger remove-gallery-image" type="button">Remove</button>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-primary" id="addGalleryImageButton">Add Gallery Image</button>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Menu</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="menu_sub_title">Menu Sub Title</label>
                                    <input type="text" class="form-control" id="menu_sub_title" name="menu_sub_title" value="{{ $restaurant->menu_sub_title ?? '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="menu_title">Menu Title</label>
                                    <input type="text" class="form-control" id="menu_title" name="menu_title" value="{{ $restaurant->menu_title ?? '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="menu_categories">Menu Categories</label>
                                    <div id="menuCategoriesContainer">
                                        @if($restaurant && is_array($restaurant->menu_categories))
                                            @foreach($restaurant->menu_categories as $category)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="menu_categories[]" value="{{ $category }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-danger remove-category" type="button">Remove</button>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-primary" id="addCategoryButton">Add Category</button>
                                </div>

                                <div class="form-group">
                                    <label for="items_list">Items List</label>
                                    <div id="itemsListContainer">
                                        @if($restaurant && is_array($restaurant->items_list))
                                            @foreach($restaurant->items_list as $index => $item)
                                            <div class="card mb-2 item-card">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="item_name">Item Name</label>
                                                        <input type="text" class="form-control" name="items_list[{{ $index }}][item_name]" value="{{ $item['item_name'] }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item_price">Item Price</label>
                                                        <input type="text" class="form-control" name="items_list[{{ $index }}][item_price]" value="{{ $item['item_price'] }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item_description">Item Description</label>
                                                        <textarea class="form-control" name="items_list[{{ $index }}][item_description]" rows="2">{{ $item['item_description'] }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item_category">Item Category</label>
                                                        <select class="form-control item-category-select" name="items_list[{{ $index }}][item_category][]" multiple>
                                                            @if($restaurant && is_array($restaurant->menu_categories))
                                                                @foreach($restaurant->menu_categories as $category)
                                                                    <option value="{{ $category }}" {{ in_array($category, $item['item_category']) ? 'selected' : '' }}>{{ $category }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item_image">Item Image</label>
                                                        <input type="file" class="form-control" name="items_list[{{ $index }}][item_image]" accept="image/*">
                                                    </div>
                                                    <button type="button" class="btn btn-danger remove-item">Remove Item</button>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-primary" id="addItemButton">Add Item</button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">{{ $restaurant ? 'Update' : 'Create' }} Restaurant</button>
                    </form>

                    @if ($restaurant)
                    <form action="{{ route('admin.restaurant.destroy', $restaurant->id) }}" method="POST" style="margin-top: 20px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Restaurant</button>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('addIconTextButton').addEventListener('click', function () {
                addIconTextField();
            });

            document.getElementById('addGalleryImageButton').addEventListener('click', function () {
                addGalleryImageField();
            });

            document.getElementById('addCategoryButton').addEventListener('click', function () {
                addCategoryField();
            });

            document.getElementById('addItemButton').addEventListener('click', function () {
                addItemField();
            });

            document.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-icon-text')) {
                    event.target.closest('.input-group').remove();
                }

                if (event.target.classList.contains('remove-gallery-image')) {
                    event.target.closest('.input-group').remove();
                }

                if (event.target.classList.contains('remove-category')) {
                    event.target.closest('.input-group').remove();
                }

                if (event.target.classList.contains('remove-item')) {
                    event.target.closest('.item-card').remove();
                }
            });

            refreshCategoryOptions();
        });

        function addIconTextField() {
        const container = document.getElementById('iconTextListContainer');
        const index = container.children.length;
        const html = `
            <div class="input-group mb-2">
                <input type="file" class="form-control" name="icon_textList[${index}][icon]" accept="image/*">
                <input type="text" class="form-control" name="icon_textList[${index}][text]" placeholder="Enter Text For Icon" value="">
                <div class="input-group-append">
                    <button class="btn btn-danger remove-icon-text" type="button">Remove</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

        function addGalleryImageField() {
            const container = document.getElementById('galleryContainer');
            const html = `
                <div class="input-group mb-2">
                    <input type="file" class="form-control" name="gallery[]">
                    <div class="input-group-append">
                        <button class="btn btn-danger remove-gallery-image" type="button">Remove</button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function addCategoryField() {
            const container = document.getElementById('menuCategoriesContainer');
            const html = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="menu_categories[]" value="">
                    <div class="input-group-append">
                        <button class="btn btn-danger remove-category" type="button">Remove</button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            refreshCategoryOptions();
        }

        function addItemField() {
            const container = document.getElementById('itemsListContainer');
            const index = container.children.length;
            const html = `
                <div class="card mb-2 item-card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" class="form-control" name="items_list[${index}][item_name]" value="">
                        </div>
                        <div class="form-group">
                            <label for="item_price">Item Price</label>
                            <input type="text" class="form-control" name="items_list[${index}][item_price]" value="">
                        </div>
                        <div class="form-group">
                            <label for="item_description">Item Description</label>
                            <textarea class="form-control" name="items_list[${index}][item_description]" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="item_category">Item Category</label>
                            <select class="form-control item-category-select" name="items_list[${index}][item_category][]" multiple>
                                @if($restaurant && is_array($restaurant->menu_categories))
                                    @foreach($restaurant->menu_categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item_image">Item Image</label>
                            <input type="file" class="form-control" name="items_list[${index}][item_image]" accept="image/*">
                        </div>
                        <button type="button" class="btn btn-danger remove-item">Remove Item</button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function refreshCategoryOptions() {
            const categories = Array.from(document.querySelectorAll('input[name="menu_categories[]"]')).map(input => input.value);
            const selects = document.querySelectorAll('.item-category-select');
            selects.forEach(select => {
                const selectedValues = Array.from(select.selectedOptions).map(option => option.value);
                select.innerHTML = '';
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category;
                    option.text = category;
                    if (selectedValues.includes(category)) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            });
        }
    </script>
@endsection
