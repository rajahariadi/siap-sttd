<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
