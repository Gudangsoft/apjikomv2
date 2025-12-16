<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $partners = Partner::ordered()->get();
        } catch (\Exception $e) {
            // If table doesn't exist, return empty collection
            $partners = collect();
        }
        
        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            'url' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Upload logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            'url' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Upload logo baru jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($partner->logo && Storage::exists($partner->logo)) {
                Storage::delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil dihapus!');
    }

    /**
     * Update order via AJAX drag & drop
     */
    public function updateOrder(Request $request)
    {
        $updates = $request->input('updates', []);

        foreach ($updates as $update) {
            Partner::where('id', $update['id'])->update(['order' => $update['order']]);
        }

        return response()->json(['success' => true]);
    }
}
