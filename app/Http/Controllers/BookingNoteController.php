<?php

namespace App\Http\Controllers;

use App\Models\BookingNote;
use Auth;
use Illuminate\Http\Request;

class BookingNoteController extends Controller
{
    public function storePrivateNote(Request $request, $bookingId)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        $note = new BookingNote();
        $note->booking_id = $bookingId;
        $note->author_id = $this->getAuthorId(); // Helper function to determine author ID
        $note->note_type = 'private'; // this is a private note
        $note->content = $request->note;
        $note->save();

        return redirect()->back()->with('success', 'Note added successfully.');
    }

    private function getAuthorId()
    {
        // Check if the authenticated user is an admin and return 0 if true
        if (Auth::user() && Auth::user()->is_admin) {
            return 0;
        }
        return Auth::id();
    }

    public function delete($id)
    {
        $note = BookingNote::findOrFail($id);  // Find the note or fail with a 404

        // Authorization check: Ensure that the user has permission to delete this note.
        // For example, you might want to ensure the user is an admin or the creator of the note:
        if (Auth::id() !== $note->author_id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $note->delete();

        return back()->with('success', 'Note deleted successfully.');  // Redirect back with a success message
    }
}
