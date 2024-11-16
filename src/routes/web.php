<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\RestController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('home');
    
    // 勤怠関連のルート
    Route::post('/work/start', [WorkController::class, 'startWork'])->name('work.start');
    Route::post('/work/end', [WorkController::class, 'endWork'])->name('work.end');
    
    // 休憩関連のルート
    Route::post('/rest/start', [RestController::class, 'startRest'])->name('rest.start');
    Route::post('/rest/end', [RestController::class, 'endRest'])->name('rest.end');
    
    // 勤怠データ表示
    Route::get('/attendance', [WorkController::class, 'attendance'])->name('work.attendance');

    // 休憩データ表示
    Route::post('/rest/toggle', [RestController::class, 'toggleRest'])->name('rest.toggle');

});


