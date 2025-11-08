<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;

Route::get('/', [CheckController::class, 'index'])->name('upload.page');
Route::post('/check-unfollow', [CheckController::class, 'checkUnfollow'])->name('check.unfollow');
