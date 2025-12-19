<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use App\Models\CertificateTemplate;
use App\Services\CertificateGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    public function index()
    {
        $templates = CertificateTemplate::latest()->get();
        return view('admin.certificates.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.certificates.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template_image' => 'required|image|mimes:png,jpg,jpeg|max:10240',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Upload template image
        $path = $request->file('template_image')->store('certificate-templates', 'public');

        $template = CertificateTemplate::create([
            'name' => $request->name,
            'template_image' => $path,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        // If set as active, deactivate others
        if ($template->is_active) {
            $template->setAsActive();
        }

        return redirect()->route('admin.certificate-templates.index')
            ->with('success', 'Template sertifikat berhasil ditambahkan');
    }

    public function edit(CertificateTemplate $certificateTemplate)
    {
        return view('admin.certificates.templates.edit', compact('certificateTemplate'));
    }

    public function update(Request $request, CertificateTemplate $certificateTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template_image' => 'nullable|image|mimes:png,jpg,jpeg|max:10240',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ];

        // Upload new template image if provided
        if ($request->hasFile('template_image')) {
            // Delete old image
            if ($certificateTemplate->template_image && Storage::disk('public')->exists($certificateTemplate->template_image)) {
                Storage::disk('public')->delete($certificateTemplate->template_image);
            }

            $data['template_image'] = $request->file('template_image')->store('certificate-templates', 'public');
        }

        $certificateTemplate->update($data);

        // If set as active, deactivate others
        if ($certificateTemplate->is_active) {
            $certificateTemplate->setAsActive();
        }

        return redirect()->route('admin.certificate-templates.index')
            ->with('success', 'Template sertifikat berhasil diperbarui');
    }

    public function destroy(CertificateTemplate $certificateTemplate)
    {
        // Delete template image
        if ($certificateTemplate->template_image && Storage::disk('public')->exists($certificateTemplate->template_image)) {
            Storage::disk('public')->delete($certificateTemplate->template_image);
        }

        $certificateTemplate->delete();

        return redirect()->route('admin.certificate-templates.index')
            ->with('success', 'Template sertifikat berhasil dihapus');
    }

    public function setActive(CertificateTemplate $certificateTemplate)
    {
        $certificateTemplate->setAsActive();

        return redirect()->route('admin.certificate-templates.index')
            ->with('success', 'Template berhasil diaktifkan');
    }
}
