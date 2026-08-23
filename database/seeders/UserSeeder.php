<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // GURU
        // =========================
        User::create([
            'name' => 'Guru KKO',
            'nip' => '19850001',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // =========================
        // PELATIH
        // =========================
        User::create([
            'name' => 'Pelatih KKO',
            'nip' => '19850002',
            'password' => Hash::make('password'),
            'role' => 'pelatih',
        ]);

        // =========================
        // SISWA
        // =========================
        User::create([
            'name' => 'Budi Santoso',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        User::create([
            'name' => 'Andi Saputra',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        User::create([
            'name' => 'Dewi Lestari',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);
    }
}