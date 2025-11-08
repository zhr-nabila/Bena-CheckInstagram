<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;

// Routes dengan language support
Route::get('/', [CheckController::class, 'index'])->name('upload.page');
Route::post('/process', [CheckController::class, 'process'])->name('process.data');
Route::post('/download-pdf', [AppController::class, 'downloadPDF'])->name('download.pdf');
Route::get('/switch-language/{locale}', [CheckController::class, 'switchLanguage'])->name('switch.language');