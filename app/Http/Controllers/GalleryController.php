<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $featuredGalleries = Gallery::with('event')
                                    ->featured()
                                    ->ordered()
                                    ->take(6)
                                    ->get();

        $query = Gallery::with('event')
                        ->where('is_featured', false)
                        ->ordered();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $galleries = $query->paginate(12);

        return view('gallery.index', compact('galleries', 'featuredGalleries'));
    }
}
