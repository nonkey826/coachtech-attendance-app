<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceBreak extends Model
{
    use HasFactory;

    /**
     * 休憩は1つの勤怠に属する
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
