<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('member.user')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $members = Member::with('user')
            ->whereHas('user')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.testimonials.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan');
    }

    public function edit(Testimonial $testimonial)
    {
        $members = Member::with('user')
            ->whereHas('user')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.testimonials.edit', compact('testimonial', 'members'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui');
    }

    public function destroy(Testimonial $testimonial)
    {
        // Delete photo if exists
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }
        
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus');
    }
}
