<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RestaurantPageController extends Controller
{
    public function index()
    {
        return view('restaurant');
    }

    public function admin_index()
    {
        $restaurant = Restaurant::first();
        return view('admin.restaurant', compact('restaurant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'icon_textList' => 'required|array',
            'description_1' => 'required|string',
            'description_2' => 'required|string',
            'gallery' => 'required|array',
            'menu_sub_title' => 'required|string|max:255',
            'menu_title' => 'required|string|max:255',
            'menu_categories' => 'required|array',
            'items_list' => 'required|array',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time() . '.' . $request->main_image->extension();
        $request->main_image->move(public_path('images'), $imageName);

        Restaurant::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon_textList' => json_encode($request->icon_textList),
            'description_1' => $request->description_1,
            'description_2' => $request->description_2,
            'gallery' => json_encode($request->gallery),
            'menu_sub_title' => $request->menu_sub_title,
            'menu_title' => $request->menu_title,
            'menu_categories' => json_encode($request->menu_categories),
            'items_list' => json_encode($request->items_list),
            'main_image' => $imageName,
        ]);

        return redirect()->route('admin.restaurant.index')->with('success', 'Restaurant created successfully.');
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'icon_textList' => 'required|array',
            'description_1' => 'required|string',
            'description_2' => 'required|string',
            'gallery' => 'required|array',
            'menu_sub_title' => 'required|string|max:255',
            'menu_title' => 'required|string|max:255',
            'menu_categories' => 'required|array',
            'items_list' => 'required|array',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('main_image')) {
            // Delete the old image from the filesystem
            $oldImagePath = public_path('images/' . $restaurant->main_image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $imageName = time() . '.' . $request->main_image->extension();
            $request->main_image->move(public_path('images'), $imageName);
            $restaurant->main_image = $imageName;
        }

        $restaurant->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon_textList' => json_encode($request->icon_textList),
            'description_1' => $request->description_1,
            'description_2' => $request->description_2,
            'gallery' => json_encode($request->gallery),
            'menu_sub_title' => $request->menu_sub_title,
            'menu_title' => $request->menu_title,
            'menu_categories' => json_encode($request->menu_categories),
            'items_list' => json_encode($request->items_list),
            'main_image' => $restaurant->main_image,
        ]);

        return redirect()->route('admin.restaurant.index')->with('success', 'Restaurant updated successfully.');
    }

    public function destroy(Restaurant $restaurant)
    {
        // Delete the main image from the filesystem
        $imagePath = public_path('images/' . $restaurant->main_image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Delete the restaurant record from the database
        $restaurant->delete();
        return redirect()->route('admin.restaurant.index')->with('success', 'Restaurant deleted successfully.');
    }
}
