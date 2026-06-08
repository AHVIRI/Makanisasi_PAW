<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin1@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('admin1password'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]);
        }
    }
}
