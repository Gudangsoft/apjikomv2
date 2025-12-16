<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalDivision extends Model
{
    protected $fillable = [
        'cover',
        'division',
        'main_focus',
        'journal_potential',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
