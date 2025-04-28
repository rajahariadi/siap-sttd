<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'administrator@siapsttdumai.ac.id',
            'nim' => 'admin',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);

        $adminCount = 1;
        $mahasiswaCount = 0;

        $this->createMahasiswa('55201', 5);
        $this->createMahasiswa('26201', 5);
        $this->createMahasiswa('22201', 5);

        for ($i = 0; $i < 10; $i++) {
            $majors = Major::all();
            $major = $majors->random();
            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'nim' => fake()->unique()->numerify('21' . $major->code . '###'),
                'password' => Hash::make('12345678'),
                'role' => 'mahasiswa',
            ]);
            $mahasiswaCount++;
        }
        $mahasiswaCount += 15;

        $this->command->info("Berhasil membuat $adminCount admin dan $mahasiswaCount mahasiswa dummy");
    }

    private function createMahasiswa($kodeJurusan, $jumlah)
    {
        for ($i = 1; $i <= $jumlah; $i++) {
            $nim = '21' . $kodeJurusan . str_pad($i, 3, '0', STR_PAD_LEFT);

            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'nim' => $nim,
                'password' => Hash::make('12345678'),
                'role' => 'mahasiswa',
            ]);
        }
    }
}
