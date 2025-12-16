<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'url',
        'page_id',
        'parent_id',
        'type',
        'target',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship with parent menu (for 3-level hierarchy)
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Relationship with children menus
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order', 'asc');
    }

    // Relationship with page
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Scope for active menus
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered menus
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Scope for top-level menus (no parent)
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    // Get all descendants recursively (for 3-level support)
    public function descendants()
    {
        return $this->children()->with('children');
    }

    // Get menu level (0 = top, 1 = second level, 2 = third level)
    public function getLevel()
    {
        $level = 0;
        $parent = $this->parent;
        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }
        return $level;
    }
}
