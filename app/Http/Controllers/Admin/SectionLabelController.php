<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SectionLabelController extends Controller
{
    /**
     * Display a listing of the section labels.
     */
    public function index()
    {
        $labels = Setting::where('group', 'section_labels')
            ->orderBy('key')
            ->get();
        
        return view('admin.section-labels.index', compact('labels'));
    }

    /**
     * Update the specified section label.
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        
        $validated = $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $setting->update($validated);

        return redirect()->route('admin.section-labels.index')
            ->with('success', 'Label section berhasil diperbarui!');
    }

    /**
     * Bulk update section labels.
     */
    public function bulkUpdate(Request $request)
    {
        $labels = $request->input('labels', []);

        foreach ($labels as $id => $value) {
            Setting::where('id', $id)->update(['value' => $value]);
        }

        return redirect()->route('admin.section-labels.index')
            ->with('success', 'Semua label section berhasil diperbarui!');
    }
}
