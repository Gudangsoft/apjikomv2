<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::published()
            ->with('category')
            ->upcoming();

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $upcomingEvents = $query->orderBy('event_date', 'asc')
            ->paginate(12);

        $pastEvents = Event::published()
            ->with('category')
            ->where('event_date', '<', now()->format('Y-m-d'))
            ->orderBy('event_date', 'desc')
            ->take(6)
            ->get();

        $categories = Category::has('events')->orderBy('name')->get();

        return view('events.index', compact('upcomingEvents', 'pastEvents', 'categories'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->with('category')
            ->published()
            ->firstOrFail();

        $relatedEvents = Event::where('id', '!=', $event->id)
            ->published()
            ->upcoming()
            ->with('category')
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }
}
