<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberCardTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberCardTemplateController extends Controller
{
    public function index()
    {
        $templates = MemberCardTemplate::latest()->get();
        return view('admin.member-card-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.member-card-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_image' => 'required|image|mimes:jpeg,jpg,png|max:5120', // 5MB max
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Upload template image
        if ($request->hasFile('template_image')) {
            $validated['template_image'] = $request->file('template_image')->store('card-templates', 'public');
        }

        $template = MemberCardTemplate::create($validated);

        // Set as active if checked
        if ($request->boolean('is_active')) {
            $template->setAsActive();
        }

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template kartu anggota berhasil ditambahkan!');
    }

    public function edit(MemberCardTemplate $cardTemplate)
    {
        return view('admin.member-card-templates.edit', compact('cardTemplate'));
    }

    public function update(Request $request, MemberCardTemplate $cardTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Upload new template image if provided
        if ($request->hasFile('template_image')) {
            // Delete old image
            if ($cardTemplate->template_image && Storage::disk('public')->exists($cardTemplate->template_image)) {
                Storage::disk('public')->delete($cardTemplate->template_image);
            }
            $validated['template_image'] = $request->file('template_image')->store('card-templates', 'public');
        }

        $cardTemplate->update($validated);

        // Set as active if checked
        if ($request->boolean('is_active')) {
            $cardTemplate->setAsActive();
        }

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template kartu anggota berhasil diupdate!');
    }

    public function destroy(MemberCardTemplate $cardTemplate)
    {
        // Don't allow deleting active template
        if ($cardTemplate->is_active) {
            return redirect()->route('admin.card-templates.index')
                ->with('error', 'Tidak dapat menghapus template yang sedang aktif!');
        }

        // Delete image
        if ($cardTemplate->template_image && Storage::disk('public')->exists($cardTemplate->template_image)) {
            Storage::disk('public')->delete($cardTemplate->template_image);
        }

        $cardTemplate->delete();

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template kartu anggota berhasil dihapus!');
    }

    public function activate(MemberCardTemplate $cardTemplate)
    {
        $cardTemplate->setAsActive();

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template berhasil diaktifkan!');
    }
}
