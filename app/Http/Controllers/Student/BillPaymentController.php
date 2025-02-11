<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class BillPaymentController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data student berdasarkan user_id
        $student = Student::where('user_id', $user->id)->first();

        if ($student) {
            // Ambil data bills berdasarkan student_id
            $data = Bill::where('student_id', $student->id)->where('status', 'pending')->get();

            // Kirim data bills ke view
            return view('mahasiswa.bill_payment.index', compact('data'));
        }

        // Jika student tidak ditemukan, kembalikan ke view dengan pesan error
        return view('mahasiswa.bill_payment.index')->with('error', 'Student data not found.');
    }

    public function pay($bill_id)
    {
        // Ambil data tagihan berdasarkan ID
        $bill = Bill::findOrFail($bill_id);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat transaksi Midtrans
        $transaction_details = [
            'order_id' => 'STTD-BILL-' . $bill->student->user->nim . '-' . time(), // ID unik untuk transaksi
            'gross_amount' => $bill->amount, // Jumlah pembayaran
        ];

        $customer_details = [
            'first_name' => $bill->student->user->name,
            'email' => $bill->student->user->email,
            'phone' => $bill->student->phone,
        ];

        $custom_expiry = [
            'expiry_duration' => 30, // Durasi dalam menit
            'unit' => 'minute', // Satuan waktu (minute)
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'custom_expiry' => $custom_expiry, // Tambahkan custom expiry
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Kembalikan Snap Token dalam format JSON
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to initialize payment: ' . $e->getMessage()], 500);
        }
    }
}
