<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with('assignedBy')
            ->where('assigned_to_user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('member.assignments.index', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        // Ensure user can only view their own assignments
        if ($assignment->assigned_to_user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $assignment->load('assignedBy');
        
        return view('member.assignments.show', compact('assignment'));
    }

    public function download(Assignment $assignment)
    {
        // Ensure user can only download their own assignments
        if ($assignment->assigned_to_user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$assignment->file_path) {
            return redirect()->back()->with('error', 'File tidak tersedia.');
        }

        return Storage::disk('public')->download($assignment->file_path, basename($assignment->file_path));
    }

    public function updateStatus(Request $request, Assignment $assignment)
    {
        // Ensure user can only update their own assignments
        if ($assignment->assigned_to_user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:in_progress,completed',
        ]);

        $assignment->update($validated);

        return redirect()->back()->with('success', 'Status penugasan berhasil diperbarui.');
    }
}
