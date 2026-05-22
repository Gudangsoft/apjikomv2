<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaBlastLog extends Model
{
    protected $fillable = [
        'title',
        'message',
        'gateway',
        'recipient_filter',
        'total_recipients',
        'success_count',
        'failed_count',
        'failed_numbers',
        'status',
        'sent_by',
        'sent_at',
    ];

    protected $casts = [
        'failed_numbers' => 'array',
        'sent_at'        => 'datetime',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function getSuccessRateAttribute(): int
    {
        if ($this->total_recipients === 0) return 0;
        return (int) round(($this->success_count / $this->total_recipients) * 100);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'     => 'Draft',
            'sending'   => 'Mengirim...',
            'completed' => 'Selesai',
            'failed'    => 'Gagal',
            default     => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft'     => 'gray',
            'sending'   => 'blue',
            'completed' => 'green',
            'failed'    => 'red',
            default     => 'gray',
        };
    }
}
