<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentTypes = [
            [
                'name' => 'Semester Ganjil 2025/2026',
                'description' => 'Pembayaran SPP per Semester',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Semester Genapa 2025/2026',
                'description' => 'Pembayaran SPP per Semester',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tugas Akhir',
                'description' => 'Biaya Tugas Akhir',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Wisuda',
                'description' => 'Biaya Kelulusan dan Wisuda',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($paymentTypes as $paymentType) {
            PaymentType::create($paymentType);
        }
        $this->command->info('Berhasil membuat ' . count($paymentTypes) . ' jenis pembayaran dummy');
    }
}
