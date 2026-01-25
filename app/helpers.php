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
        return Setting::getValue($key, $default);
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
        return setting('site_tagline', 'Asosiasi Pengelola Jurnal Informatika dan Komputer');
    }
}

if (!function_exists('format_stat_number')) {
    /**
     * Format large numbers for statistics display
     * Examples: 1500 -> 1.5k+, 35000 -> 35k+, 500 -> 500+
     *
     * @param int $number
     * @return string
     */
    function format_stat_number($number)
    {
        if ($number >= 1000) {
            $formatted = round($number / 1000, 1);
            // Remove .0 if it's a whole number
            if ($formatted == floor($formatted)) {
                $formatted = (int)$formatted;
            }
            return $formatted . 'k+';
        }
        return number_format($number) . '+';
    }
}
