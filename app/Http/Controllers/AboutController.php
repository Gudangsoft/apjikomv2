<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('about.index');
    }

    public function structure()
    {
        $executives = OrganizationalStructure::active()
            ->executive()
            ->ordered()
            ->get();

        $leadership = OrganizationalStructure::active()
            ->leadership()
            ->ordered()
            ->get();

        $divisions = OrganizationalStructure::active()
            ->division()
            ->ordered()
            ->get();

        return view('about.structure', compact('executives', 'leadership', 'divisions'));
    }
}
