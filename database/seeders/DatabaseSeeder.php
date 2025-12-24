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

        User::create([
            'username' => 'agung2004',
            'email' => 'test@example.com',
            'fullname' => 'Agung Dwi Nugroho',
            'role' => 'SUPERADMIN',
            'password' => Hash::make('password'),
        ]);

        $this->call([
           DemoMobSPTSeeder::class,
        ]);
    }
}
