<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;

Route::get('/', [CheckController::class, 'index'])->name('check.index');
Route::post('/process', [CheckController::class, 'process'])->name('check.process');
