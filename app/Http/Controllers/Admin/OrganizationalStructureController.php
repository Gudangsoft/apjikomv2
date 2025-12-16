<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructureController extends Controller
{
    public function index()
    {
        $structures = OrganizationalStructure::ordered()->get();
        return view('admin.organizational-structure.index', compact('structures'));
    }

    public function create()
    {
        return view('admin.organizational-structure.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'type' => 'required|in:leadership,division',
            'division_name' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('organizational-structure', 'public');
        }

        OrganizationalStructure::create($validated);

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', 'Struktur organisasi berhasil ditambahkan!');
    }

    public function edit(OrganizationalStructure $organizationalStructure)
    {
        return view('admin.organizational-structure.edit', compact('organizationalStructure'));
    }

    public function update(Request $request, OrganizationalStructure $organizationalStructure)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'type' => 'required|in:leadership,division',
            'division_name' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($organizationalStructure->photo && Storage::disk('public')->exists($organizationalStructure->photo)) {
                Storage::disk('public')->delete($organizationalStructure->photo);
            }
            $validated['photo'] = $request->file('photo')->store('organizational-structure', 'public');
        }

        $organizationalStructure->update($validated);

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', 'Struktur organisasi berhasil diperbarui!');
    }

    public function destroy(OrganizationalStructure $organizationalStructure)
    {
        // Delete photo
        if ($organizationalStructure->photo && Storage::disk('public')->exists($organizationalStructure->photo)) {
            Storage::disk('public')->delete($organizationalStructure->photo);
        }

        $organizationalStructure->delete();

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', 'Struktur organisasi berhasil dihapus!');
    }
}
