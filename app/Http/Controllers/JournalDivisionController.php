<?php

namespace App\Http\Controllers;

use App\Models\JournalDivision;
use Illuminate\Http\Request;

class JournalDivisionController extends Controller
{
    /**
     * Display a listing of the resource for public view.
     */
    public function publicIndex()
    {
        $divisions = JournalDivision::where('is_active', true)
            ->orderBy('order')
            ->get();
        return view('journal-divisions.index', compact('divisions'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = JournalDivision::orderBy('order')->get();
        return view('admin.journal-divisions.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.journal-divisions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'division' => 'required|string|max:255',
            'main_focus' => 'required|string|max:255',
            'journal_potential' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('journal-divisions', 'public');
        }

        JournalDivision::create($validated);

        return redirect()->route('admin.journal-divisions.index')
            ->with('success', 'Divisi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JournalDivision $journalDivision)
    {
        return view('admin.journal-divisions.show', compact('journalDivision'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JournalDivision $journalDivision)
    {
        return view('admin.journal-divisions.edit', compact('journalDivision'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JournalDivision $journalDivision)
    {
        $validated = $request->validate([
            'division' => 'required|string|max:255',
            'main_focus' => 'required|string|max:255',
            'journal_potential' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($journalDivision->cover) {
                \Storage::disk('public')->delete($journalDivision->cover);
            }
            $validated['cover'] = $request->file('cover')->store('journal-divisions', 'public');
        }

        $journalDivision->update($validated);

        return redirect()->route('admin.journal-divisions.index')
            ->with('success', 'Divisi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JournalDivision $journalDivision)
    {
        // Delete cover if exists
        if ($journalDivision->cover) {
            \Storage::disk('public')->delete($journalDivision->cover);
        }
        
        $journalDivision->delete();

        return redirect()->route('admin.journal-divisions.index')
            ->with('success', 'Divisi berhasil dihapus');
    }
}
