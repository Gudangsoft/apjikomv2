<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'image',
        'youtube_url',
        'youtube_id',
        'category',
        'event_id',
        'event_date',
        'order',
        'is_featured',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    public function getYoutubeThumbnailAttribute()
    {
        if ($this->type === 'video' && $this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
        }
        return null;
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if ($this->type === 'video' && $this->youtube_id) {
            return "https://www.youtube.com/embed/{$this->youtube_id}";
        }
        return null;
    }

    public static function extractYoutubeId($url)
    {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match)) {
            return $match[1];
        }
        return null;
    }
}
