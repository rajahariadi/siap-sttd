<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Major;
use App\Models\Registration;
use App\Models\StatusStudent;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::all();
        $dataJurusan = Major::all();
        $dataGelombang =  Registration::select('name')->distinct()->get();
        $dataAngkatan =  Registration::select('year')->distinct()->get();
        $dataStatus = StatusStudent::all();
        return view('admin.student.index', compact('data', 'dataJurusan', 'dataGelombang', 'dataAngkatan', 'dataStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataJurusan = Major::all();
        $dataGelombang = Registration::all();
        return view('admin.student.create', compact('dataJurusan', 'dataGelombang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nim' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8',

            'major_id' => 'required|exists:majors,id',
            'registration_id' => 'required|exists:registrations,id',
            'phone' => 'required|string|max:20|unique:students',
            'birthdate' => 'required',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $request->nim . '_' . str_replace(' ', '_', $request->name) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('mahasiswa', $imageName, 'public');
                $imagePath = 'mahasiswa/' . $imageName;
            } else {
                return redirect()->route('admin.mahasiswa.create')->with('error', 'No image file uploaded.');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nim' => $request->nim,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
            ]);

            $mahasiswa = Student::create([
                'user_id' => $user->id,
                'major_id' => $request->major_id,
                'registration_id' => $request->registration_id,
                'phone' => $request->phone,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'address' => $request->address,
                'status' => 'P',
                'image' => $imagePath,
            ]);

            DB::commit();

            return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin.mahasiswa.index')->with('error', $th->getMessage());
        }
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
        $data = Student::find($id);
        $dataJurusan = Major::all();
        $dataGelombang = Registration::all();
        return view('admin.student.edit', compact('dataJurusan', 'dataGelombang', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id . ',id',
            'nim' => 'required|string|max:20|unique:users,nim,' . $student->user_id . ',id',

            'major_id' => 'required|exists:majors,id',
            'registration_id' => 'required|exists:registrations,id',
            'phone' => 'required|string|max:20|unique:students,phone,' . $id . ',id',
            'birthdate' => 'required',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $request->nim . '_' . str_replace(' ', '_', $request->name) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('mahasiswa', $imageName, 'public');
                $imagePath = 'mahasiswa/' . $imageName;
            } else {
                $imagePath = $student->image;
            }

            $user = User::find($student->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'nim' => $request->nim,
            ]);

            $mahasiswa = Student::find($id)->update([
                'major_id' => $request->major_id,
                'registration_id' => $request->registration_id,
                'phone' => $request->phone,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'address' => $request->address,
                'status' => 'P',
                'image' => $imagePath,
            ]);

            DB::commit();

            return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbaruhi');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin.mahasiswa.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $student = Student::find($id);
            $user_id = $student->user_id;
            $student->delete();
            User::where('id', $user_id)->delete();

            DB::commit();

            return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa dan akun pengguna berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin.mahasiswa.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        DB::beginTransaction();

        try {
            Excel::import(new StudentsImport, $request->file('file')); // Pastikan ini benar

            DB::commit();

            return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diimport');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin.mahasiswa.index')->with('error', $th->getMessage());
        }
    }

    public function sinkron(Request $request)
    {
        $url = env('API_SIA_MAHASISWA', '');
        $token = env('API_SIA_TOKEN', '');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($url);

        if ($response->successful()) {
            $data = $response->json();

            DB::beginTransaction();
            try {
                foreach ($data['data'] as $student) {

                    if ($student['kode_jurusan'] == '0') {
                        continue;
                    }

                    if ($student['TanggalLahir'] == '0000-00-00') {
                        continue;
                    }

                    $email = ($student['Email'] == '' || $student['Email'] == '-') ? null : $student['Email'];

                    if ($email !== null) {
                        $existingUser = User::where('email', $email)->first();
                        if ($existingUser) {
                            $email = null;
                        }
                    }

                    $user = User::updateOrCreate(
                        ['nim' => $student['NIM']],
                        [
                            'name' => Str::upper($student['Nama']),
                            'email' => $email,
                            'password' => Hash::make($student['NIM']),
                            'role' => 'mahasiswa',
                        ]
                    );

                    $major = Major::where('code', $student['kode_jurusan'])->first();

                    $status = StatusStudent::where('id', $student['StatusMhsw_ID'])->first();

                    $year = $student['Angkatan'];
                    $registrations = Registration::where('year', $year)->get();
                    if ($registrations->isEmpty()) {
                        $registration = Registration::create([
                            'name' => 'Gelombang 1',
                            'year' => $year,
                        ]);
                    } else {
                        $registration = $registrations->random();
                    }

                    if (!$registration) {
                        throw new \Exception("Registrasi untuk tahun $year tidak ditemukan atau gagal dibuat.");
                    }

                    $semester_fee = 3000000;
                    if (Str::contains($registration->name, 'Gelombang II')) {
                        $semester_fee = 3250000;
                    } elseif (Str::contains($registration->name, 'Gelombang III')) {
                        $semester_fee = 3500000;
                    }

                    Student::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'major_id' => $major->id,
                            'registration_id' => $registration->id,
                            'phone' => $student['Telepon'],
                            'birthdate' => $student['TanggalLahir'],
                            'gender' => $student['Kelamin'],
                            'address' => $student['Alamat'],
                            'semester_fee' => $semester_fee,
                            'status' => 'P',
                            'image' => null,
                        ]
                    );
                }

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data mahasiswa berhasil disinkronkan.',
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyinkronkan data: ' . $th->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari API.',
            ]);
        }
    }
}
