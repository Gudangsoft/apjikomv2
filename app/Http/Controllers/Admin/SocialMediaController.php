<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socialMedia = SocialMedia::orderBy('order')->get();
        return view('admin.social-media.index', compact('socialMedia'));
    }

    public function create()
    {
        return view('admin.social-media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'icon_class' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('icon');
        $data['is_active'] = $request->has('is_active');

        // Upload icon if provided
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('social-media-icons', 'public');
        }

        SocialMedia::create($data);

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Media sosial berhasil ditambahkan');
    }

    public function edit(SocialMedia $socialMedium)
    {
        return view('admin.social-media.edit', compact('socialMedium'));
    }

    public function update(Request $request, SocialMedia $socialMedium)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'icon_class' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('icon');
        $data['is_active'] = $request->has('is_active');

        // Upload new icon if provided
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($socialMedium->icon && Storage::disk('public')->exists($socialMedium->icon)) {
                Storage::disk('public')->delete($socialMedium->icon);
            }
            $data['icon'] = $request->file('icon')->store('social-media-icons', 'public');
        }

        $socialMedium->update($data);

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Media sosial berhasil diperbarui');
    }

    public function destroy(SocialMedia $socialMedium)
    {
        // Delete icon if exists
        if ($socialMedium->icon && Storage::disk('public')->exists($socialMedium->icon)) {
            Storage::disk('public')->delete($socialMedium->icon);
        }

        $socialMedium->delete();

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Media sosial berhasil dihapus');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer',
        ]);

        foreach ($request->orders as $id => $order) {
            SocialMedia::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }
}
