<?php

namespace App\Imports;

use App\Models\Major;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            // Validasi data
            if (empty($row['nama']) || empty($row['email']) || empty($row['nim']) || empty($row['jurusan']) || empty($row['pendaftaran']) || empty($row['tahun_masuk']) || empty($row['no_hp']) || empty($row['tanggal_lahir']) || empty($row['jenis_kelamin']) || empty($row['alamat'])) {
                throw new \Exception("Data tidak lengkap");
            }

            // Cek apakah email atau nim sudah ada
            if (User::where('email', $row['email'])->exists() || User::where('nim', $row['nim'])->exists()) {
                throw new \Exception("Email atau NIM sudah terdaftar");
            }

            // Cek apakah nomor hp sudah ada
            if (Student::where('phone', $row['no_hp'])->exists()) {
                throw new \Exception("Nomor telepon sudah terdaftar");
            }

            // Cari major_id berdasarkan nama jurusan
            $major = Major::where('name', $row['jurusan'])->first();
            if (!$major) {
                throw new \Exception("Jurusan '{$row['jurusan']}' tidak ditemukan di database");
            }

            // Cari registration_id berdasarkan nama pendaftaran dan tahun
            $registration = Registration::where('name', $row['pendaftaran'])
                ->where('year', $row['tahun_masuk'])
                ->first();
            if (!$registration) {
                throw new \Exception("Pendaftaran '{$row['pendaftaran']}' dengan tahun '{$row['tahun_masuk']}' tidak ditemukan di database");
            }

            // Konversi tanggal lahir ke format Y-m-d
            $birthdate = Carbon::createFromFormat('d F Y', $row['tanggal_lahir'])->format('Y-m-d');

            // Buat user
            $user = User::create([
                'name' => $row['nama'],
                'email' => $row['email'],
                'nim' => $row['nim'],
                'password' => Hash::make('12345678'), // Default password
                'role' => 'mahasiswa',
            ]);

            // Buat student
            $student = Student::create([
                'user_id' => $user->id,
                'major_id' => $major->id,
                'registration_id' => $registration->id,
                'phone' => $row['no_hp'],
                'birthdate' => $birthdate,
                'gender' => $row['jenis_kelamin'],
                'address' => $row['alamat'],
                'image' => 'default.jpg', // Default image
            ]);

            DB::commit();

            return $student;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
