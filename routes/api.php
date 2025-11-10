<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperienceDetailController;
use App\Http\Controllers\FollowUpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('edit_api/{id}', [ExperienceDetailController::class, 'edit_api'])->name('edit_api');
// Route::get('get_appointment/', [FollowUpController::class, 'get_appointment'])->name('get.apointment');
Route::post('get_appointment2/', [FollowUpController::class, 'get_appointment2'])->name('get.apointment');
Route::get('dismiss_appointment/{id}', [FollowUpController::class, 'dismiss_appointment'])->name('dismiss.apointment');
Route::get('dismiss_all_appointment', [FollowUpController::class, 'dismiss_all_appointment'])->name('dismiss.all.apointment');
Route::post('dismiss_all_appointment2', [FollowUpController::class, 'dismiss_all_appointment2'])->name('dismiss.all.apointment2');
Route::post('snooze_reminders', [FollowUpController::class, 'snooze_reminders'])->name('snooze.reminders');
