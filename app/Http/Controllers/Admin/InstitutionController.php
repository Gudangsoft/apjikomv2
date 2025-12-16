<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        $query = Institution::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $institutions = $query->withCount('members')
                             ->latest()
                             ->paginate(15);

        return view('admin.institutions.index', compact('institutions'));
    }

    public function create()
    {
        return view('admin.institutions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'joined_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('institutions', 'public');
        }

        Institution::create($validated);

        return redirect()->route('admin.institutions.index')
                        ->with('success', 'Instansi berhasil ditambahkan.');
    }

    public function show(Institution $institution)
    {
        $institution->load(['members' => function($query) {
            $query->with('user')->latest();
        }]);

        return view('admin.institutions.show', compact('institution'));
    }

    public function edit(Institution $institution)
    {
        return view('admin.institutions.edit', compact('institution'));
    }

    public function update(Request $request, Institution $institution)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'joined_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($institution->logo) {
                Storage::disk('public')->delete($institution->logo);
            }
            $validated['logo'] = $request->file('logo')->store('institutions', 'public');
        }

        $institution->update($validated);

        return redirect()->route('admin.institutions.index')
                        ->with('success', 'Instansi berhasil diperbarui.');
    }

    public function destroy(Institution $institution)
    {
        // Delete logo
        if ($institution->logo) {
            Storage::disk('public')->delete($institution->logo);
        }

        $institution->delete();

        return redirect()->route('admin.institutions.index')
                        ->with('success', 'Instansi berhasil dihapus.');
    }
}
