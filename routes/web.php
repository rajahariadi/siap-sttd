<?php

use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\PaymentTypeController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Student\BillPaymentController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\HistoryPaymentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });




Route::middleware('auth')->group(function () {
    Route::group(['as' => 'admin.'], function () {

        Route::get('/', [DashboardController::class, 'index']);
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('laporan', [ReportController::class, 'index'])->name('laporan');

        Route::resources([
            'tagihan' => BillController::class,
            'jenis-pembayaran' => PaymentTypeController::class,
            'mahasiswa' => StudentController::class,
            'jurusan' => MajorController::class,
            'gelombang' => RegistrationController::class,
        ]);
    });


    Route::group(['as' => 'mahasiswa.'], function () {

        Route::get('view/mahasiswa', [StudentDashboardController::class, 'index'])->name('dashboard');

        Route::post('/midtrans/notification', [BillPaymentController::class, 'handleNotification'])->name('midtrans.notification');
        Route::get('/bill/pay/{bill_id}', [BillPaymentController::class, 'pay'])->name('bill.pay');
        Route::get('view/mahasiswa/bill_payment', [BillPaymentController::class, 'index'])->name('bill_payment');

        Route::get('view/mahasiswa/history_payment', [HistoryPaymentController::class, 'index'])->name('history_payment');
        //     Route::get('mahasiswa/dashboard', [StudentDashboardController::class, 'index']);

    });
});
