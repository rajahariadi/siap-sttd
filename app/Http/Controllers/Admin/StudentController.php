<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::all();
        return view('admin.student.index', compact('data'));
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
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8',

            'major_id' => 'required|exists:majors,id',
            'registration_id' => 'required|exists:registrations,id',
            'nim' => 'required|string|max:20|unique:students',
            'phone' => 'required|string|max:20|unique:students',
            'birthdate' => 'required',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
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
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
            ]);

            $mahasiswa = Student::create([
                'user_id' => $user->id,
                'major_id' => $request->major_id,
                'registration_id' => $request->registration_id,
                'nim' => $request->nim,
                'phone' => $request->phone,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'address' => $request->address,
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

            'major_id' => 'required|exists:majors,id',
            'registration_id' => 'required|exists:registrations,id',
            'nim' => 'required|string|max:20|unique:students,nim,' . $id . ',id',
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
            ]);

            $mahasiswa = Student::find($id)->update([
                'major_id' => $request->major_id,
                'registration_id' => $request->registration_id,
                'nim' => $request->nim,
                'phone' => $request->phone,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'address' => $request->address,
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
}
