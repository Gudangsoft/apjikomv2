<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $featuredTestimonials = Testimonial::active()
                               ->featured()
                               ->with('member')
                               ->latest()
                               ->limit(6)
                               ->get();

        $testimonials = Testimonial::active()
                                   ->with('member')
                                   ->where('is_featured', false)
                                   ->latest()
                                   ->paginate(9);

        return view('testimonials.index', compact('testimonials', 'featuredTestimonials'));
    }
}
