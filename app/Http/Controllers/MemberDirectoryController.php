<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('user')
            ->where('show_in_directory', true)
            ->where('is_verified', true)
            ->where('status', 'active');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('institution_name', 'like', "%{$search}%")
                ->orWhere('position', 'like', "%{$search}%")
                ->orWhere('expertise', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type') && $request->type != 'all') {
            $query->where('member_type', $request->type);
        }

        // Filter by institution
        if ($request->filled('institution')) {
            $query->where('institution_name', 'like', "%{$request->institution}%");
        }

        // Sort
        $sortBy = $request->get('sort', 'name');
        switch ($sortBy) {
            case 'name':
                $query->join('users', 'members.user_id', '=', 'users.id')
                      ->orderBy('users.name', 'asc')
                      ->select('members.*');
                break;
            case 'newest':
                $query->orderBy('join_date', 'desc');
                break;
            case 'institution':
                $query->orderBy('institution_name', 'asc');
                break;
        }

        $members = $query->paginate(12)->withQueryString();

        // Get unique institutions for filter
        $institutions = Member::where('show_in_directory', true)
            ->where('status', 'active')
            ->whereNotNull('institution_name')
            ->distinct()
            ->pluck('institution_name')
            ->filter()
            ->sort()
            ->values();

        // Statistics
        $statistics = [
            'total' => Member::where('show_in_directory', true)->where('status', 'active')->count(),
            'individual' => Member::where('show_in_directory', true)->where('status', 'active')->where('member_type', 'individual')->count(),
            'institution' => Member::where('show_in_directory', true)->where('status', 'active')->where('member_type', 'institution')->count(),
        ];

        return view('directory.index', compact('members', 'institutions', 'statistics'));
    }

    public function show(Member $member)
    {
        // Check if member allows to be shown in directory
        if (!$member->show_in_directory || $member->status != 'active') {
            abort(404);
        }

        $member->load('user');

        return view('directory.show', compact('member'));
    }
}
