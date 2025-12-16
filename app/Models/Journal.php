<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'authors',
        'abstract',
        'volume',
        'issue',
        'year',
        'pages',
        'doi',
        'keywords',
        'file_path',
        'cover_image',
        'published_date',
        'views',
        'downloads',
        'is_published',
        'category',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_published' => 'boolean',
    ];
}
