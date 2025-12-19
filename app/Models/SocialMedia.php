<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $table = 'social_media';
    
    protected $fillable = [
        'name',
        'url',
        'icon',
        'icon_class',
        'note',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope untuk get hanya yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk get dengan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
