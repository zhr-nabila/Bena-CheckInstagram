<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;

Route::get('/', [CheckController::class, 'index'])->name('upload.page');
Route::post('/process', [CheckController::class, 'process'])->name('process.data');
Route::post('/download-csv', [CheckController::class, 'downloadCsv'])->name('download.csv');
Route::post('/download-pdf', [CheckController::class, 'downloadPdf'])->name('download.pdf');
