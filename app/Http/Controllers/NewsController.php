<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()
            ->with(['category', 'user'])
            ->latest('published_at');

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $news = $query->paginate(12);
        
        $categories = Category::withCount([
            'news' => function ($query) {
                $query->published();
            }
        ])->get();
        
        $latestNews = News::published()
            ->latest('published_at')
            ->take(5)
            ->get();
        
        $totalNews = News::published()->count();

        return view('news.index', compact('news', 'categories', 'latestNews', 'totalNews'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)
            ->published()
            ->with(['category', 'user'])
            ->firstOrFail();

        // Increment views
        $news->increment('views');

        $relatedNews = News::where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Data untuk sidebar
        $latestNews = News::where('id', '!=', $news->id)
            ->published()
            ->latest('published_at')
            ->take(5)
            ->get();

        $popularNews = News::where('id', '!=', $news->id)
            ->published()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $categories = Category::withCount(['news' => function($query) {
                $query->published();
            }])
            ->orderBy('name')
            ->get();

        return view('news.show', compact('news', 'relatedNews', 'latestNews', 'popularNews', 'categories'));
    }
}
