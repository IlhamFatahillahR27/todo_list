<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::resource('group', App\Http\Controllers\GroupController::class)->only(['show', 'update']);
Route::get('/', [App\Http\Controllers\GroupController::class, 'index'])->name('home');
