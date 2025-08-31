<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpustakaan.sd',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);
        
        User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'petugas@perpustakaan.sd',
            'password' => Hash::make('password123'),
            'role' => 'petugas'
        ]);
    }
}
