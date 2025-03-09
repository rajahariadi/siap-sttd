<?php

use App\Http\Controllers\Student\BillPaymentController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\HistoryPaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {

    Route::name('mahasiswa.')->group(function () {

        Route::get('home', [DashboardController::class, 'index'])->name('home');

        Route::post('/midtrans/notification', [BillPaymentController::class, 'handleNotification'])->name('midtrans.notification');
        Route::get('/bill/pay/{bill_id}', [BillPaymentController::class, 'pay'])->name('bill.pay');
        Route::get('bill-payment', [BillPaymentController::class, 'index'])->name('bill-payment');

        Route::get('history-payment', [HistoryPaymentController::class, 'index'])->name('history-payment');
        Route::get('history-payment/invoice/{transaction_id}', [HistoryPaymentController::class, 'showInvoice'])->name('invoice');
    });
});
