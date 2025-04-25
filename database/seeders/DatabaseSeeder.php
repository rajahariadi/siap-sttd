<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            StatusStudentSeeder::class,
            MajorSeeder::class,
            RegistrationSeeder::class,
            UserSeeder::class,
            StudentSeeder::class,
            PaymentTypeSeeder::class,
            BillSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
