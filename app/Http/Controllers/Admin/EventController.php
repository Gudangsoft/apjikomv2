<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status == 'published') {
                $query->where('is_published', true);
            } else {
                $query->where('is_published', false);
            }
        }

        // Featured filter
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }

        // Date range (event_date)
        if ($request->filled('date_from')) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

        // Sorting
        switch ($request->input('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'event_date_asc':
                $query->orderBy('event_date', 'asc');
                break;
            case 'event_date_desc':
                $query->orderBy('event_date', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
        }

        $perPage = $request->input('per_page', 15);
        $events = $query->paginate($perPage)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'event_date' => 'required|date',
            'event_time' => 'nullable|string|max:50',
            'event_type' => 'required|in:online,offline,hybrid',
            'location' => 'required_if:event_type,offline,hybrid|nullable|string|max:255',
            'online_platform' => 'required_if:event_type,online,hybrid|nullable|string|max:255',
            'has_registration' => 'boolean',
            'has_certificate' => 'boolean',
            'registration_requirements' => 'nullable|string',
            'participant_quota' => 'nullable|integer|min:1',
            'is_paid' => 'boolean',
            'registration_fee' => 'nullable|numeric|min:0',
            'bank_name' => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:100',
            'payment_contact' => 'nullable|string|max:100',
            'registration_link' => 'nullable|url|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function edit(Event $event)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'event_date' => 'required|date',
            'event_time' => 'nullable|string|max:50',
            'event_type' => 'required|in:online,offline,hybrid',
            'location' => 'required_if:event_type,offline,hybrid|nullable|string|max:255',
            'online_platform' => 'required_if:event_type,online,hybrid|nullable|string|max:255',
            'has_registration' => 'boolean',
            'has_certificate' => 'boolean',
            'registration_requirements' => 'nullable|string',
            'participant_quota' => 'nullable|integer|min:1',
            'is_paid' => 'boolean',
            'registration_fee' => 'nullable|numeric|min:0',
            'bank_name' => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:100',
            'payment_contact' => 'nullable|string|max:100',
            'registration_link' => 'nullable|url|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            // Hapus image lama
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil diupdate');
    }

    public function destroy(Event $event)
    {
        // Hapus image jika ada
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil dihapus');
    }

    /**
     * Show event participants
     */
    public function participants(Event $event)
    {
        $registrations = $event->registrations()
            ->with('user.member')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.events.participants', compact('event', 'registrations'));
    }

    /**
     * Verify payment for registration
     */
    public function verifyPayment(Request $request, Event $event, \App\Models\EventRegistration $registration)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:verified,rejected',
            'payment_notes' => 'nullable|string|max:500',
        ]);

        $registration->update([
            'payment_status' => $validated['payment_status'],
            'payment_notes' => $validated['payment_notes'] ?? null,
            'payment_verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        $statusText = $validated['payment_status'] === 'verified' ? 'diverifikasi' : 'ditolak';
        
        return back()->with('success', "Pembayaran berhasil {$statusText}");
    }

    /**
     * Update registration status (attended/cancelled)
     */
    public function updateRegistrationStatus(Request $request, Event $event, \App\Models\EventRegistration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:registered,attended,cancelled',
        ]);

        $registration->update([
            'status' => $validated['status'],
            'attended_at' => $validated['status'] === 'attended' ? now() : null,
        ]);

        return back()->with('success', 'Status peserta berhasil diperbarui');
    }
}
