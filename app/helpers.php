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

if (!function_exists('wa_number')) {
    /**
     * Normalise a phone number into a bare 62-prefixed digit string
     * suitable for a wa.me link.
     *
     * @param string|null $phone
     * @return string
     */
    function wa_number($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', (string) $phone);

        if ($phone === '') {
            return '';
        }

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}

if (!function_exists('member_wa_groups')) {
    /**
     * Admin-configured WhatsApp group invite links for members.
     * Each item: ['label' => string, 'url' => string]. Optional, 0..n.
     *
     * @return array<int, array{label: string, url: string}>
     */
    function member_wa_groups()
    {
        $items = json_decode((string) setting('member_wa_groups', '[]'), true) ?: [];

        return array_values(array_filter($items, fn ($item) => !empty($item['url'] ?? null)));
    }
}

if (!function_exists('member_wa_contacts')) {
    /**
     * Admin-configured WhatsApp numbers for contacting the APJIKOM team.
     * Each item: ['label' => string, 'number' => string]. Optional, 0..n.
     *
     * @return array<int, array{label: string, number: string}>
     */
    function member_wa_contacts()
    {
        $items = json_decode((string) setting('member_wa_contacts', '[]'), true) ?: [];

        return array_values(array_filter($items, fn ($item) => !empty($item['number'] ?? null)));
    }
}

if (!function_exists('member_card_bank_accounts')) {
    /**
     * Admin-configured bank accounts for the member-card printing fee.
     * Each item: ['bank' => string, 'number' => string, 'holder' => string]. Optional, 0..n.
     *
     * @return array<int, array{bank: string, number: string, holder: string}>
     */
    function member_card_bank_accounts()
    {
        $items = json_decode((string) setting('member_card_bank_accounts', '[]'), true) ?: [];

        return array_values(array_filter(
            $items,
            fn ($item) => !empty($item['bank'] ?? null) || !empty($item['number'] ?? null)
        ));
    }
}

if (!function_exists('bank_badge')) {
    /**
     * Resolve a small "logo" badge (short label + brand-ish gradient) for a
     * bank name, so account lists look recognizable without needing actual
     * logo image assets. Falls back to a generic gray badge for unknown banks.
     *
     * @param string|null $bankName
     * @return array{label: string, color: string}
     */
    function bank_badge($bankName)
    {
        $name = strtolower(trim((string) $bankName));

        $known = [
            'bri'      => ['label' => 'BRI',     'color' => 'linear-gradient(135deg,#00529C,#0073CF)'],
            'bni'      => ['label' => 'BNI',      'color' => 'linear-gradient(135deg,#F37021,#FF9248)'],
            'mandiri'  => ['label' => 'Mandiri',  'color' => 'linear-gradient(135deg,#003D79,#0057A8)'],
            'bca'      => ['label' => 'BCA',      'color' => 'linear-gradient(135deg,#0066B3,#2E8FD6)'],
            'syariah indonesia' => ['label' => 'BSI', 'color' => 'linear-gradient(135deg,#00A651,#1FBF6B)'],
            'bsi'      => ['label' => 'BSI',      'color' => 'linear-gradient(135deg,#00A651,#1FBF6B)'],
            'cimb'     => ['label' => 'CIMB',     'color' => 'linear-gradient(135deg,#7A1E2B,#A3293A)'],
            'danamon'  => ['label' => 'Danamon',  'color' => 'linear-gradient(135deg,#D71A21,#F0323B)'],
            'permata'  => ['label' => 'Permata',  'color' => 'linear-gradient(135deg,#00A99D,#1FC6B9)'],
            'btn'      => ['label' => 'BTN',      'color' => 'linear-gradient(135deg,#004A94,#0066C6)'],
        ];

        foreach ($known as $needle => $info) {
            if ($name !== '' && str_contains($name, $needle)) {
                return $info;
            }
        }

        $label = $name !== '' ? strtoupper(substr(trim((string) $bankName), 0, 4)) : 'BANK';

        return ['label' => $label, 'color' => 'linear-gradient(135deg,#4B5563,#6B7280)'];
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
