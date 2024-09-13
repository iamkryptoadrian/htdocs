<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;


class AdminRoomController extends Controller
{
    // Display a listing of the rooms
    public function index(Request $request)
    {
        // Default values
        $recordsPerPage = $request->query('show', 20);
        $sortOrder = $request->query('order', 'DESC');
        $sortBy = $request->query('sortBy', 'created_at');
        $searchTerm = $request->query('search');

        // Validate sortOrder to prevent SQL injection or errors
        $sortOrder = $sortOrder === 'ASC' ? 'ASC' : 'DESC';

        // Start the query
        $query = Room::query();

        // Apply search term if provided
        if ($searchTerm) {
            $query->where('room_type', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%");
        }

        // Retrieve rooms with pagination and sorting
        $rooms = $query->orderBy($sortBy, $sortOrder)->paginate($recordsPerPage);

        // Attach the current query string to the pagination links to maintain state
        $rooms->appends($request->except('page'));

        // Calculate the range of pages for the "go-to" page dropdown
        $totalPages = $rooms->lastPage();
        // This array will be passed to the view for generating the "go-to" dropdown options
        $pageRange = range(1, $totalPages);

        // Pass necessary data to the view
        return view('admin.rooms.index', [
            'rooms' => $rooms,
            'recordsPerPage' => $recordsPerPage,
            'sortOrder' => $sortOrder,
            'sortBy' => $sortBy,
            'pageRange' => $pageRange,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm,
        ]);
    }

    // Store a newly created room in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'beds_number' => 'required|integer',
            'room_quantity' => 'required|integer',
            'max_guest' => 'required|integer',
            'room_description' => 'required|string',
            'empty_bed_charge' => 'required|integer',
            'room_img' => 'nullable|image',
            'room_gallery.*' => 'image',
        ]);

        DB::beginTransaction(); // Start a transaction to ensure all-or-nothing

        try {
            $room = new Room();
            $room->room_type = $request->input('room_name');
            $room->beds = $request->input('beds_number');
            $room->max_guest = $request->input('max_guest');
            $room->room_quantity = $request->input('room_quantity');
            $room->empty_bed_charge = $request->input('empty_bed_charge');
            $room->room_description = $request->input('room_description');

            // Handle the uploading of the main room image
            if ($request->hasFile('room_img')) {
                $room->room_img = $request->file('room_img')->store('rooms', 'public');
            }

            // Handle the uploading of multiple gallery images
            if ($request->hasFile('room_gallery')) {
                $gallery = [];
                foreach ($request->file('room_gallery') as $file) {
                    $gallery[] = $file->store('room_galleries', 'public');
                }
                $room->room_gallery = json_encode($gallery);
            }

            $room->save();
            DB::commit();

            return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully.');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error adding room: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error adding room.');
        }
    }


    // Update the specified room in the database
    public function update(Request $request, $room_id)
    {
        // Validate the request
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'beds_number' => 'required|integer',
            'room_quantity' => 'required|integer',
            'max_guest' => 'required|integer',
            'room_description' => 'required|string',
            'empty_bed_charge' => 'required|numeric',
            'room_img' => 'nullable|image',
            'room_gallery.*' => 'image',
        ]);

        DB::beginTransaction();

        try {
            $room = Room::findOrFail($room_id);

            if ($room === null) {
                Log::error('Room not found with ID: ' . $room_id);
            }

            $room->room_type = $request->input('room_name'); // Adjust field names as necessary
            $room->beds = $request->input('beds_number');
            $room->max_guest = $request->input('max_guest');
            $room->room_quantity = $request->input('room_quantity');
            $room->empty_bed_charge = $request->input('empty_bed_charge');
            $room->room_description = $request->input('room_description');

            $room->fill($validated);

            // Update the main room image if a new image is uploaded
            if ($request->hasFile('room_img')) {
                // Delete old image if necessary
                Storage::delete($room->room_img);
                $room->room_img = $request->file('room_img')->store('rooms', 'public');
            }

            // Handle adding new images to the gallery without replacing existing ones
            if ($request->hasFile('room_gallery')) {
                // Decode room_gallery or initialize as an empty array if it's null or not a string
                $existingGallery = is_string($room->room_gallery) ? json_decode($room->room_gallery, true) : ($room->room_gallery ?? []);

                // Add new images to the existing gallery
                foreach ($request->file('room_gallery') as $file) {
                    $existingGallery[] = $file->store('room_galleries', 'public');
                }

                // Encode the updated gallery back to JSON
                $room->room_gallery = json_encode($existingGallery);
            }

            $room->save();
            DB::commit(); // Commit the transaction if everything is fine
            return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
        } catch (Exception $e) {
            DB::rollback(); // Rollback the transaction on error
            Log::error('Error updating room: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error updating room.');
        }
    }


    // Remove the specified room from the database
    public function destroy($room_id)
    {
        $room = Room::findOrFail($room_id);
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }

    public function deleteGalleryImage(Request $request, $room_id)
    {
        DB::enableQueryLog(); // Optional: for debugging SQL queries

        try {
            $room = Room::findOrFail($room_id);
            $index = $request->input('index');
            $galleryImages = json_decode($room->room_gallery, true);

            if (isset($galleryImages[$index])) {
                $filePath = $galleryImages[$index];

                // Check if the file exists before attempting to delete
                if (Storage::disk('public')->exists($filePath)) {
                    if (Storage::disk('public')->delete($filePath)) {
                        // Log successful deletion
                        //Log::info('File deleted successfully: ' . $filePath);
                    } else {
                        // Log failed deletion attempt
                        Log::error('Failed to delete file: ' . $filePath);
                        return response()->json(['success' => false, 'message' => 'Failed to delete file from server.']);
                    }
                } else {
                    // Log that the file was not found on the server
                    Log::warning('File not found on server: ' . $filePath);
                }

                unset($galleryImages[$index]);  // Remove the entry from the array
                $room->room_gallery = json_encode(array_values($galleryImages)); // Re-indexes and saves
                $room->save();

                return response()->json(['success' => true, 'message' => 'Gallery image deleted successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Image index not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting gallery image', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to delete image.']);
        }
    }


}
