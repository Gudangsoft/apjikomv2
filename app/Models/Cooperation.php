<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Cooperation extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'category',
        'website',
        'mou_file',
        'mou_date',
        'moa_file',
        'moa_date',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'mou_date' => 'date',
        'moa_date' => 'date',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Route model binding pakai slug untuk halaman publik.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%");
        });
    }

    public function hasMou(): bool
    {
        return !empty($this->mou_file);
    }

    public function hasMoa(): bool
    {
        return !empty($this->moa_file);
    }

    public function photos()
    {
        return $this->hasMany(CooperationPhoto::class);
    }

    /**
     * Foto sampul: foto galeri pertama kalau ada, kalau tidak pakai logo.
     */
    public function getCoverPhotoAttribute(): ?string
    {
        $firstGalleryPhoto = $this->relationLoaded('photos')
            ? $this->photos->first()?->photo
            : $this->photos()->ordered()->value('photo');

        return $firstGalleryPhoto ?? $this->logo;
    }

    /**
     * Hapus file logo/MoU/MoA + semua foto galeri saat record dihapus.
     * (FK onDelete cascade cuma hapus baris DB, bukan file fisiknya —
     * jadi foto galeri dihapus manual lewat relasi di sini.)
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Cooperation $cooperation) {
            foreach (['logo', 'mou_file', 'moa_file'] as $field) {
                if ($cooperation->$field && Storage::disk('public')->exists($cooperation->$field)) {
                    Storage::disk('public')->delete($cooperation->$field);
                }
            }

            $cooperation->photos()->get()->each->delete();
        });
    }
}
