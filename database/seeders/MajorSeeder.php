<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            [
                'code' => '55201',
                'name' => 'Teknik Informatika',
                'jenjang' => 'S1',
                'akreditasi' => 'B',
                'kaprodi' => 'Nurhadi S.Kom., M.Pd.,Ph.D',
            ],
            [
                'code' => '26201',
                'name' => 'Teknik Industri',
                'jenjang' => 'S1',
                'akreditasi' => 'B',
                'kaprodi' => 'Dr. Melliana, S.T., M.M.',
            ],
            [
                'code' => '22201',
                'name' => 'Teknik Sipil',
                'jenjang' => 'S1',
                'akreditasi' => 'B',
                'kaprodi' => 'Dr. Ir. H. Nuryasin Abdillah, M.Si.',
            ]
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
        $this->command->info('Berhasil membuat ' . count($majors) . ' jurusan dummy');

    }
}
