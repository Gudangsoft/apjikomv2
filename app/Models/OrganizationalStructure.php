<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationalStructure extends Model
{
    protected $fillable = [
        'position',
        'name',
        'photo',
        'description',
        'type',
        'division_name',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLeadership($query)
    {
        return $query->where('type', 'leadership');
    }

    public function scopeDivision($query)
    {
        return $query->where('type', 'division');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
