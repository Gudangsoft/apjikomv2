<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['assignedTo', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        // Get all users with member records (editors)
        $users = User::whereHas('member')->with('member')->orderBy('name')->get();
        
        return view('admin.assignments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to_user_id' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|max:10240', // 10MB max
            'google_drive_link' => 'nullable|url',
        ]);

        // Upload file if provided
        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        $validated['assigned_by_user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $assignment = Assignment::create($validated);

        return redirect()->route('admin.assignments.index')
            ->with('success', 'Penugasan berhasil dibuat dan dikirim ke editor.');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load(['assignedTo', 'assignedBy']);
        
        return view('admin.assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $users = User::whereHas('member')->with('member')->orderBy('name')->get();
        
        return view('admin.assignments.edit', compact('assignment', 'users'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to_user_id' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'file' => 'nullable|file|max:10240',
            'google_drive_link' => 'nullable|url',
        ]);

        // Upload new file if provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($assignment->file_path) {
                Storage::disk('public')->delete($assignment->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        $assignment->update($validated);

        return redirect()->route('admin.assignments.index')
            ->with('success', 'Penugasan berhasil diperbarui.');
    }

    public function destroy(Assignment $assignment)
    {
        // Delete file if exists
        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()->route('admin.assignments.index')
            ->with('success', 'Penugasan berhasil dihapus.');
    }
}
