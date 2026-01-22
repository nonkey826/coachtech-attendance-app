<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

/**
 * 勤怠打刻画面（一般ユーザー）
 */
Route::get('/attendance', [AttendanceController::class, 'index'])
    ->name('attendance.index');

/**
 * 出勤処理
 */
Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn']);

/**
 * 休憩処理
 */
Route::post('/attendance/break-start', [AttendanceController::class, 'breakStart']);
Route::post('/attendance/break-end', [AttendanceController::class, 'breakEnd']);

/**
 * 退勤処理
 */
Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut']);
