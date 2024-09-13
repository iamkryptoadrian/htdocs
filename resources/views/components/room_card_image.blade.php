{{-- Room image component --}}

<div data-anim-child="img-right cover-white delay-1">
    <div class="roomCard__image -no-rounded ratio ratio-10:9">
        <img src="{{ asset('storage/'.$room->room_img) }}" alt="Room Image" class="img-ratio">
        <div class="roomCard__price text-15 fw-500 bg-white text-accent-1 rounded-0">${{ $detail['price'] }} / NIGHT</div>
    </div>
</div>