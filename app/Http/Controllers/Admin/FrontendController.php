<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity_Section;
use App\Models\InstagramSection;
use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mews\Purifier\Facades\Purifier;

class FrontendController extends Controller
{
    public function activity_section() {
        $activities = Activity_Section::all();

        // Ensure there are always 4 activities
        while ($activities->count() < 4) {
            $activities->push(new Activity_Section());
        }

        return view('admin.frontend.activity_section', compact('activities'));
    }

    public function update_activity_section(Request $request)
    {
        $data = $request->validate([
            'activities' => 'required|array',
            'activities.*.id' => 'nullable|integer|exists:activity_section,id',
            'activities.*.sub_title' => 'required|string|max:255',
            'activities.*.title' => 'required|string|max:255',
            'activities.*.description' => 'required|string',
            'activities.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        foreach ($data['activities'] as $index => $activityData) {
            if (isset($activityData['id'])) {
                $activity = Activity_Section::find($activityData['id']);
            } else {
                $activity = new Activity_Section;
            }

            $activity->sub_title = $activityData['sub_title'];
            $activity->title = $activityData['title'];
            $activity->description = $activityData['description'];

            if (isset($activityData['image'])) {
                $path = $activityData['image']->store('activities', 'public');
                if ($activity->image) {
                    Storage::disk('public')->delete($activity->image);
                }
                $activity->image = $path;
            }

            $activity->save();
        }

        return redirect()->route('admin.frontend.activity')->with('success', 'Activities updated successfully.');
    }


    public function showTestimonials()
    {
        $testimonial = Testimonial::first();
        $reviews = $testimonial ? ($testimonial->reviews ?? []) : [];
        return view('admin.frontend.testimonials', compact('testimonial', 'reviews'));
    }

    public function saveTestimonial(Request $request)
    {
        $data = $request->validate([
            'section_sub_title' => 'nullable|string|max:255',
            'section_title' => 'nullable|string|max:255',
            'review_index' => 'nullable|integer',
            'review' => 'nullable|string',
            'person_name' => 'nullable|string|max:255',
            'person_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Retrieve the first and only testimonial record or create a new one
        $testimonial = Testimonial::firstOrNew();
        $testimonial->sub_title = $data['section_sub_title'] ?? $testimonial->sub_title ?? '';
        $testimonial->title = $data['section_title'] ?? $testimonial->title ?? '';

        $reviews = $testimonial->reviews ?? [];

        if ($request->filled('review') && $request->filled('person_name')) {
            $reviewData = [
                'review' => $data['review'],
                'person_name' => $data['person_name'],
                'person_image' => null,
            ];

            if ($request->hasFile('person_image')) {
                $reviewData['person_image'] = $request->file('person_image')->store('testimonials', 'public');
            } else {
                if (isset($reviews[$data['review_index']]['person_image'])) {
                    $reviewData['person_image'] = $reviews[$data['review_index']]['person_image'];
                }
            }

            if ($request->filled('review_index')) {
                // Update the existing review
                $reviews[$data['review_index']] = $reviewData;
            } else {
                // Add a new review
                $reviews[] = $reviewData;
            }
        }

        $testimonial->reviews = $reviews;
        $testimonial->save();

        return redirect()->route('admin.frontend.testimonials')->with('success', 'Testimonial saved successfully.');
    }


    public function instagramShow()
    {
        $images = InstagramSection::all();
        return view('admin.frontend.instagram_section', compact('images'));
    }

    public function InstagramSave(Request $request)
    {
        $data = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        foreach ($data['images'] as $index => $image) {
            if ($image) {
                $instagramImage = InstagramSection::find($index + 1);
                $path = $image->store('instagram_section', 'public');

                if ($instagramImage) {
                    // Delete the old image
                    if ($instagramImage->image_path) {
                        Storage::disk('public')->delete($instagramImage->image_path);
                    }

                    // Update the existing record
                    $instagramImage->update(['image_path' => $path]);
                } else {
                    // Create a new record if it doesn't exist
                    InstagramSection::create(['image_path' => $path]);
                }
            }
        }

        return redirect()->route('admin.frontend.instagram_section')->with('success', 'Images updated successfully.');
    }

    public function sliderIndex()
    {
        $sliders = Slider::all();
        return view('admin.frontend.slider_section', compact('sliders'));
    }

    public function sliderstore(Request $request)
    {
        $request->validate([
            'subtitle' => 'nullable|string',
            'title' => 'nullable|string',
            'background_picture' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:6048',
        ]);

        $subtitle = $request->subtitle ?? '';
        $title = $request->title ?? '';

        $imageName = time().'.'.$request->background_picture->extension();
        $request->background_picture->move(public_path('images'), $imageName);

        Slider::create([
            'subtitle' => $subtitle,
            'title' => $title,
            'background_picture' => $imageName,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function sliderupdate(Request $request, Slider $slider)
    {
        $request->validate([
            'subtitle' => 'nullable|string',
            'title' => 'nullable|string',
            'background_picture' => 'image|mimes:jpeg,png,jpg,gif,webp|max:6048',
        ]);

        $subtitle = $request->subtitle ?? '';
        $title = $request->title ?? '';

        if ($request->hasFile('background_picture')) {
            $imageName = time().'.'.$request->background_picture->extension();
            $request->background_picture->move(public_path('images'), $imageName);
            $slider->background_picture = $imageName;
        }

        $slider->subtitle = $subtitle;
        $slider->title = $title;
        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function sliderdestroy(Slider $slider)
    {
        // Delete the image from the filesystem
        $imagePath = public_path('images/' . $slider->background_picture);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Delete the slider record from the database
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully.');
    }

    public function slideredit(Slider $slider)
    {
        return response()->json($slider);
    }
}
