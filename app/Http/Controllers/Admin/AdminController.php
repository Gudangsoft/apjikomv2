<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\Member;
use App\Models\Category;
use App\Models\Registration;
use App\Models\Journal;
use App\Models\EventRegistration;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Basic Stats
        $stats = [
            'total_news' => News::count(),
            'published_news' => News::where('is_published', true)->count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('event_date', '>=', now())->count(),
            'total_members' => Member::count(),
            'pending_members' => Member::where('status', 'pending')->count(),
            'active_members' => Member::where('status', 'active')->count(),
            'total_categories' => Category::count(),
            'total_registrations' => Registration::count(),
            'pending_registrations' => Registration::where('status', 'pending')->count(),
            'approved_registrations' => Registration::where('status', 'approved')->count(),
            'total_journals' => Journal::count(),
            'total_event_registrations' => EventRegistration::count(),
        ];

        // Member Growth Chart Data (Last 6 months)
        $memberGrowth = Member::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function($item) {
            return [Carbon::parse($item->month)->format('M Y') => $item->count];
        });

        // Member Status Distribution
        $membersByStatus = Member::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Member Type Distribution
        $membersByType = Member::select('member_type', DB::raw('COUNT(*) as count'))
            ->groupBy('member_type')
            ->pluck('count', 'member_type');

        // Top 5 Institutions
        $topInstitutions = Member::select('institution_name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('institution_name')
            ->where('institution_name', '!=', '')
            ->groupBy('institution_name')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // Monthly Registration Trend (Last 6 months)
        $registrationTrend = Registration::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function($item) {
            return [Carbon::parse($item->month)->format('M Y') => $item->count];
        });

        // Event Registrations by Status
        $eventRegsByStatus = EventRegistration::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Recent Activities
        $recent_news = News::with(['category'])
            ->latest()
            ->take(5)
            ->get();

        $recent_events = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(6)
            ->get();

        $pending_members = Member::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $pending_registrations = Registration::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Recent Member Registrations (Last 7 days)
        $recentMemberCount = Member::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        
        // Cards Pending Generation
        $cardsPending = Member::where('card_requested', true)
            ->whereNull('member_card')
            ->count();
        
        // Satisfaction Rate from settings
        $satisfactionRate = Setting::get('satisfaction_rate', 98);

        return view('admin.dashboard', compact(
            'stats',
            'memberGrowth',
            'membersByStatus',
            'membersByType',
            'topInstitutions',
            'registrationTrend',
            'eventRegsByStatus',
            'recent_news',
            'recent_events',
            'pending_members',
            'pending_registrations',
            'recentMemberCount',
            'cardsPending',
            'satisfactionRate'
        ));
    }
}
