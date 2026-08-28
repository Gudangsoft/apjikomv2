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
        return setting('site_name', 'Website Asosiasi');
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
        return setting('site_tagline', 'Website Asosiasi');
    }
}

if (!function_exists('clean_website_url')) {
    /**
     * Normalise a user-entered website value into a safe external URL,
     * or return null when it is not a usable external website
     * (empty, localhost / this app's own host, or a host without a dot).
     *
     * @param string|null $value
     * @return string|null
     */
    function clean_website_url($value)
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (!preg_match('~^https?://~i', $value)) {
            $value = 'https://' . ltrim($value, '/');
        }

        $host = strtolower((string) parse_url($value, PHP_URL_HOST));
        if ($host === '') {
            return null;
        }

        $blocked = ['localhost', '127.0.0.1', '::1', '0.0.0.0'];
        try {
            $appHost = strtolower((string) parse_url(config('app.url'), PHP_URL_HOST));
            if ($appHost !== '') {
                $blocked[] = $appHost;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        if (in_array($host, $blocked, true) || !str_contains($host, '.')) {
            return null;
        }

        return $value;
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
