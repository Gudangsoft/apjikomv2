<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalDivision;
use Illuminate\Http\Request;

class OrganizationalDivisionController extends Controller
{
    public function index()
    {
        $divisions = OrganizationalDivision::ordered()->get();
        return view('admin.organizational-divisions.index', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:organizational_divisions,name',
            'description' => 'nullable|string|max:255',
            'order'       => 'required|integer|min:0',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);

        OrganizationalDivision::create($validated);

        return redirect()->route('admin.organizational-divisions.index')
            ->with('success', 'Bidang berhasil ditambahkan!');
    }

    public function update(Request $request, OrganizationalDivision $organizationalDivision)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:organizational_divisions,name,' . $organizationalDivision->id,
            'description' => 'nullable|string|max:255',
            'order'       => 'required|integer|min:0',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);

        $organizationalDivision->update($validated);

        return redirect()->route('admin.organizational-divisions.index')
            ->with('success', 'Bidang berhasil diperbarui!');
    }

    public function destroy(OrganizationalDivision $organizationalDivision)
    {
        $organizationalDivision->delete();

        return redirect()->route('admin.organizational-divisions.index')
            ->with('success', 'Bidang berhasil dihapus!');
    }
}
