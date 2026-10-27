<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CooperationPhoto extends Model
{
    protected $fillable = [
        'cooperation_id',
        'photo',
        'caption',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function cooperation()
    {
        return $this->belongsTo(Cooperation::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (CooperationPhoto $photo) {
            if ($photo->photo && Storage::disk('public')->exists($photo->photo)) {
                Storage::disk('public')->delete($photo->photo);
            }
        });
    }
}
