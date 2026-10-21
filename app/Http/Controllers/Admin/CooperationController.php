<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CooperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cooperation::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $cooperations = $query->ordered()->paginate(20)->withQueryString();

        return view('admin.cooperations.index', compact('cooperations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cooperations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('cooperations/logos', 'public');
        }
        if ($request->hasFile('mou_file')) {
            $validated['mou_file'] = $request->file('mou_file')->store('cooperations/documents', 'public');
        }
        if ($request->hasFile('moa_file')) {
            $validated['moa_file'] = $request->file('moa_file')->store('cooperations/documents', 'public');
        }

        Cooperation::create($validated);

        return redirect()->route('admin.cooperations.index')
            ->with('success', 'Kerjasama berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cooperation $cooperation)
    {
        return view('admin.cooperations.edit', compact('cooperation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cooperation $cooperation)
    {
        $validated = $this->validateRequest($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['name'] !== $cooperation->name) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $cooperation->id);
        }

        foreach (['logo' => 'cooperations/logos', 'mou_file' => 'cooperations/documents', 'moa_file' => 'cooperations/documents'] as $field => $path) {
            if ($request->hasFile($field)) {
                if ($cooperation->$field && Storage::disk('public')->exists($cooperation->$field)) {
                    Storage::disk('public')->delete($cooperation->$field);
                }
                $validated[$field] = $request->file($field)->store($path, 'public');
            }
        }

        $cooperation->update($validated);

        return redirect()->route('admin.cooperations.index')
            ->with('success', 'Kerjasama berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cooperation $cooperation)
    {
        $cooperation->delete();

        return redirect()->route('admin.cooperations.index')
            ->with('success', 'Kerjasama berhasil dihapus!');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            'mou_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'mou_date' => 'nullable|date',
            'moa_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'moa_date' => 'nullable|date',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ], [
            'mou_file.mimes' => 'Dokumen MoU harus berupa PDF, JPG, atau PNG.',
            'moa_file.mimes' => 'Dokumen MoA harus berupa PDF, JPG, atau PNG.',
        ]);
    }

    /**
     * Generate slug unik dari nama (hindari bentrok, lengkapi -2, -3, dst).
     */
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (
            Cooperation::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
