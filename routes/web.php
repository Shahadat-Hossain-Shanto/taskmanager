<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TaskController::class, 'create'])->name('tasks.create');
Route::get('/task-list', [TaskController::class, 'index'])->name('tasks.list');
Route::post('/task-create', [TaskController::class, 'store'])->name('tasks.store');

Route::get('/task-list-data', [TaskController::class, 'data'])->name('tasks.data');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/readme', [TaskController::class, 'readme'])->name('readme');
