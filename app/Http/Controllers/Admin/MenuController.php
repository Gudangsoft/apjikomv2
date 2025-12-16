<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with(['parent', 'children', 'page'])->topLevel()->ordered()->get();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = Page::published()->ordered()->get();
        $parentMenus = Menu::with('children')->topLevel()->ordered()->get();
        return view('admin.menus.create', compact('pages', 'parentMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'page_id' => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:menus,id',
            'type' => 'required|in:link,page,dropdown',
            'target' => 'required|in:_self,_blank',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Validate max 3 levels
        if ($validated['parent_id']) {
            $parent = Menu::find($validated['parent_id']);
            if ($parent && $parent->getLevel() >= 2) {
                return back()->withErrors(['parent_id' => 'Menu hanya mendukung maksimal 3 tingkat!'])->withInput();
            }
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? Menu::where('parent_id', $validated['parent_id'])->max('order') + 1;

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $pages = Page::published()->ordered()->get();
        $parentMenus = Menu::with('children')
            ->where('id', '!=', $menu->id)
            ->topLevel()
            ->ordered()
            ->get();
        
        return view('admin.menus.edit', compact('menu', 'pages', 'parentMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'page_id' => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:menus,id',
            'type' => 'required|in:link,page,dropdown',
            'target' => 'required|in:_self,_blank',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Validate max 3 levels
        if ($validated['parent_id']) {
            $parent = Menu::find($validated['parent_id']);
            if ($parent && $parent->getLevel() >= 2) {
                return back()->withErrors(['parent_id' => 'Menu hanya mendukung maksimal 3 tingkat!'])->withInput();
            }
            
            // Prevent setting itself or its descendants as parent
            if ($validated['parent_id'] == $menu->id) {
                return back()->withErrors(['parent_id' => 'Menu tidak bisa menjadi parent dari dirinya sendiri!'])->withInput();
            }
        }

        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Update menu order via drag and drop
     */
    public function updateOrder(Request $request)
    {
        $updates = $request->input('updates', []);
        
        foreach ($updates as $update) {
            Menu::where('id', $update['id'])
                ->update(['order' => $update['order']]);
        }
        
        return response()->json(['success' => true]);
    }
}

