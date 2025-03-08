<?php

use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\PaymentTypeController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::name('admin.')->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('laporan', [ReportController::class, 'index'])->name('laporan');

        Route::post('mahasiswa/import', [StudentController::class, 'import'])->name('mahasiswa.import');

        Route::post('jurusan/sinkron', [MajorController::class, 'sinkron'])->name('jurusan.sinkron');

        Route::resources([
            'tagihan' => BillController::class,
            'jenis-pembayaran' => PaymentTypeController::class,
            'mahasiswa' => StudentController::class,
            'jurusan' => MajorController::class,
            'gelombang' => RegistrationController::class,
        ]);
    });
});
