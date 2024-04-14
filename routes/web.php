<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\GroupController::class, 'index'])->name('home');
