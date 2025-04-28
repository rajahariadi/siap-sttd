<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run()
    {
        $users = DB::table('users')
            ->where('role', 'mahasiswa')
            ->whereNotIn('id', function ($query) {
                $query->select('user_id')->from('students');
            })
            ->get();

        if ($users->isEmpty()) {
            $this->command->info('Tidak ada user mahasiswa baru, skip student seeder');
            return;
        }

        $majors = [
            '55201' => Major::where('code', '55201')->first()->id,
            '26201' => Major::where('code', '26201')->first()->id,
            '22201' => Major::where('code', '22201')->first()->id
        ];

        $registrations = Registration::all();

        foreach ($users as $user) {
            $kodeJurusan = substr($user->nim, 2, 5);
            $majorId = $majors[$kodeJurusan] ?? $majors['55201'];
            $randomRegistration = $registrations->random();

            Student::create([
                'user_id' => $user->id,
                'major_id' => $majorId,
                'registration_id' => $randomRegistration->id,
                'phone' => '08' . rand(11, 99) . rand(1000000, 9999999),
                'birthdate' => fake()->dateTimeBetween('-22 years', '-18 years')->format('Y-m-d'),
                'gender' => rand(0, 1) ? 'L' : 'P',
                'address' => fake()->address(),
                'semester_fee' => rand(2000000, 3500000),
                'status' => 'P',
            ]);
        }
        $this->command->info('Berhasil membuat ' . count($users) . ' mahasiswa dummy');
    }
}
