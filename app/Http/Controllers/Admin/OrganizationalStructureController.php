<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalDivision;
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
        $divisions = OrganizationalDivision::active()->ordered()->get();
        return view('admin.organizational-structure.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'members'                  => 'required|array|min:1',
            'members.*.type'           => 'required|in:leadership,division',
            'members.*.position'       => 'required|string|max:255',
            'members.*.name'           => 'required|string|max:255',
            'members.*.institusi'      => 'nullable|string|max:255',
            'members.*.division_name'  => 'nullable|string|max:255',
            'members.*.order'          => 'required|integer|min:0',
            'members.*.description'    => 'nullable|string',
        ]);

        $saved = 0;
        foreach ($request->input('members') as $i => $member) {
            $data = [
                'type'          => $member['type'],
                'position'      => $member['position'],
                'name'          => $member['name'],
                'institusi'     => $member['institusi'] ?? null,
                'division_name' => $member['division_name'] ?? null,
                'order'         => (int) ($member['order'] ?? 0),
                'description'   => $member['description'] ?? null,
                'is_active'     => isset($member['is_active']),
            ];

            if ($request->hasFile("photos.$i")) {
                $data['photo'] = $request->file("photos.$i")->store('organizational-structure', 'public');
            }

            OrganizationalStructure::create($data);
            $saved++;
        }

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', $saved . ' pengurus berhasil ditambahkan!');
    }

    public function edit(OrganizationalStructure $organizationalStructure)
    {
        $divisions = OrganizationalDivision::active()->ordered()->get();
        return view('admin.organizational-structure.edit', compact('organizationalStructure', 'divisions'));
    }

    public function update(Request $request, OrganizationalStructure $organizationalStructure)
    {
        $validated = $request->validate([
            'position'      => 'required|string|max:255',
            'name'          => 'required|string|max:255',
            'institusi'     => 'nullable|string|max:255',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'description'   => 'nullable|string',
            'type'          => 'required|in:leadership,division',
            'division_name' => 'nullable|string|max:255',
            'order'         => 'required|integer|min:0',
        ]);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($organizationalStructure->photo && Storage::disk('public')->exists($organizationalStructure->photo)) {
                Storage::disk('public')->delete($organizationalStructure->photo);
            }
            $validated['photo'] = $request->file('photo')->store('organizational-structure', 'public');
        }

        $organizationalStructure->update($validated);

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', 'Pengurus berhasil diperbarui!');
    }

    public function destroy(OrganizationalStructure $organizationalStructure)
    {
        if ($organizationalStructure->photo && Storage::disk('public')->exists($organizationalStructure->photo)) {
            Storage::disk('public')->delete($organizationalStructure->photo);
        }

        $organizationalStructure->delete();

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', 'Pengurus berhasil dihapus!');
    }
}
