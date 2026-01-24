<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        $prevMonth = (clone $start)->subMonth()->format('Y-m');
        $nextMonth = (clone $start)->addMonth()->format('Y-m');

        return view('attendances.index', compact(
            'attendances',
            'month',
            'prevMonth',
            'nextMonth'
        ));
    }

    public function show(Attendance $attendance)
{
    $attendance->load('breaks');

    return view('attendances.show', compact('attendance'));
}


}
