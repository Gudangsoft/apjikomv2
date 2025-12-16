<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    protected $fillable = [
        'version',
        'release_date',
        'changes',
        'type',
        'updated_by',
        'is_published'
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_published' => 'boolean'
    ];
}
