<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceManagementController extends Controller
{
    public function index()
    {
        $services = Service::ordered()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'color' => 'required|in:blue,purple,green,orange,red,teal,indigo',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'cta_text' => 'nullable|string|max:100',
            'cta_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Filter empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features']);
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'color' => 'required|in:blue,purple,green,orange,red,teal,indigo',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'cta_text' => 'nullable|string|max:100',
            'cta_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Filter empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features']);
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
