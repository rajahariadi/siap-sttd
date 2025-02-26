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
            'nim' => 'superuser',
            'password' => Hash::make('rajahariadi1009'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'administrator@siapsttdumai.ac.id',
            'nim' => 'admin',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@siapsttdumai.ac.id',
            'nim' => 'user',
            'password' => Hash::make('user1234'),
            'role' => 'mahasiswa',
        ]);

        $this->call(RegistrationSeeder::class);


    }
}
