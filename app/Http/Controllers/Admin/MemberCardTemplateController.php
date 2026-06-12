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
        $availableFonts   = $this->getAvailableFonts();
        $defaultSettings  = MemberCardTemplate::defaultFontSettings();
        return view('admin.member-card-templates.create', compact('availableFonts', 'defaultSettings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                        => 'required|string|max:255',
            'template_image'              => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'description'                 => 'nullable|string',
            'is_active'                   => 'boolean',
            'font_settings'               => 'nullable|array',
            'font_settings.font_bold'     => 'nullable|string|max:100',
            'font_settings.font_regular'  => 'nullable|string|max:100',
            'font_settings.header_font_size' => 'nullable|integer|min:10|max:60',
            'font_settings.header_bold'   => 'nullable',
            'font_settings.header_y'      => 'nullable|integer|min:100|max:800',
            'font_settings.label_font_size'  => 'nullable|integer|min:8|max:40',
            'font_settings.label_bold'    => 'nullable',
            'font_settings.value_font_size'  => 'nullable|integer|min:8|max:40',
            'font_settings.value_bold'    => 'nullable',
            'font_settings.line_spacing'  => 'nullable|integer|min:16|max:80',
            'font_settings.label_width'   => 'nullable|integer|min:50|max:250',
            'font_settings.label_gap'     => 'nullable|integer|min:5|max:50',
            'font_settings.data_start_x'  => 'nullable|integer|min:0|max:1200',
            'font_settings.data_start_y'  => 'nullable|integer|min:100|max:1000',
            'font_settings.font_color'    => 'nullable|string|max:10',
        ]);

        if ($request->hasFile('template_image')) {
            $validated['template_image'] = $request->file('template_image')->store('card-templates', 'public');
        }

        // Normalize booleans in font_settings
        $fs = $validated['font_settings'] ?? [];
        $fs['header_bold'] = $request->boolean('font_settings.header_bold');
        $fs['label_bold']  = $request->boolean('font_settings.label_bold');
        $fs['value_bold']  = $request->boolean('font_settings.value_bold');
        $validated['font_settings'] = $fs;

        $template = MemberCardTemplate::create($validated);

        if ($request->boolean('is_active')) {
            $template->setAsActive();
        }

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template kartu anggota berhasil ditambahkan!');
    }

    public function edit(MemberCardTemplate $cardTemplate)
    {
        $availableFonts  = $this->getAvailableFonts();
        $defaultSettings = MemberCardTemplate::defaultFontSettings();
        $fontSettings    = $cardTemplate->mergedFontSettings();
        return view('admin.member-card-templates.edit', compact('cardTemplate', 'availableFonts', 'defaultSettings', 'fontSettings'));
    }

    public function update(Request $request, MemberCardTemplate $cardTemplate)
    {
        $validated = $request->validate([
            'name'                        => 'required|string|max:255',
            'template_image'              => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'description'                 => 'nullable|string',
            'is_active'                   => 'boolean',
            'font_settings'               => 'nullable|array',
            'font_settings.font_bold'     => 'nullable|string|max:100',
            'font_settings.font_regular'  => 'nullable|string|max:100',
            'font_settings.header_font_size' => 'nullable|integer|min:10|max:60',
            'font_settings.header_bold'   => 'nullable',
            'font_settings.header_y'      => 'nullable|integer|min:100|max:800',
            'font_settings.label_font_size'  => 'nullable|integer|min:8|max:40',
            'font_settings.label_bold'    => 'nullable',
            'font_settings.value_font_size'  => 'nullable|integer|min:8|max:40',
            'font_settings.value_bold'    => 'nullable',
            'font_settings.line_spacing'  => 'nullable|integer|min:16|max:80',
            'font_settings.label_width'   => 'nullable|integer|min:50|max:250',
            'font_settings.label_gap'     => 'nullable|integer|min:5|max:50',
            'font_settings.data_start_x'  => 'nullable|integer|min:0|max:1200',
            'font_settings.data_start_y'  => 'nullable|integer|min:100|max:1000',
            'font_settings.font_color'    => 'nullable|string|max:10',
        ]);

        if ($request->hasFile('template_image')) {
            if ($cardTemplate->template_image && Storage::disk('public')->exists($cardTemplate->template_image)) {
                Storage::disk('public')->delete($cardTemplate->template_image);
            }
            $validated['template_image'] = $request->file('template_image')->store('card-templates', 'public');
        }

        $fs = $validated['font_settings'] ?? [];
        $fs['header_bold'] = $request->boolean('font_settings.header_bold');
        $fs['label_bold']  = $request->boolean('font_settings.label_bold');
        $fs['value_bold']  = $request->boolean('font_settings.value_bold');
        $validated['font_settings'] = $fs;

        $cardTemplate->update($validated);

        if ($request->boolean('is_active')) {
            $cardTemplate->setAsActive();
        }

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template kartu anggota berhasil diupdate!');
    }

    public function destroy(MemberCardTemplate $cardTemplate)
    {
        if ($cardTemplate->is_active) {
            return redirect()->route('admin.card-templates.index')
                ->with('error', 'Tidak dapat menghapus template yang sedang aktif!');
        }

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

    private function getAvailableFonts(): array
    {
        $fontsPath = storage_path('fonts');
        $fonts = [];
        if (is_dir($fontsPath)) {
            foreach (glob($fontsPath . '/*.{ttf,TTF,otf,OTF}', GLOB_BRACE) as $file) {
                $fonts[] = basename($file);
            }
        }
        sort($fonts);
        return $fonts;
    }
}
