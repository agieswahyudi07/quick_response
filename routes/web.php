<?php

use App\Http\Controllers\QueueController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\CompletedController;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\NeedController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route Queue Complaint
Route::get('/queue', [QueueController::class, 'index'])->name('queue');
Route::get('/queue/create', [QueueController::class, 'queue_create'])->name('queue.create');
Route::post('/queue/store', [QueueController::class, 'queue_store'])->name('queue.store');
Route::get('/queue/process/{id}', [QueueController::class, 'queue_process'])->name('queue.process');
Route::get('/queue/edit/{id}', [QueueController::class, 'queue_edit'])->name('queue.edit');
Route::put('/queue/update/{id}', [QueueController::class, 'queue_update'])->name('queue.update');
Route::delete('/queue/destroy/{id}', [QueueController::class, 'queue_destroy'])->name('queue.destroy');
Route::get('/queue/export', [QueueController::class, 'queue_export'])->name('queue.export');


// Route On Progress Complaint
Route::get('/progress', [ProgressController::class, 'index'])->name('progress');
Route::get('/progress/create', [ProgressController::class, 'progress_create'])->name('progress.create');
Route::post('/progress/store', [ProgressController::class, 'progress_store'])->name('progress.store');
Route::get('/progress/completed/{id}', [ProgressController::class, 'progress_completed'])->name('progress.completed');
Route::get('/progress/cancel/{id}', [ProgressController::class, 'progress_cancel'])->name('progress.cancel');
Route::get('/progress/hold/create/{id?}', [ProgressController::class, 'progress_hold_create'])->name('progress.hold.create')->where('id', '.*');;
Route::post('/progress/hold/store', [ProgressController::class, 'progress_hold_store'])->name('progress.hold.store');
Route::get('/progress/export', [ProgressController::class, 'progress_export'])->name('progress.export');

// Route Completed Complaint
Route::get('/completed', [CompletedController::class, 'index'])->name('completed');
Route::post('/completed', [CompletedController::class, 'index'])->name('completed.filter');
Route::get('/completed/create', [CompletedController::class, 'completed_create'])->name('completed.create');
Route::post('/completed/store', [CompletedController::class, 'completed_store'])->name('completed.store');
Route::get('/completed/process/{id}', [CompletedController::class, 'completed_process'])->name('completed.process');
Route::get('/completed/edit/{id}', [CompletedController::class, 'completed_edit'])->name('completed.edit');
Route::put('/completed/update/{id}', [CompletedController::class, 'completed_update'])->name('completed.update');
Route::delete('/completed/destroy/{id}', [CompletedController::class, 'completed_destroy'])->name('completed.destroy');
Route::get('/completed/export', [CompletedController::class, 'completed_export'])->name('completed.export');


// Route Hold Complaint
Route::get('/hold', [HoldController::class, 'index'])->name('hold');
Route::get('/hold/export', [HoldController::class, 'hold_export'])->name('hold.export');


// Route Need Complaint
Route::get('/need', [NeedController::class, 'index'])->name('need');
Route::get('/need/create/{id?}', [NeedController::class, 'need_create'])->name('need.create')->where('id', '.*');
Route::post('/need/store', [NeedController::class, 'need_store'])->name('need.store');
Route::get('/need/process/{id}', [NeedController::class, 'need_process'])->name('need.process');
Route::get('/need/edit/{id}', [NeedController::class, 'need_edit'])->name('need.edit');
Route::put('/need/update/{id}', [NeedController::class, 'need_update'])->name('need.update');
Route::delete('/need/destroy/{id}', [NeedController::class, 'need_destroy'])->name('need.destroy');
Route::get('/need/export', [NeedController::class, 'need_export'])->name('need.export');
