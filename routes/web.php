<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

///para generar la factur


Route::get('/facturas/{id}/pdf', [FacturaController::class, 'generarPDF'])->name('print.factura');

//para los salarios


Route::get('generate-pdf/{month}/{year}', [PayrollController::class, 'generatePayrollPDF'])->name('generate-pdf');;

require __DIR__.'/auth.php';
