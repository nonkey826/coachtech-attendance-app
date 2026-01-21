<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;



Route::get('/', function () {
    return view('welcome');
});

/**
 * 勤怠打刻画面（一般ユーザー）あとで戻す
 */
// Route::get('/attendance', [AttendanceController::class, 'index'])
//     ->middleware('auth');
    



    Route::get('/attendance', [AttendanceController::class, 'index']);

/**
 * 出勤処理
 */
Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn']);    