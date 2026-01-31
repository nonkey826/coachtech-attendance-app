<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\AttendanceCorrectionRequest;


class AttendanceListController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // month=2026-01 形式で受け取る（なければ今月）
        $month = $request->input('month', now()->format('Y-m'));

        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $attendances = Attendance::where('user_id', $user->id)
            ->with('breaks')
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('date')
            ->get();

        // ✅ 今月の総勤務時間（分）
        $totalWorkMinutes = $attendances->sum(fn($attendance) => $attendance->workMinutes());

        $prevMonth = (clone $start)->subMonth()->format('Y-m');
        $nextMonth = (clone $start)->addMonth()->format('Y-m');

        return view('attendances.index', compact(
            'attendances',
            'month',
            'prevMonth',
            'nextMonth',
            'totalWorkMinutes'
        ));
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('breaks', 'correctionRequests');

        $pendingRequest = $attendance->correctionRequests()
            ->where('status', 'pending')
            ->latest()
            ->first();

        return view('attendances.show', compact('attendance', 'pendingRequest'));
    }


    public function edit(Attendance $attendance)
    {
        return view('attendances.edit', compact('attendance'));
    }


    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'clock_in_at'  => ['nullable', 'date_format:H:i'],
            'clock_out_at' => ['nullable', 'date_format:H:i'],
            'reason'       => ['required', 'string', 'max:1000'],
        ]);

        $date = Carbon::parse($attendance->date)->format('Y-m-d');

        $requestedClockInAt = $validated['clock_in_at']
            ? Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $validated['clock_in_at'])
            : null;

        $requestedClockOutAt = $validated['clock_out_at']
            ? Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $validated['clock_out_at'])
            : null;

        AttendanceCorrectionRequest::create([
            'attendance_id' => $attendance->id,
            'requested_clock_in_at' => $requestedClockInAt,
            'requested_clock_out_at' => $requestedClockOutAt,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('attendances.show', $attendance)
            ->with('success', '修正申請を送信しました（承認待ち）');
    }
}
