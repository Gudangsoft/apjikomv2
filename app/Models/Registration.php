<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'email',
        'phone',
        'password',
        'full_name',
        'payment_proof',
        'institution',
        'study_program',
        'accreditation',
        'accreditation_valid_until',
        'province',
        'authorization_letter',
        'status',
        'notes',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'accreditation_valid_until' => 'date',
    ];
}
