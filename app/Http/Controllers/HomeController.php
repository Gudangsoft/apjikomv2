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
        $aboutImage = Setting::where('group', 'general')
            ->where('key', 'about_image')
            ->value('value');
        
        $aboutDescription = Setting::where('group', 'general')
            ->where('key', 'about_description')
            ->value('value');
        
        $aboutStat1Number = Setting::where('group', 'general')
            ->where('key', 'about_stat1_number')
            ->value('value');
        
        $aboutStat1Label = Setting::where('group', 'general')
            ->where('key', 'about_stat1_label')
            ->value('value');
        
        $aboutStat2Number = Setting::where('group', 'general')
            ->where('key', 'about_stat2_number')
            ->value('value');
        
        $aboutStat2Label = Setting::where('group', 'general')
            ->where('key', 'about_stat2_label')
            ->value('value');
        
        $aboutFeature1Title = Setting::where('group', 'general')
            ->where('key', 'about_feature1_title')
            ->value('value');
        
        $aboutFeature1Desc = Setting::where('group', 'general')
            ->where('key', 'about_feature1_desc')
            ->value('value');
        
        $aboutFeature2Title = Setting::where('group', 'general')
            ->where('key', 'about_feature2_title')
            ->value('value');
        
        $aboutFeature2Desc = Setting::where('group', 'general')
            ->where('key', 'about_feature2_desc')
            ->value('value');
        
        $aboutFeature3Title = Setting::where('group', 'general')
            ->where('key', 'about_feature3_title')
            ->value('value');
        
        $aboutFeature3Desc = Setting::where('group', 'general')
            ->where('key', 'about_feature3_desc')
            ->value('value');
        
        $aboutCtaLabel = Setting::where('group', 'general')
            ->where('key', 'about_cta_label')
            ->value('value');
        
        $aboutCtaLink = Setting::where('group', 'general')
            ->where('key', 'about_cta_link')
            ->value('value');

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
            'galleries'
        ));
    }
}
