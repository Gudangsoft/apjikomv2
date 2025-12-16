<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    // Relationship with menus
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Scope for published pages
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Scope for ordered pages
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
