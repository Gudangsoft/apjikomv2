<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCardTemplate extends Model
{
    protected $fillable = [
        'name',
        'template_image',
        'is_active',
        'description',
        'font_settings',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'font_settings' => 'array',
    ];

    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    public function setAsActive()
    {
        self::where('id', '!=', $this->id)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

    public static function defaultFontSettings(): array
    {
        return [
            'font_bold'          => 'arialbd.ttf',
            'font_regular'       => 'arial.ttf',
            'header_font_size'   => 25,
            'header_bold'        => true,
            'header_y'           => 265,
            'label_font_size'    => 15,
            'label_bold'         => true,
            'value_font_size'    => 15,
            'value_bold'         => false,
            'line_spacing'       => 32,
            'label_width'        => 95,
            'label_gap'          => 15,
            'data_start_x'       => 380,
            'data_start_y'       => 310,
            'font_color'         => '#000000',
        ];
    }

    public function getFontSetting(string $key, $default = null)
    {
        $defaults = self::defaultFontSettings();
        $settings = $this->font_settings ?? [];
        return $settings[$key] ?? $defaults[$key] ?? $default;
    }

    public function mergedFontSettings(): array
    {
        return array_merge(self::defaultFontSettings(), $this->font_settings ?? []);
    }
}
