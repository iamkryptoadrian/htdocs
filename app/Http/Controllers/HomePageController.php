<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity_Section;
use App\Models\InstagramSection;
use App\Models\Room;
use App\Models\Slider;
use App\Models\Testimonial;
use Artisan;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class HomePageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('agent_code')) {
            $agentCode = $request->query('agent_code');
            Cookie::queue('agent_code', $agentCode, 60 * 48); // 48 hours
        }


        $rooms = Room::all();
        foreach ($rooms as $room) {
            if (is_string($room->room_gallery)) {
                $room->room_gallery = json_decode($room->room_gallery, true);
            }
        }

        $activities = Activity_Section::all(['id', 'sub_title', 'title', 'description', 'image']);
        $testimonial = Testimonial::first(['id', 'reviews']);
        $reviews = $testimonial ? ($testimonial->reviews ?? []) : [];
        $instagramImages = InstagramSection::all(['id', 'image_path']);
        $sliders = Slider::all(['id', 'title', 'subtitle', 'background_picture']);

        return view('welcome', compact('rooms', 'activities', 'testimonial', 'reviews', 'instagramImages', 'sliders'));
    }


    public function createStorageLink()
    {
        try {
            Artisan::call('storage:link');
            return response()->json(['message' => 'Storage link created successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create storage link.', 'error' => $e->getMessage()], 500);
        }
    }

}
