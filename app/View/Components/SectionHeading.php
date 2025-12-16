<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Setting;

class SectionHeading extends Component
{
    public $title;
    public $subtitle;
    public $align;
    public $darkMode;

    /**
     * Create a new component instance.
     */
    public function __construct($settingKey = null, $title = null, $subtitle = null, $align = 'left', $darkMode = false)
    {
        // If settingKey is provided, get from database
        if ($settingKey) {
            $this->title = Setting::get($settingKey, $title ?? '');
            
            // Check for subtitle setting key
            $subtitleKey = $settingKey . '_subtitle';
            $this->subtitle = Setting::get($subtitleKey, $subtitle);
        } else {
            $this->title = $title;
            $this->subtitle = $subtitle;
        }
        
        $this->align = $align;
        $this->darkMode = $darkMode;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.section-heading');
    }
}
