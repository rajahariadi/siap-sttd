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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super User',
            'email' => 'superuser@siapsttdumai.ac.id',
            'nim' => '-',
            'password' => Hash::make('rahasiaari'),
            'role' => 'superuser',
        ]);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'administrator@siapsttdumai.ac.id',
            'nim' => 'admin',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);
    }
}
