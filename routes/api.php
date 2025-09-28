<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/task-store', [TaskController::class, 'apiStore'])->middleware('throttle:100,1');
