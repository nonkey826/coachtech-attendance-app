<?php

namespace App\Http\Controllers;

use App\Models\AttendanceCorrectionRequest;
use Illuminate\Http\Request;

class AttendanceCorrectionController extends Controller
{
    public function index()
    {
        $requests = AttendanceCorrectionRequest::with(['attendance.user'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('attendance_corrections.index', compact('requests'));
    }
}
