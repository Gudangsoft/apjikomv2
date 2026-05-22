<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    const CACHE_TTL = 3600; // 1 jam
    const CACHE_PREFIX = 'setting_';
    const CACHE_ALL_KEY = 'settings_all';

    /**
     * Get setting value by key — cached for 1 hour
     */
    public static function getValue($key, $default = null)
    {
        $cacheKey = self::CACHE_PREFIX . $key;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value and flush related cache
     */
    public static function setValue($key, $value, $type = 'text', $group = 'general')
    {
        $result = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );

        Cache::forget(self::CACHE_PREFIX . $key);
        Cache::forget(self::CACHE_ALL_KEY);

        return $result;
    }

    /**
     * Get all settings as key-value array — cached
     */
    public static function getAllCached(): array
    {
        return Cache::remember(self::CACHE_ALL_KEY, self::CACHE_TTL, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Flush entire settings cache (call after bulk updates)
     */
    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_ALL_KEY);
        // Individual keys will expire naturally or on next setValue call
    }
}
