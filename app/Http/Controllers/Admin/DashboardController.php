<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Student::all()->count();
        $totalJurusan = Major::all()->count();
        $totalPendapatan = Payment::where('status', 'success')->sum('amount');

        $dataTransaksi = Payment::whereIn('status', ['success', 'failed'])
            ->orderBy('updated_at', 'desc')
            ->take(8)
            ->get();

        // Mengambil data jurusan berdasarkan kode T-INF, T-IND, T-SIP
        $jurusanCodes = ['T-INF', 'T-IND', 'T-SIP'];
        $majors = Major::whereIn('code', $jurusanCodes)->get();

        // Menghitung jumlah mahasiswa yang belum bayar (pending) per jurusan
        $mahasiswaBelumBayar = DB::table('students')
            ->join('bills', 'students.id', '=', 'bills.student_id')
            ->where('bills.status', 'pending')
            ->whereIn('students.major_id', $majors->pluck('id')) // Filter berdasarkan ID jurusan yang diambil
            ->select('students.major_id', DB::raw('count(distinct students.id) as total')) // Menghitung jumlah mahasiswa unik
            ->groupBy('students.major_id')
            ->get();

        // Menghitung total tagihan yang belum dibayar (pending) untuk semua jurusan
        $totalTagihanBelumBayar = $mahasiswaBelumBayar->sum('total');

        // Format data untuk dikirim ke view
        $jumlahBelumBayar = []; // Untuk series di script (jumlah mahasiswa)
        $persentaseBelumBayar = []; // Untuk ditampilkan di blade (persentase)
        foreach ($majors as $major) {
            $belumBayar = $mahasiswaBelumBayar->where('major_id', $major->id)->first();
            $jumlah = $belumBayar ? $belumBayar->total : 0;
            $persentase = $totalTagihanBelumBayar > 0 ? ($jumlah / $totalTagihanBelumBayar) * 100 : 0;

            $jumlahBelumBayar[$major->code] = $jumlah; // Jumlah mahasiswa
            $persentaseBelumBayar[$major->code] = round($persentase, 2); // Persentase
        }

        $pendapatanPerJurusan = DB::table('students')
            ->join('bills', 'students.id', '=', 'bills.student_id')
            ->join('payments', 'bills.id', '=', 'payments.bill_id')
            ->where('payments.status', 'success') // Hitung pendapatan dari tagihan yang berhasil dibayar
            ->whereIn('students.major_id', $majors->pluck('id')) // Filter berdasarkan ID jurusan yang diambil
            ->select('students.major_id', DB::raw('sum(payments.amount) as total'))
            ->groupBy('students.major_id')
            ->get();

        // Menghitung total pendapatan semua jurusan
        $totalPendapatanJurusan = $pendapatanPerJurusan->sum('total');

        // Format data untuk dikirim ke view
        $jumlahPendapatan = []; // Untuk ditampilkan di blade (jumlah pendapatan)
        $persentasePendapatan = []; // Untuk script chart (persentase pendapatan)
        foreach ($majors as $major) {
            $pendapatan = $pendapatanPerJurusan->where('major_id', $major->id)->first();
            $total = $pendapatan ? $pendapatan->total : 0;
            $persentase = $totalPendapatanJurusan > 0 ? ($total / $totalPendapatanJurusan) * 100 : 0;

            $jumlahPendapatan[$major->code] = $total; // Jumlah pendapatan
            $persentasePendapatan[$major->code] = round($persentase, 2); // Persentase pendapatan
        }

        return view('admin.dashboard.index', compact(
            'totalMahasiswa',
            'totalJurusan',
            'totalPendapatan',
            'dataTransaksi',
            'jumlahBelumBayar',
            'persentaseBelumBayar',
            'jumlahPendapatan',
            'persentasePendapatan'
        ));
    }
}
