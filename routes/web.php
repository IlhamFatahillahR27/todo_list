<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::resource('group', App\Http\Controllers\GroupController::class)->only(['store', 'update', 'destroy']);
Route::resource('task', App\Http\Controllers\TaskController::class)->only(['store', 'update', 'destroy']);
Route::get('/', [App\Http\Controllers\GroupController::class, 'index'])->name('home');
Route::get('task/findByName', [App\Http\Controllers\GroupController::class, 'findByName'])->name('task.findByName');
Route::post('task/updateGroup', [App\Http\Controllers\TaskController::class, 'updateGroup'])->name('task.updateGroup');
