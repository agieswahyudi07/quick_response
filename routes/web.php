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

Route::middleware(['guest'])->group(function () {

    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::get('/login', [SesiController::class, 'index'])->name('login.form');
    Route::post('/login', [SesiController::class, 'login'])->name('login.submit');
});


Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');

    // START ROUTE ADMIN==========================================================================================================================   // ROUTE ADMIN
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard_admin'])->name('dashboard.admin');

    // queue admin
    Route::get('/admin/queue', [QueueController::class, 'index_admin'])->name('queue.admin');
    Route::get('/admin/queue/create', [QueueController::class, 'queue_create'])->name('queue.create');
    Route::post('/admin/queue/store', [QueueController::class, 'queue_store'])->name('queue.store');
    Route::get('/admin/queue/edit/{id}', [QueueController::class, 'queue_edit'])->name('queue.edit');
    Route::put('/admin/queue/update/{id}', [QueueController::class, 'queue_update'])->name('queue.update');
    Route::get('/admin/queue/process/{id}', [QueueController::class, 'queue_process'])->name('queue.process');
    Route::get('/queue/export', [QueueController::class, 'queue_export'])->name('queue.export');
    Route::delete('/admin/queue/destroy/{id}', [QueueController::class, 'queue_destroy'])->name('queue.destroy');


    // progress admin
    Route::get('/admin/progress', [ProgressController::class, 'index_admin'])->name('progress.admin');
    Route::get('/admin/progress/cancel/{id}', [ProgressController::class, 'progress_cancel'])->name('progress.cancel');
    Route::get('/admin/ progress/completed/{id}', [ProgressController::class, 'progress_completed'])->name('progress.completed');
    Route::get('/admin/progress/hold/create/{id?}', [ProgressController::class, 'progress_hold_create'])->name('progress.hold.create')->where('id', '.*');;
    Route::post('/admin/progress/hold/store', [ProgressController::class, 'progress_hold_store'])->name('progress.hold.store');
    Route::get('/progress/export', [ProgressController::class, 'progress_export'])->name('progress.export');


    // completed admin  
    Route::get('/admin/completed', [CompletedController::class, 'index_admin'])->name('completed.admin');
    Route::post('/admin/completed', [CompletedController::class, 'index_admin'])->name('completed.filter');
    Route::get('/completed/export', [CompletedController::class, 'completed_export'])->name('completed.export');


    // hold admin
    Route::get('/admin/hold', [HoldController::class, 'index_admin'])->name('hold.admin');
    Route::get('/admin/hold/process/{id}', [HoldController::class, 'hold_process'])->name('hold.process');
    Route::get('/hold/export', [HoldController::class, 'hold_export'])->name('hold.export');


    // need admin
    Route::get('/admin/need', [NeedController::class, 'index_admin'])->name('need.admin');
    Route::get('/admin/need/create/{id?}', [NeedController::class, 'need_create'])->name('need.create')->where('id', '.*');
    Route::post('/admin/need/store', [NeedController::class, 'need_store'])->name('need.store');
    Route::get('/need/export', [NeedController::class, 'need_export'])->name('need.export');




    // END ROUTE ADMIN==========================================================================================================================


    // =================================================================================
    // =================================================================================
    // =================================================================================
    // =================================================================================


    // START ROUTE USER==========================================================================================================================
    Route::get('/user/dashboard', [DashboardController::class, 'dashboard_user'])->name('dashboard.user');

    // queue user
    Route::get('/user/queue', [QueueController::class, 'index_user'])->name('queue.user');

    // progress user
    Route::get('/user/progress', [ProgressController::class, 'index_user'])->name('progress.user');

    // completed user  
    Route::get('/user/completed', [CompletedController::class, 'index_user'])->name('completed.user');

    // hold user
    Route::get('/user/hold', [HoldController::class, 'index_user'])->name('hold.user');

    // need user
    Route::get('/user/need', [NeedController::class, 'index_user'])->name('need.user');


    // END ROUTE USER==========================================================================================================================



    // Route Queue Complaint
    // Route::get('/queue', [QueueController::class, 'index'])->name('queue');
    // Route::get('/queue/create', [QueueController::class, 'queue_create'])->name('queue.create');
    // Route::post('/queue/store', [QueueController::class, 'queue_store'])->name('queue.store');
    // Route::get('/queue/process/{id}', [QueueController::class, 'queue_process'])->name('queue.process');
    // Route::get('/queue/edit/{id}', [QueueController::class, 'queue_edit'])->name('queue.edit');
    // Route::put('/queue/update/{id}', [QueueController::class, 'queue_update'])->name('queue.update');
    // Route::delete('/queue/destroy/{id}', [QueueController::class, 'queue_destroy'])->name('queue.destroy');
    // Route::get('/queue/export', [QueueController::class, 'queue_export'])->name('queue.export');


    // Route On Progress Complaint
    // Route::get('/progress', [ProgressController::class, 'index'])->name('progress');
    // Route::get('/progress/create', [ProgressController::class, 'progress_create'])->name('progress.create');
    // Route::post('/progress/store', [ProgressController::class, 'progress_store'])->name('progress.store');
    // Route::get('/progress/completed/{id}', [ProgressController::class, 'progress_completed'])->name('progress.completed');
    // Route::get('/progress/cancel/{id}', [ProgressController::class, 'progress_cancel'])->name('progress.cancel');
    // Route::get('/progress/hold/create/{id?}', [ProgressController::class, 'progress_hold_create'])->name('progress.hold.create')->where('id', '.*');;
    // Route::post('/progress/hold/store', [ProgressController::class, 'progress_hold_store'])->name('progress.hold.store');
    // Route::get('/progress/export', [ProgressController::class, 'progress_export'])->name('progress.export');

    // Route Completed Complaint
    // Route::get('/completed', [CompletedController::class, 'index'])->name('completed');
    // Route::post('/completed', [CompletedController::class, 'index'])->name('completed.filter');
    // Route::get('/completed/export', [CompletedController::class, 'completed_export'])->name('completed.export');


    // Route Hold Complaint
    // Route::get('/hold', [HoldController::class, 'index'])->name('hold');
    // Route::get('/hold/export', [HoldController::class, 'hold_export'])->name('hold.export');


    // Route Need Complaint
    // Route::get('/need', [NeedController::class, 'index'])->name('need');
    // Route::get('/need/create/{id?}', [NeedController::class, 'need_create'])->name('need.create')->where('id', '.*');
    // Route::post('/need/store', [NeedController::class, 'need_store'])->name('need.store');
    // Route::get('/need/export', [NeedController::class, 'need_export'])->name('need.export');
});

Route::get('/home', function () {
    return redirect()->route('dashboard.admin');
});
