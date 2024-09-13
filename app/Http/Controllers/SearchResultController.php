<?php

namespace App\Http\Controllers;

use App\Models\InstagramSection;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Support\Facades\Cookie;


class SearchResultController extends Controller
{
    public function index()
    {
        $packages = Package::all(); // This is just an example, adjust the query as needed
        $instagramImages = InstagramSection::all(['id', 'image_path']);
        return view('search_results', compact('packages', 'instagramImages'));
    }

    public function rooms_index()
    {
        $rooms = Room::all(); // This is just an example, adjust the query as needed

        return view('rooms', compact('rooms'));
    }

    public function room_show($id)
    {
        $currentRoom = Room::findOrFail($id);

        // Manually decode the room_gallery attribute if necessary
        if (is_string($currentRoom->room_gallery)) {
            $currentRoom->room_gallery = json_decode($currentRoom->room_gallery, true);
        }

        // Fetch other rooms for suggestions (excluding the current room)
        $suggestedRooms = Room::where('id', '!=', $id)->take(5)->get();

        // Decode room_gallery attribute for suggested rooms if necessary
        foreach ($suggestedRooms as $room) {
            if (is_string($room->room_gallery)) {
                $room->room_gallery = json_decode($room->room_gallery, true);
            }
        }

        return view('room_details', compact('currentRoom', 'suggestedRooms'));
    }


    public function show($id)
    {
        $package = Package::findOrFail($id);

        // Decode services data and extract the IDs
        $servicesData = json_decode($package->services, true);
        $serviceIds = collect($servicesData)->pluck('id')->all();
        $includedServices = Service::whereIn('id', $serviceIds)->get();

        $services = Service::all();
        $similarPackages = Package::where('id', '!=', $id)->get();

        // Decode the other_images JSON string here
        $otherImagesArray = json_decode($package->other_images, true);

        $otherImagesArray = is_array($otherImagesArray) ? $otherImagesArray : [];


        // Decode the duration JSON from the package
        $durations = json_decode($package->duration, true);

        // Find the minimum duration
        $minDuration = collect($durations)->reduce(function ($carry, $item) {
            if (is_null($carry)) return $item;
            if ($item['days'] < $carry['days']) return $item;
            if ($item['days'] == $carry['days'] && $item['nights'] < $carry['nights']) return $item;
            return $carry;
        });

        $totalMaxAdults = Room::sum('max_adults');
        $totalMaxChildren = Room::sum('max_children');

        $cookie = Cookie::forget('bookingData');

        return view('package_details', compact('package', 'totalMaxAdults', 'totalMaxChildren', 'services', 'similarPackages', 'includedServices', 'otherImagesArray', 'minDuration'));
    }

}
