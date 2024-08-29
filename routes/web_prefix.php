<?php

use App\Http\Controllers\QueueController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\CompletedController;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\NeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::middleware(['guest'])->group(function () {

Route::get('/', [SesiController::class, 'index'])->name('login');
Route::get('/login', [SesiController::class, 'index'])->name('login.form');
Route::post('/login', [SesiController::class, 'login'])->name('login.submit');
Route::get('/logout', [SesiController::class, 'logout'])->name('logout');



Route::group(['prefix' => 'admin', 'middleware' => ['roleAcces'], 'as' => 'admin.'], function () {

    // START ROUTE ADMIN=================================================================================================================================   // ROUTE ADMIN
    Route::get('/dashboard', [DashboardController::class, 'dashboard_admin'])->name('dashboard');

    // queue admin
    Route::get('/queue', [QueueController::class, 'index_admin'])->name('queue');
    Route::get('/queue/create', [QueueController::class, 'queue_create'])->name('queue.create');
    Route::post('/queue/store', [QueueController::class, 'queue_store'])->name('queue.store');
    Route::get('/queue/edit/{id}', [QueueController::class, 'queue_edit'])->name('queue.edit');
    Route::put('/queue/update/{id}', [QueueController::class, 'queue_update'])->name('queue.update');
    Route::get('/queue/process/{id}', [QueueController::class, 'queue_process'])->name('queue.process');
    Route::get('/queue/export', [QueueController::class, 'queue_export'])->name('queue.export');
    Route::delete('/queue/destroy/{id}', [QueueController::class, 'queue_destroy'])->name('queue.destroy');


    // progress admin
    Route::get('/progress', [ProgressController::class, 'index_admin'])->name('progress');
    Route::get('/progress/cancel/{id}', [ProgressController::class, 'progress_cancel'])->name('progress.cancel');
    Route::get('/progress/completed/{id}', [ProgressController::class, 'progress_completed'])->name('progress.completed');
    Route::get('/progress/hold/create/{id?}', [ProgressController::class, 'progress_hold_create'])->name('progress.hold.create')->where('id', '.*');;
    Route::post('/progress/hold/store', [ProgressController::class, 'progress_hold_store'])->name('progress.hold.store');
    Route::get('/progress/export', [ProgressController::class, 'progress_export'])->name('progress.export');


    // completed admin  
    Route::get('/completed', [CompletedController::class, 'index_admin'])->name('completed');
    Route::post('/completed', [CompletedController::class, 'index_admin'])->name('completed.filter');
    Route::get('/completed/export', [CompletedController::class, 'completed_export'])->name('completed.export');


    // hold admin
    Route::get('/hold', [HoldController::class, 'index_admin'])->name('hold');
    Route::get('/hold/process/{id}', [HoldController::class, 'hold_process'])->name('hold.process');
    Route::get('/hold/export', [HoldController::class, 'hold_export'])->name('hold.export');


    // need admin
    Route::get('/need', [NeedController::class, 'index_admin'])->name('need');
    Route::get('/need/create/{id?}', [NeedController::class, 'need_create'])->name('need.create')->where('id', '.*');
    Route::post('/need/store', [NeedController::class, 'need_store'])->name('need.store');
    Route::get('/need/export', [NeedController::class, 'need_export'])->name('need.export');




    // END ROUTE ADMIN================================================================================================================================= // END ROUTE ADMI
});


Route::group(['prefix' => 'user', 'middleware' => ['roleAcces'], 'as' => 'user.'], function () {

    // START ROUTE USER==============================================================================================// START ROUTE USER
    Route::get('/dashboard', [DashboardController::class, 'dashboard_user'])->name('dashboard');

    // queue user
    Route::get('/queue', [QueueController::class, 'index_user'])->name('queue');
    Route::get('/queue/export', [QueueController::class, 'queue_export'])->name('queue.export');


    // progress user
    Route::get('/progress', [ProgressController::class, 'index_user'])->name('progress');
    Route::get('/progress/export', [ProgressController::class, 'progress_export'])->name('progress.export');


    // completed user  
    Route::get('/completed', [CompletedController::class, 'index_user'])->name('completed');
    Route::post('/completed', [CompletedController::class, 'index_admin'])->name('completed.filter');
    Route::get('/completed/export', [CompletedController::class, 'completed_export'])->name('completed.export');


    // hold user
    Route::get('/hold', [HoldController::class, 'index_user'])->name('hold');
    Route::get('/hold/export', [HoldController::class, 'hold_export'])->name('hold.export');


    // need user
    Route::get('/need', [NeedController::class, 'index_user'])->name('need');
    Route::get('/need/export', [NeedController::class, 'need_export'])->name('need.export');



    // END ROUTE USER==============================================================================================// START ROUTE USER

});


Route::get('/home', function () {
    return redirect()->route('dashboard');
});
