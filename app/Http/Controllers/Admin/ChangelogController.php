<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Changelog;
use App\Models\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangelogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $changelogs = Changelog::orderBy('release_date', 'desc')->paginate(10);
        $updateRequests = UpdateRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.changelog.index', compact('changelogs', 'updateRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.changelog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'version' => 'nullable|string|max:255',
            'release_date' => 'required|date',
            'changes' => 'required|string',
            'type' => 'required|in:update,bugfix,feature,security',
            'is_published' => 'boolean'
        ]);

        $validated['updated_by'] = Auth::user()->name;
        $validated['is_published'] = $request->has('is_published');

        Changelog::create($validated);

        return redirect()->route('admin.changelog.index')
            ->with('success', 'Changelog berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Changelog $changelog)
    {
        return view('admin.changelog.show', compact('changelog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Changelog $changelog)
    {
        return view('admin.changelog.edit', compact('changelog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Changelog $changelog)
    {
        $validated = $request->validate([
            'version' => 'nullable|string|max:255',
            'release_date' => 'required|date',
            'changes' => 'required|string',
            'type' => 'required|in:update,bugfix,feature,security',
            'is_published' => 'boolean'
        ]);

        $validated['updated_by'] = Auth::user()->name;
        $validated['is_published'] = $request->has('is_published');

        $changelog->update($validated);

        return redirect()->route('admin.changelog.index')
            ->with('success', 'Changelog berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Changelog $changelog)
    {
        $changelog->delete();

        return redirect()->route('admin.changelog.index')
            ->with('success', 'Changelog berhasil dihapus');
    }

    /**
     * Store update request from member
     */
    public function storeRequest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        UpdateRequest::create($validated);

        return back()->with('success', 'Request update berhasil dikirim');
    }

    /**
     * Update status of update request
     */
    public function updateRequestStatus(Request $request, UpdateRequest $updateRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $updateRequest->update($validated);

        return back()->with('success', 'Status request berhasil diupdate');
    }

    /**
     * Delete update request
     */
    public function destroyRequest(UpdateRequest $updateRequest)
    {
        $updateRequest->delete();

        return back()->with('success', 'Request berhasil dihapus');
    }

    /**
     * Get latest changelogs for auto-refresh (AJAX)
     */
    public function getLatest(Request $request)
    {
        $lastCheckTime = $request->input('last_check');
        
        $changelogs = Changelog::orderBy('release_date', 'desc')
            ->when($lastCheckTime, function($query) use ($lastCheckTime) {
                return $query->where('updated_at', '>', $lastCheckTime);
            })
            ->limit(10)
            ->get();

        $updateRequests = UpdateRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->when($lastCheckTime, function($query) use ($lastCheckTime) {
                return $query->where('updated_at', '>', $lastCheckTime);
            })
            ->limit(10)
            ->get();

        return response()->json([
            'changelogs' => $changelogs,
            'updateRequests' => $updateRequests,
            'timestamp' => now()->toIso8601String(),
            'hasNewChangelogs' => $changelogs->count() > 0,
            'hasNewRequests' => $updateRequests->count() > 0,
            'pendingCount' => UpdateRequest::where('status', 'pending')->count()
        ]);
    }
}
