<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\Registration;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Check if sliders table exists
        try {
            $sliders = Slider::active()->ordered()->get();
        } catch (\Exception $e) {
            $sliders = collect(); // Empty collection if table doesn't exist
        }
        
        $featuredNews = News::published()
            ->featured()
            ->with(['category', 'user'])
            ->latest('published_at')
            ->take(3)
            ->get();

        $upcomingEvents = Event::published()
            ->upcoming()
            ->with('category')
            ->orderBy('event_date', 'asc')
            ->take(4)
            ->get();

        // Load featured events for slider
        $featuredEvents = Event::published()
            ->featured()
            ->orderBy('event_date', 'desc')
            ->get();

        // Load partners
        try {
            $partners = Partner::active()->ordered()->get();
        } catch (\Exception $e) {
            $partners = collect(); // Empty collection if table doesn't exist
        }

        // Load about section settings
        $aboutImage = setting('about_image');
        $aboutDescription = setting('about_description');
        $aboutStat1Number = setting('about_stat1_number');
        $aboutStat1Label = setting('about_stat1_label');
        $aboutStat2Number = setting('about_stat2_number');
        $aboutStat2Label = setting('about_stat2_label');
        $aboutFeature1Title = setting('about_feature1_title');
        $aboutFeature1Desc = setting('about_feature1_desc');
        $aboutFeature2Title = setting('about_feature2_title');
        $aboutFeature2Desc = setting('about_feature2_desc');
        $aboutFeature3Title = setting('about_feature3_title');
        $aboutFeature3Desc = setting('about_feature3_desc');
        $aboutCtaLabel = setting('about_cta_label');
        $aboutCtaLink = setting('about_cta_link');

        // Load FAQs for homepage
        $faqs = Faq::active()
            ->ordered()
            ->take(6)
            ->get();

        // Load Testimonials for homepage
        $testimonials = Testimonial::with('member.user')
            ->active()
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Load Gallery for homepage
        $galleries = Gallery::with('event')
            ->ordered()
            ->take(8)
            ->get();

        // Calculate real statistics
        $totalOrganizationMembers = Member::where('member_type', 'institution')->count();
        $totalIndividualMembers = Member::where('member_type', 'individual')->count();
        $totalActiveMembers = Member::whereIn('status', ['active', 'approved'])->count();
        
        // Calculate satisfaction rate from testimonials (average rating if available)
        $satisfactionRate = Testimonial::where('is_active', true)
            ->avg('rating'); // Assuming testimonials have a rating field
        if (!$satisfactionRate) {
            $satisfactionRate = setting('satisfaction_rate', 98); // Fallback to setting or 98
        } else {
            $satisfactionRate = round(($satisfactionRate / 5) * 100); // Convert 1-5 rating to percentage
        }

        return view('home', compact(
            'sliders', 
            'featuredNews', 
            'upcomingEvents', 
            'featuredEvents', 
            'partners',
            'aboutImage',
            'aboutDescription',
            'aboutStat1Number',
            'aboutStat1Label',
            'aboutStat2Number',
            'aboutStat2Label',
            'aboutFeature1Title',
            'aboutFeature1Desc',
            'aboutFeature2Title',
            'aboutFeature2Desc',
            'aboutFeature3Title',
            'aboutFeature3Desc',
            'aboutCtaLabel',
            'aboutCtaLink',
            'faqs',
            'testimonials',
            'galleries',
            'totalOrganizationMembers',
            'totalIndividualMembers',
            'totalActiveMembers',
            'satisfactionRate'
        ));
    }
}
