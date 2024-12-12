<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat pengguna admin
        User::create([
            'name' => 'Farhan',
            'email' => 'muhammadfarhan@staff.unsia.ac.id',
            'password' => Hash::make('secret123'), // Gunakan Hash untuk menyimpan password yang aman
        ]);

        // Membuat pengguna biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
