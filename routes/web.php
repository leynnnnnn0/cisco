<?php

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;


Route::get('generate-pdf', [PDFController::class, 'generatePdf']);
Route::get('pdf', [PDFController::class, 'index'])->name('pdf');

Route::get('/excel', [ExcelController::class, 'index'])->name('excel');
Route::get('status/export/{id}/{from}/{to}', [StatusController::class, 'export', 'id', 'from', 'to']);
Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll');
Route::post('/end-of-shift', [StatusController::class, 'destroy'])->middleware('auth');
Route::get('employees-tag', [StatusController::class, 'index'])->middleware('auth');
Route::post('request-user-tags', [StatusController::class, 'search'])->middleware('auth');
Route::post('/change-status', [StatusController::class, 'update']);
Route::post('/tags', [StatusController::class, 'tags']);
Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/tags-history', [StatusController::class, 'getTags'])->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
