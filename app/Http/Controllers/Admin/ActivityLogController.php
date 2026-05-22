<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs  = $query->paginate(30)->withQueryString();
        $types = ActivityLog::select('type')->distinct()->orderBy('type')->pluck('type');

        return view('admin.activity-logs.index', compact('logs', 'types'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();
        return back()->with('success', 'Log berhasil dihapus.');
    }

    public function clear(Request $request)
    {
        $request->validate([
            'older_than_days' => 'required|integer|min:1|max:365',
        ]);

        $count = ActivityLog::where('created_at', '<', now()->subDays($request->older_than_days))->count();
        ActivityLog::where('created_at', '<', now()->subDays($request->older_than_days))->delete();

        return back()->with('success', "{$count} log lama berhasil dihapus.");
    }
}
