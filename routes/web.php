<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::resource('group', App\Http\Controllers\GroupController::class)->only(['show', 'update', 'destroy']);
Route::resource('task', App\Http\Controllers\TaskController::class)->only(['store', 'update', 'destroy', 'show']);
Route::get('/', [App\Http\Controllers\GroupController::class, 'index'])->name('home');
