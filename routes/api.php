<?php

use App\Http\Controllers\Api\V1\Manager\ShiftManagerController;
use App\Http\Controllers\Api\V1\Workers\WorkerShiftController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware([])->name('api')->group(function () {
    Route::middleware([])->prefix("shift/admin")->group(function () {
        Route::post('manager', [ShiftManagerController::class, 'shiftManager'])->name('shift.manager');
    });

    Route::prefix('worker/shift')->group(function () {
        Route::post('daily-roster', [WorkerShiftController::class, 'dailyRoster'])->name('shift.daily-roster');
        Route::post("clock-in", [WorkerShiftController::class, 'workerClockIn'])->name('shift.clock-in');
        Route::post('clock-out', [WorkerShiftController::class, 'workerClockOut'])->name('shift.clock-out');
        Route::post('work-days', [WorkerShiftController::class, 'listOfAllShiftForAWorker'])->name('shift.work-days');
    });
});
