<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $dataTagihan = Bill::where('student_id', $student->id)
            ->where('status', 'pending')->count();

        $dataJumlahTagihan = Bill::where('student_id', $student->id)
            ->where('status', 'pending')
            ->sum('amount');

        $dataTagihanDibayar = Bill::where('student_id', $student->id)
            ->where('status', 'paid')->count();

        $dataJumlahTagihanDibayar = Bill::where('student_id', $student->id)
            ->where('status', 'paid')
            ->sum('amount');

        $dataTransaksi = Payment::whereHas('bill', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })
            ->where('status', ['success', 'failed'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('mahasiswa.dashboard.index', compact('dataTagihan', 'dataJumlahTagihan', 'dataTagihanDibayar', 'dataJumlahTagihanDibayar', 'dataTransaksi'));
    }
}
