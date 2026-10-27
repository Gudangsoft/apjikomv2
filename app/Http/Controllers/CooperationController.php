<?php

namespace App\Http\Controllers;

use App\Models\Cooperation;
use Illuminate\Http\Request;

class CooperationController extends Controller
{
    public function index(Request $request)
    {
        $query = Cooperation::active()->withCount('photos')->with(['photos' => function ($q) {
            $q->ordered()->limit(1);
        }]);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $cooperations = $query->ordered()->paginate(12)->withQueryString();

        return view('cooperation.index', compact('cooperations'));
    }

    public function show(Cooperation $cooperation)
    {
        abort_unless($cooperation->is_active, 404);

        $cooperation->load(['photos' => function ($q) {
            $q->ordered();
        }]);

        return view('cooperation.show', compact('cooperation'));
    }
}
