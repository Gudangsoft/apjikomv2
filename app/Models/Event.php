<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'description',
        'image',
        'location',
        'event_date',
        'event_time',
        'event_type',
        'has_registration',
        'has_certificate',
        'online_platform',
        'registration_requirements',
        'participant_quota',
        'registration_fee',
        'registration_link',
        'is_published',
        'is_featured', // untuk ditampilkan di homepage
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'has_registration' => 'boolean',
        'has_certificate' => 'boolean',
        'registration_fee' => 'decimal:2',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->format('Y-m-d'));
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function isUserRegistered($userId)
    {
        return $this->registrations()
            ->where('user_id', $userId)
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    public function getRegisteredCountAttribute()
    {
        return $this->registrations()
            ->where('status', '!=', 'cancelled')
            ->count();
    }
}
