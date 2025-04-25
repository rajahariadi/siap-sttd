<?php

namespace Database\Seeders;

use App\Models\StatusStudent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            ['id' => 'A', 'name' => 'Aktif'],
            ['id' => 'C', 'name' => 'Cuti'],
            ['id' => 'P', 'name' => 'Pasif'],
            ['id' => 'K', 'name' => 'Keluar'],
            ['id' => 'D', 'name' => 'Drop-out'],
            ['id' => 'L', 'name' => 'Lulus'],
            ['id' => 'T', 'name' => 'Tunggu Ujian'],
        ];

        StatusStudent::insert($status);

        $this->command->info('Berhasil membuat ' . count($status) . ' status dummy');
    }
}
