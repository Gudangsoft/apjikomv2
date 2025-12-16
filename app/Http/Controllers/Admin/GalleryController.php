<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('event')
            ->orderBy('is_featured', 'desc')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        $events = Event::orderBy('event_date', 'desc')->get();
        return view('admin.galleries.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'image' => 'required_if:type,image|nullable|image|mimes:jpeg,png,jpg|max:5120',
            'youtube_url' => 'required_if:type,video|nullable|url',
            'event_id' => 'nullable|exists:events,id',
            'category' => 'required|string|in:event,activity,member,other',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['order'] = $validated['order'] ?? 0;

        if ($validated['type'] === 'image' && $request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        } elseif ($validated['type'] === 'video' && !empty($validated['youtube_url'])) {
            $youtubeId = Gallery::extractYoutubeId($validated['youtube_url']);
            if ($youtubeId) {
                $validated['youtube_id'] = $youtubeId;
                $validated['image'] = "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg";
            }
        }

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil ditambahkan');
    }

    public function edit(Gallery $gallery)
    {
        $events = Event::orderBy('event_date', 'desc')->get();
        return view('admin.galleries.edit', compact('gallery', 'events'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'image' => 'required_if:type,image|nullable|image|mimes:jpeg,png,jpg|max:5120',
            'youtube_url' => 'required_if:type,video|nullable|url',
            'event_id' => 'nullable|exists:events,id',
            'category' => 'required|string|in:event,activity,member,other',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['order'] = $validated['order'] ?? 0;

        if ($validated['type'] === 'image' && $request->hasFile('image')) {
            // Delete old image if it's stored locally
            if ($gallery->image && !str_starts_with($gallery->image, 'http')) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        } elseif ($validated['type'] === 'video' && !empty($validated['youtube_url'])) {
            $youtubeId = Gallery::extractYoutubeId($validated['youtube_url']);
            if ($youtubeId) {
                $validated['youtube_id'] = $youtubeId;
                $validated['image'] = "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg";
            }
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete image only if it's stored locally (not YouTube thumbnail)
        if ($gallery->image && !str_starts_with($gallery->image, 'http')) {
            Storage::disk('public')->delete($gallery->image);
        }
        
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dihapus');
    }

    public function toggleFeatured(Gallery $gallery)
    {
        $gallery->update(['is_featured' => !$gallery->is_featured]);
        return back()->with('success', 'Status featured berhasil diubah');
    }
}
