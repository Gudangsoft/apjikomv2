<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        $query = Institution::where('is_active', true)
                           ->withCount('members');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by province
        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        $institutions = $query->orderBy('name')->paginate(12);

        // Get statistics
        $universities = Institution::where('is_active', true)->where('type', 'Universitas')->count();
        $institutes = Institution::where('is_active', true)->where('type', 'Institut')->count();
        $others = Institution::where('is_active', true)->whereNotIn('type', ['Universitas', 'Institut'])->count();

        // Get all provinces for filter
        $provinces = Institution::where('is_active', true)
                                ->distinct()
                                ->pluck('province')
                                ->sort()
                                ->values();

        return view('institutions.index', compact('institutions', 'universities', 'institutes', 'others', 'provinces'));
    }
}
