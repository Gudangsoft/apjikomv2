<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'notes',
        'payment_proof',
        'payment_status',
        'payment_verified_at',
        'verified_by',
        'payment_notes',
        'registered_at',
        'attended_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'attended_at' => 'datetime',
        'payment_verified_at' => 'datetime',
    ];

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isPaid()
    {
        return in_array($this->payment_status, ['paid', 'verified']);
    }

    public function isVerified()
    {
        return $this->payment_status === 'verified';
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isAttended()
    {
        return $this->status === 'attended';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}
