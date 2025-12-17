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
        'member_id', // Link to member after approval
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'accreditation_valid_until' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Member (setelah approved)
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Relasi ke User berdasarkan email
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Scope: Filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Only pending registrations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Only approved registrations
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Only rejected registrations
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope: Search by name, email, phone, or institution
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('institution', 'like', "%{$search}%");
        });
    }

    /**
     * Scope: Filter by type (individu/prodi)
     */
    public function scopeType($query, $type)
    {
        if (empty($type)) {
            return $query;
        }

        return $query->where('type', $type);
    }

    /**
     * Scope: Filter by has member
     */
    public function scopeHasMember($query, $hasMember)
    {
        if ($hasMember === 'yes') {
            return $query->whereNotNull('member_id');
        } elseif ($hasMember === 'no') {
            return $query->whereNull('member_id');
        }

        return $query;
    }

    /**
     * Accessor: Get formatted status badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
            'approved' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Approved</span>',
            'rejected' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Rejected</span>',
        ];
        
        return $badges[$this->status] ?? $this->status;
    }

    /**
     * Accessor: Get type badge
     */
    public function getTypeBadgeAttribute()
    {
        $badges = [
            'individu' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Individu</span>',
            'prodi' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">Prodi</span>',
        ];
        
        return $badges[$this->type] ?? $this->type;
    }

    /**
     * Check if registration has been converted to member
     */
    public function hasMember()
    {
        return !is_null($this->member_id);
    }

    /**
     * Check if registration is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if registration is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if registration is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
