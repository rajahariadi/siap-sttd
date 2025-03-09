<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class HistoryPaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data student berdasarkan user_id
        $student = Student::where('user_id', $user->id)->first();

        if ($student) {
            // Ambil data bills berdasarkan student_id
            $bills = Bill::where('student_id', $student->id)->where('status', 'paid')->get();

            // Ambil semua bill_id dari bills yang sudah dibayar
            $billIds = $bills->pluck('id');

            // Ambil data payments berdasarkan bill_id
            $payments = Payment::whereIn('bill_id', $billIds)
                ->whereIn('status', ['success', 'failed']) // Hanya ambil status success dan failed
                ->orderBy('updated_at', 'desc')
                ->get();


            // Kirim data payments ke view
            return view('mahasiswa.history_payment.index', compact('payments'));
        }

        // Jika student tidak ditemukan, kembalikan ke view dengan pesan error
        return view('mahasiswa.history_payment.index')->with('error', 'Student data not found.');
    }

    public function showInvoice($transaction_id)
    {
        $payment = Payment::where('transaction_id', $transaction_id)->firstOrFail();
        return view('invoice', compact('payment'));
    }
}
