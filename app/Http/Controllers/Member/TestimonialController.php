<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('member.profile')->with('error', 'Anda harus melengkapi profil member terlebih dahulu');
        }

        $testimonials = Testimonial::where('member_id', $member->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('member.testimonials.index', compact('testimonials', 'member'));
    }

    public function create()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('member.profile')->with('error', 'Anda harus melengkapi profil member terlebih dahulu');
        }

        return view('member.testimonials.create', compact('member'));
    }

    public function store(Request $request)
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('member.profile')->with('error', 'Anda harus melengkapi profil member terlebih dahulu');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:20',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'content.required' => 'Testimoni harus diisi',
            'content.min' => 'Testimoni minimal 20 karakter',
            'rating.required' => 'Rating harus dipilih',
            'rating.min' => 'Rating minimal 1',
            'rating.max' => 'Rating maksimal 5',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus JPEG, PNG, atau JPG',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $validated['member_id'] = $member->id;
        $validated['is_active'] = false; // Needs admin approval
        $validated['is_featured'] = false;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        Testimonial::create($validated);

        return redirect()->route('member.testimonials.index')
            ->with('success', 'Testimoni berhasil dikirim dan menunggu persetujuan admin');
    }

    public function edit(Testimonial $testimonial)
    {
        $member = auth()->user()->member;
        
        if (!$member || $testimonial->member_id !== $member->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit testimoni ini');
        }

        return view('member.testimonials.edit', compact('testimonial', 'member'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $member = auth()->user()->member;
        
        if (!$member || $testimonial->member_id !== $member->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah testimoni ini');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:20',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'content.required' => 'Testimoni harus diisi',
            'content.min' => 'Testimoni minimal 20 karakter',
            'rating.required' => 'Rating harus dipilih',
            'rating.min' => 'Rating minimal 1',
            'rating.max' => 'Rating maksimal 5',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus JPEG, PNG, atau JPG',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // If testimony was previously active, set to inactive for re-approval
        if ($testimonial->is_active) {
            $validated['is_active'] = false;
        }

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $testimonial->update($validated);

        return redirect()->route('member.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui dan menunggu persetujuan admin');
    }

    public function destroy(Testimonial $testimonial)
    {
        $member = auth()->user()->member;
        
        if (!$member || $testimonial->member_id !== $member->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus testimoni ini');
        }

        // Delete photo if exists
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()->route('member.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus');
    }
}
