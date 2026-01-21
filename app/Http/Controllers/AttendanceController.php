<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * 勤怠打刻画面表示（一般ユーザー）
     */
    public function index()
{
    // 仮ユーザー（開発用）
    $user = \App\Models\User::first();

    $today = Carbon::today();

    $attendance = Attendance::where('user_id', $user->id)
        ->whereDate('date', $today)
        ->first();

    $status = $attendance
        ? $attendance->currentStatus()
        : '勤務外';

    return view('attendance.index', [
        'attendance' => $attendance,
        'status' => $status,
    ]);
}


    /**
 * 出勤処理
 */
public function clockIn()
{
    // 仮ユーザー（開発用）
    $user = \App\Models\User::first();

    $today = Carbon::today();

    Attendance::create([
        'user_id'     => $user->id,
        'date'        => $today,
        'clock_in_at' => Carbon::now(),
    ]);

    return redirect('/attendance');
}


}
