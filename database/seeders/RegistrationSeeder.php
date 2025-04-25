<?php

namespace Database\Seeders;

use App\Models\Registration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $years = [2020, 2021, 2022, 2023, 2024, 2025];
        $gelombang = ['Gelombang I', 'Gelombang II', 'Gelombang III'];

        foreach ($years as $year) {
            foreach ($gelombang as $name) {

                $exists = Registration::where('name', $name)
                    ->where('year', $year)
                    ->exists();

                if (!$exists) {
                    Registration::create([
                        'name' => $name,
                        'year' => $year,
                    ]);
                }
            }
        }
        $this->command->info('Berhasil membuat ' . count($gelombang) . ' pendaftaran dummy');

    }
}
