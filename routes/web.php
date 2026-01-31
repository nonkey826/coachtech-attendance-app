<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceListController;
use App\Http\Controllers\AttendanceCorrectionController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 勤怠一覧
Route::get('/attendances', [AttendanceListController::class, 'index'])
    ->middleware('auth');

// 勤怠詳細
Route::get('/attendances/{attendance}', [AttendanceListController::class, 'show'])
    ->middleware('auth')
    ->name('attendances.show');

// 修正画面
Route::get('/attendances/{attendance}/edit', [AttendanceListController::class, 'edit'])
    ->middleware('auth')
    ->name('attendances.edit');

// ✅修正保存（これだけ残す）
Route::patch('/attendances/{attendance}', [AttendanceListController::class, 'update'])
    ->middleware('auth')
    ->name('attendances.update');

Route::middleware('auth')->group(function () {

    // ✅ 勤怠（一般ユーザー）
    Route::get('/attendance', [AttendanceController::class, 'index'])
        ->name('attendance.index');

    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn']);
    Route::post('/attendance/break-start', [AttendanceController::class, 'breakStart']);
    Route::post('/attendance/break-end', [AttendanceController::class, 'breakEnd']);
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut']);

    // Breeze標準：プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/attendance/list', [AttendanceListController::class, 'index'])
        ->middleware('auth');

    Route::get('/attendance/detail/{attendance}', [AttendanceListController::class, 'show'])
        ->middleware('auth');

    Route::get('/stamp_correction_request/list', [AttendanceCorrectionController::class, 'index'])
        ->middleware('auth');
});

require __DIR__ . '/auth.php';
