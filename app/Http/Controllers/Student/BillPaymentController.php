<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Mail\PaymentSuccessMail;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        // Buat order_id unik
        $orderId = 'SIAP-' . $bill->student->user->nim . '-' . date('Hi');

        // Buat transaksi Midtrans
        $transaction_details = [
            'order_id' => $orderId, // ID unik untuk transaksi
            'gross_amount' => $bill->amount, // Jumlah pembayaran
        ];

        $customer_details = [
            'first_name' => $bill->student->user->name,
            'email' => $bill->student->user->email,
            'phone' => $bill->student->phone,
        ];

        // Tambahkan custom expiry (30 menit)
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

            // Simpan data transaksi ke tabel payments
            $payment = Payment::create([
                'bill_id' => $bill->id,
                'transaction_id' => $orderId, // Simpan order_id sebagai transaction_id
                'payment_method' => '-', // Metode pembayaran
                'amount' => $bill->amount, // Jumlah pembayaran
                'status' => 'pending', // Status awal
                'midtrans_response' => json_encode(['snap_token' => $snapToken]), // Simpan Snap Token
            ]);

            // Kembalikan Snap Token dan orderId dalam format JSON
            return response()->json(['snapToken' => $snapToken, 'orderId' => $orderId]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to initialize payment: ' . $e->getMessage()], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        $payload = $request->all();

        $orderId = $payload['order_id'];

        $payment = Payment::where('transaction_id', $orderId)->first();

        if ($payment) {
            if (isset($payload['transaction_status'])) {
                if ($payload['transaction_status'] === 'settlement') {
                    $payment->status = 'success';
                    session()->flash('success', 'Pembayaran berhasil!');
                    // Mail::to($payment->bill->student->user->email)->send(new PaymentSuccessMail($payment));
                } elseif (in_array($payload['transaction_status'], ['expire', 'cancel', 'deny', 'failed'])) {
                    $payment->status = 'failed';
                    session()->flash('error', 'Pembayaran gagal!');
                } elseif ($payload['transaction_status'] === 'pending') {
                    $payment->status = 'pending';
                }
            } else {
                $payment->status = 'failed';
                session()->flash('error', 'Pembayaran gagal!');
            }

            if (isset($payload['payment_type'])) {
                $payment->payment_method = $payload['payment_type'];
            }

            $payment->midtrans_response = json_encode($payload);
            $payment->save();

            if ($payment->status === 'success') {
                $bill = $payment->bill;
                $bill->status = 'paid';
                $bill->save();

                if (stripos($bill->payment_type->name, 'semester') !== false) {
                    $student = $bill->student;
                    $student->status = 'A';
                    $student->save();
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
