<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceBreak;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * 勤怠打刻画面表示（一般ユーザー）
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        $status = $attendance
            ? $attendance->currentStatus()
            : '勤務外';

        return view('attendance.index', [
            'attendance' => $attendance,
            'status'     => $status,
        ]);
    }

    /**
     * 出勤処理
     */
    public function clockIn()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // すでに出勤済なら何もしない
        if ($attendance && $attendance->isClockedIn()) {
            return redirect('/attendance');
        }

        Attendance::create([
            'user_id'     => $user->id,
            'date'        => $today,
            'clock_in_at' => now(),
        ]);

        return redirect('/attendance');
    }

    /**
     * 休憩開始
     */
    public function breakStart()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // 出勤していない / 退勤済 / すでに休憩中 → 何もしない
        if (! $attendance || $attendance->isClockedOut() || $attendance->isOnBreak()) {
            return redirect('/attendance');
        }

        AttendanceBreak::create([
            'attendance_id'  => $attendance->id,
            'break_start_at' => now(),
        ]);

        return redirect('/attendance');
    }

    /**
     * 休憩終了
     */
    public function breakEnd()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (! $attendance) {
            return redirect('/attendance');
        }

        $break = $attendance->activeBreak()->first();

        // 休憩中でなければ何もしない
        if (! $break) {
            return redirect('/attendance');
        }

        $break->update([
            'break_end_at' => now(),
        ]);

        return redirect('/attendance');
    }

    /**
     * 退勤処理
     */
    public function clockOut()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // 出勤していない / すでに退勤済 → 何もしない
        if (! $attendance || $attendance->isClockedOut()) {
            return redirect('/attendance');
        }

        // 未終了の休憩があれば自動で終了
        $activeBreak = $attendance->activeBreak()->first();
        if ($activeBreak) {
            $activeBreak->update([
                'break_end_at' => now(),
            ]);
        }

        // 退勤
        $attendance->update([
            'clock_out_at' => now(),
        ]);

        return redirect('/attendance');
    }
}

