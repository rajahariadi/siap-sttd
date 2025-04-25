<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Student;
use App\Models\PaymentType;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BillSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        $paymentTypes = PaymentType::all();

        if ($students->isEmpty() || $paymentTypes->isEmpty()) {
            $this->command->info('Tidak ada student atau payment type, skip bill seeder');
            return;
        }

        // Dapatkan ID dengan cara yang lebih aman
        $semesterGanjil = $paymentTypes->first(function ($type) {
            return str_contains($type->name, 'Ganjil');
        });
        $semesterGenap = $paymentTypes->first(function ($type) {
            return str_contains($type->name, 'Genap');
        });
        $tugasAkhir = $paymentTypes->first(function ($type) {
            return str_contains($type->name, 'Tugas Akhir');
        });
        $wisuda = $paymentTypes->first(function ($type) {
            return str_contains($type->name, 'Wisuda');
        });

        // Validasi payment type
        if (!$semesterGanjil || !$semesterGenap || !$tugasAkhir || !$wisuda) {
            $this->command->error('Beberapa payment type tidak ditemukan! Pastikan sudah di-seed');
            return;
        }

        foreach ($students as $student) {
            // Semester Ganjil 2025/2026
            Bill::create([
                'student_id' => $student->id,
                'payment_type_id' => $semesterGanjil->id,
                'amount' => $student->semester_fee,
                'due_date' => Carbon::create(2025, 8, 1),
                'status' => $this->getRandomBillStatus(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Semester Genap 2025/2026
            Bill::create([
                'student_id' => $student->id,
                'payment_type_id' => $semesterGenap->id,
                'amount' => $student->semester_fee,
                'due_date' => Carbon::create(2026, 1, 15),
                'status' => $this->getRandomBillStatus(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Tugas Akhir
            Bill::create([
                'student_id' => $student->id,
                'payment_type_id' => $tugasAkhir->id,
                'amount' => 1500000,
                'due_date' => Carbon::now()->addMonths(rand(3, 6)),
                'status' => $this->getRandomBillStatus(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Wisuda
            Bill::create([
                'student_id' => $student->id,
                'payment_type_id' => $wisuda->id,
                'amount' => 2000000,
                'due_date' => Carbon::now()->addMonths(rand(6, 12)),
                'status' => $this->getRandomBillStatus(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $this->command->info('Berhasil membuat ' . ($students->count() * 4) . ' bills dummy');
    }

    private function getRandomBillStatus()
    {
        $statuses = ['pending', 'paid', 'expired'];
        return $statuses[array_rand($statuses)];
    }
}
