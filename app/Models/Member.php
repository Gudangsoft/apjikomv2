<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'member_type',
        'institution_name',
        'position',
        'address',
        'phone',
        'website',
        'status',
        'join_date',
        'expiry_date',
        'member_card',
        'member_number',
        'photo',
        'card_requested',
        'card_requested_at',
        'card_update_requested',
        'card_update_requested_at',
        'show_in_directory',
        'expertise',
        'bio',
        'linkedin',
        'facebook',
        'twitter',
        'instagram',
        'is_verified',
        'verified_at',
        'verification_document',
        'verification_notes',
        'verified_by',
    ];

    protected $casts = [
        'join_date' => 'date',
        'expiry_date' => 'date',
        'card_generated_at' => 'datetime',
        'card_requested_at' => 'datetime',
        'card_update_requested_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Generate member number format: APJIKOM.DDMMYYYY.XXX
     */
    public function generateMemberNumber()
    {
        if ($this->member_number) {
            return $this->member_number; // Already has number
        }

        $date = $this->created_at->format('dmY');
        
        // Get last member number for today
        $lastMember = self::where('member_number', 'LIKE', "APJIKOM.{$date}.%")
            ->orderBy('member_number', 'desc')
            ->first();

        if ($lastMember && preg_match('/APJIKOM\.\d{8}\.(\d{3})/', $lastMember->member_number, $matches)) {
            $lastNumber = intval($matches[1]);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        $memberNumber = "APJIKOM.{$date}.{$newNumber}";
        $this->update(['member_number' => $memberNumber]);

        return $memberNumber;
    }
}
