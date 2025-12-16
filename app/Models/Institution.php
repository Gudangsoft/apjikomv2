<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'website',
        'logo',
        'description',
        'joined_date',
        'is_active',
    ];

    protected $casts = [
        'joined_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationship dengan members
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    // Scope untuk active institutions
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk logo URL
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return null;
    }
}
