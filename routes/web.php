<?php

use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\PaymentTypeController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['as' => 'admin.'], function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'tagihan' => BillController::class,
        'jenis-pembayaran' => PaymentTypeController::class,
        'mahasiswa' => StudentController::class,
        'jurusan' => MajorController::class,
        'gelombang' => RegistrationController::class,
    ]);
});
