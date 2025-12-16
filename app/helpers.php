<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        static $settings = null;
        
        if ($settings === null) {
            $settings = Setting::all()->pluck('value', 'key');
        }
        
        return $settings->get($key, $default);
    }
}

if (!function_exists('site_name')) {
    /**
     * Get site name
     *
     * @return string
     */
    function site_name()
    {
        return setting('site_name', 'APJIKOM');
    }
}

if (!function_exists('site_logo')) {
    /**
     * Get site logo URL
     *
     * @return string
     */
    function site_logo()
    {
        $logo = setting('site_logo');
        return $logo ? asset('storage/' . $logo) : null;
    }
}

if (!function_exists('site_tagline')) {
    /**
     * Get site tagline
     *
     * @return string
     */
    function site_tagline()
    {
        return setting('site_tagline', 'Asosiasi Pendidikan Jurnalistik dan Komunikasi');
    }
}
