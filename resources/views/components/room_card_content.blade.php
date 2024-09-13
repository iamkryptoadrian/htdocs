{{-- Room content component --}}
<div class="roomCardContent">
    <div data-anim-child="slide-up delay-3" class="roomCard__content">
        <div class="d-flex justify-between items-end">
            <h3 class="roomCard__title lh-1 text-64 md:text-40">{{ $room->room_type }}</h3>
        </div>
        <div class="d-flex x-gap-20 pt-40 md:pt-30">            
            <div class="d-flex items-center text-accent-1">
                <i class="icon-guest text-20 mr-10"></i> {{ $room->max_guest }} Guest
            </div>         
            <div class="d-flex items-center text-accent-1">
                <i class="icon-bed-2 text-20 mr-10"></i> {{ $room->beds }} BED
            </div>
            <div class="d-flex items-center text-accent-1">
                <i class="icon-bath text-20 mr-10"></i> 1 BATH
            </div>
        </div>
        <p class="mt-40 md:mt-30">{{ $room->room_description }}</p>

        <div class="room-selection">
            <div>
                <label for="select-room-{{ $room->id }}" class="d-flex align-items-center">Select This Room:</label>
                <div class="form-checkbox">
                    <input type="checkbox" id="select-room-{{ $room->id }}" name="rooms[{{ $room->id }}][selected]" class="select-input" onclick="updateRoomSelection({{ $room->id }}, {{ $room->max_guest }});">
                    <label for="select-room-{{ $room->id }}" class="form-checkbox__mark d-flex align-items-center justify-content-center">
                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                            <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white"></path> 
                        </svg>
                    </label>
                </div>
            </div>
            <div>
                <label for="room-quantity-{{ $room->id }}">Quantity:</label>
                <select id="room-quantity-{{ $room->id }}" name="rooms[{{ $room->id }}][quantity]" class="select-dropdown" onchange="updateRoomQuantity({{ $room->id }}, parseInt(this.value), {{ $room->max_guest }});">
                    @for ($i = 1; $i <= $room->room_quantity; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        
        <div class="guest-selection">
            <!-- Guest dropdowns will be dynamically inserted here -->
            <div id="guest-dropdowns-{{ $room->id }}"></div>
        </div>
        
           
    </div>
</div>    


{{-- 
    
room_id {
    room name - ocean room
    qty - 2
    room 1 guest count - 1 - 2
    room 2 guest count - 1 (so how many person in each room)
    empty beds count - 2
    charges
}



room_id {
    room name - dorm room
    qty - 1
    room 1 guest count - 1
    empty beds count - 7
}




--}}