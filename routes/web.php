<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\NeedController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CompletedController;
use App\Http\Controllers\DashboardController;

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


Route::get('/', [SesiController::class, 'index'])->name('login')->middleware('guest');
Route::get('/login', [SesiController::class, 'index'])->name('login.form')->middleware('guest');
Route::post('/login', [SesiController::class, 'login'])->name('login.submit')->middleware('guest');

Route::get('/home', function () {
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'user') {
        return redirect()->route('user.dashboard');
    }
});


Route::group(['prefix' => 'admin', 'middleware' => ['roleAcces:admin'], 'as' => 'admin.'], function () {

    // START ROUTE ADMIN=================================================================================================================================   // ROUTE ADMIN
    Route::get('/dashboard', [DashboardController::class, 'dashboard_admin'])->name('dashboard');
    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');

    // complaint admin 
    Route::get('/complaint', [ComplaintController::class, 'index_admin'])->name('complaint');
    Route::get('/complaint/show/{id}', [ComplaintController::class, 'complaint_show_admin'])->name('complaint.show');
    Route::get('/complaint/export', [ComplaintController::class, 'complaint_export'])->name('complaint.export');


    // queue admin
    Route::get('/queue', [QueueController::class, 'index_admin'])->name('queue');
    Route::get('/queue/create', [QueueController::class, 'queue_create'])->name('queue.create');
    Route::post('/queue/store', [QueueController::class, 'queue_store'])->name('queue.store');
    Route::get('/queue/edit/{id}', [QueueController::class, 'queue_edit'])->name('queue.edit');
    Route::put('/queue/update/{id}', [QueueController::class, 'queue_update'])->name('queue.update');
    Route::get('/queue/process/{id}', [QueueController::class, 'queue_process'])->name('queue.process');
    Route::get('/queue/show/{id}', [QueueController::class, 'queue_show_admin'])->name('queue.show');
    Route::get('/queue/export', [QueueController::class, 'queue_export'])->name('queue.export');
    Route::delete('/queue/destroy/{id}', [QueueController::class, 'queue_destroy'])->name('queue.destroy');


    // progress admin
    Route::get('/progress', [ProgressController::class, 'index_admin'])->name('progress');
    Route::get('/progress/cancel/{id}', [ProgressController::class, 'progress_cancel'])->name('progress.cancel');

    Route::get('/progress/show/{id}', [ProgressController::class, 'progress_show_admin'])->name('progress.show');

    Route::get('/progress/completed/create/{id?}', [ProgressController::class, 'progress_completed_create'])->name('progress.completed.create')->where('id', '.*');;
    Route::post('/progress/completed/store', [ProgressController::class, 'progress_completed_store'])->name('progress.completed.store');

    Route::get('/progress/hold/create/{id?}', [ProgressController::class, 'progress_hold_create'])->name('progress.hold.create')->where('id', '.*');;
    Route::post('/progress/hold/store', [ProgressController::class, 'progress_hold_store'])->name('progress.hold.store');

    Route::get('/progress/export', [ProgressController::class, 'progress_export'])->name('progress.export');


    // completed admin  
    Route::get('/completed', [CompletedController::class, 'index_admin'])->name('completed');
    Route::post('/completed', [CompletedController::class, 'index_admin'])->name('completed.filter');
    Route::get('/completed/show/{id}', [CompletedController::class, 'completed_show_admin'])->name('completed.show');
    Route::get('/completed/export', [CompletedController::class, 'completed_export'])->name('completed.export');


    // hold admin
    Route::get('/hold', [HoldController::class, 'index_admin'])->name('hold');
    Route::get('/hold/process/{id}', [HoldController::class, 'hold_process'])->name('hold.process');
    Route::get('/hold/show/{id}', [HoldController::class, 'hold_show_admin'])->name('hold.show');
    Route::get('/hold/export', [HoldController::class, 'hold_export'])->name('hold.export');


    // need admin
    Route::get('/need', [NeedController::class, 'index_admin'])->name('need');
    Route::get('/need/create/{id?}', [NeedController::class, 'need_create'])->name('need.create')->where('id', '.*');
    Route::post('/need/store', [NeedController::class, 'need_store'])->name('need.store');
    Route::get('/need/export', [NeedController::class, 'need_export'])->name('need.export');




    // END ROUTE ADMIN================================================================================================================================= // END ROUTE ADMI
});


Route::group(['prefix' => 'user', 'middleware' => ['roleAcces:user'], 'as' => 'user.'], function () {

    // START ROUTE USER==============================================================================================// START ROUTE USER
    Route::get('/dashboard', [DashboardController::class, 'dashboard_user'])->name('dashboard');
    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');

    // complaint admin 
    Route::get('/complaint', [ComplaintController::class, 'index_user'])->name('complaint');
    Route::get('/complaint/show/{id}', [ComplaintController::class, 'complaint_show_user'])->name('complaint.show');
    Route::get('/complaint/export', [ComplaintController::class, 'complaint_export'])->name('complaint.export');

    // queue user
    Route::get('/queue', [QueueController::class, 'index_user'])->name('queue');
    Route::get('/queue/show/{id}', [QueueController::class, 'queue_show_user'])->name('queue.show');
    Route::get('/queue/export', [QueueController::class, 'queue_export'])->name('queue.export');


    // progress user
    Route::get('/progress', [ProgressController::class, 'index_user'])->name('progress');
    Route::get('/progress/show/{id}', [ProgressController::class, 'progress_show_user'])->name('progress.show');
    Route::get('/progress/export', [ProgressController::class, 'progress_export'])->name('progress.export');


    // completed user  
    Route::get('/completed', [CompletedController::class, 'index_user'])->name('completed');
    Route::get('/completed/show/{id}', [CompletedController::class, 'completed_show_user'])->name('completed.show');
    Route::post('/completed', [CompletedController::class, 'index_user'])->name('completed.filter');
    Route::get('/completed/export', [CompletedController::class, 'completed_export'])->name('completed.export');


    // hold user
    Route::get('/hold', [HoldController::class, 'index_user'])->name('hold');
    Route::get('/hold/show/{id}', [HoldController::class, 'hold_show_user'])->name('hold.show');
    Route::get('/hold/export', [HoldController::class, 'hold_export'])->name('hold.export');


    // need user
    Route::get('/need', [NeedController::class, 'index_user'])->name('need');
    Route::get('/need/export', [NeedController::class, 'need_export'])->name('need.export');



    // END ROUTE USER==============================================================================================// START ROUTE USER

});
