<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceCorrectionRequest extends Model
{
    protected $fillable = [
        'attendance_id',
        'requested_clock_in_at',
        'requested_clock_out_at',
        'reason',
        'status',
        'reviewed_at',
    ];

    protected $casts = [
        'requested_clock_in_at' => 'datetime',
        'requested_clock_out_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }
}
