<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;
protected $fillable = [
        'user_id',
        'date',
        'clock_in_at',
        'clock_out_at',
    ];
    /**
     * 勤怠は1人のユーザーに属する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 勤怠は複数の休憩を持つ
     */
    public function breaks()
    {
        return $this->hasMany(AttendanceBreak::class);
    }

    /**
     * 勤怠は複数の修正申請を持つ
     */
    public function correctionRequests()
    {
        return $this->hasMany(AttendanceCorrectionRequest::class);
    }

    /**
     * 退勤済かどうか
     */
    public function isClockedOut(): bool
    {
        return ! is_null($this->clock_out_at);
    }

    /**
 * 出勤済かどうか
 */
public function isClockedIn(): bool
{
    return ! is_null($this->clock_in_at);
}

/**
 * 休憩中かどうか（未終了の休憩があるか）
 */
public function isOnBreak(): bool
{
    return $this->breaks()
        ->whereNull('break_end_at')
        ->exists();
}
/**
 * 表示用の勤怠ステータスを取得する
 */
public function currentStatus(): string
{
    if (! $this->isClockedIn()) {
        return '勤務外';
    }

    if ($this->isClockedOut()) {
        return '退勤済';
    }

    if ($this->isOnBreak()) {
        return '休憩中';
    }

    return '出勤中';
}

/**
 * 現在進行中の休憩（未終了）
 */
public function activeBreak()
{
    return $this->hasOne(AttendanceBreak::class)
        ->whereNull('break_end_at')
        ->latestOfMany();
}

protected function casts(): array
{
    return [
        'date' => 'date',
        'clock_in_at' => 'datetime',
        'clock_out_at' => 'datetime',
    ];
    
}

public function breakMinutes(): int
{
    return $this->breaks->sum(function ($break) {
        if (! $break->break_start_at || ! $break->break_end_at) {
            return 0;
        }

        return Carbon::parse($break->break_start_at)
            ->diffInMinutes(Carbon::parse($break->break_end_at));
    });
}

public function breakMinutesText(): string
{
    $min = $this->breakMinutes();
    return $min ? "{$min}分" : "-";
}

public function workMinutes(): int
{
    if (! $this->clock_in_at || ! $this->clock_out_at) {
        return 0;
    }

    $total = $this->clock_in_at->diffInMinutes($this->clock_out_at);

    return max(0, $total - $this->breakMinutes());
}

public function workMinutesText(): string
{
    $min = $this->workMinutes();
    return $min ? "{$min}分" : "-";
}


}
