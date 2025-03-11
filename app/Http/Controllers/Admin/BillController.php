<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Major;
use App\Models\PaymentType;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Bill::all();
        $dataJurusan = Major::all();
        $dataPembayaran = PaymentType::all();
        $dataGelombang =  Registration::select('name')->distinct()->get();
        $dataAngkatan =  Registration::select('year')->distinct()->get();
        return view('admin.bill.index', compact('data', 'dataJurusan', 'dataPembayaran', 'dataGelombang', 'dataAngkatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataPembayaran = PaymentType::all();
        $dataJurusan = Major::all();
        $dataGelombang = Registration::all();
        return view('admin.bill.create', compact('dataJurusan', 'dataGelombang', 'dataPembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $amount = str_replace('.', '', $request->amount);
        $request->validate([
            'major_id' => 'required|exists:majors,id',
            'registration_id' => 'required|exists:registrations,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'amount' => 'required',
        ]);


        try {
            if ($request->student_option === 'all') {
                $students = Student::where('major_id', $request->major_id)
                    ->where('registration_id', $request->registration_id)
                    ->get();
            } else {
                $students = Student::whereIn('id', $request->student_ids)->get();
            }

            foreach ($students as $student) {
                Bill::create([
                    'student_id' => $student->id,
                    'payment_type_id' => $request->payment_type_id,
                    'amount' => $amount,
                    'status' => 'pending',
                ]);
            }

            return redirect()->route('admin.tagihan.index')->with('success', "Tagihan berhasil ditambahkan");
        } catch (\Throwable $th) {
            return redirect()->route('admin.tagihan.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function getStudents(Request $request)
    {
        $students = Student::where('major_id', $request->major_id)
            ->where('registration_id', $request->registration_id)
            ->with('user')
            ->get();

        $formattedStudents = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->user->name,
                'nim' => $student->user->nim
            ];
        });

        return response()->json($formattedStudents);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Bill::find($id);
        $data->amount = number_format($data->amount, 0, ',', '.');
        return view('admin.bill.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $amount = str_replace('.', '', $request->amount);

        $request->validate([
            'amount' => 'required',
        ]);

        try {
            Bill::find($id)->update([
                'amount' => $amount,
            ]);
            return redirect()->route('admin.tagihan.index')->with('success', "Tagihan berhasil diperbaruhi");
        } catch (\Throwable $th) {
            return redirect()->route('admin.tagihan.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Bill::find($id)->delete();
            return redirect()->route('admin.tagihan.index')->with('success', "Tagihan berhasil dihapus");
        } catch (\Throwable $th) {
            return redirect()->route('admin.tagihan.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
