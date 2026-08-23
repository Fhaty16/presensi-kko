<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $class = SchoolClass::where('name', 'X KKO 1')->first();

        $budi = User::where('name', 'Budi Santoso')
            ->where('role', 'siswa')
            ->first();

        $andi = User::where('name', 'Andi Saputra')
            ->where('role', 'siswa')
            ->first();

        $dewi = User::where('name', 'Dewi Lestari')
            ->where('role', 'siswa')
            ->first();


        Student::create([
            'user_id' => $budi->id,
            'nis' => '20260001',
            'class_id' => $class->id,
            'parent_phone' => '081234567890',
            'status' => 'active',
        ]);

        Student::create([
            'user_id' => $andi->id,
            'nis' => '20260002',
            'class_id' => $class->id,
            'parent_phone' => '081234567891',
            'status' => 'active',
        ]);

        Student::create([
            'user_id' => $dewi->id,
            'nis' => '20260003',
            'class_id' => $class->id,
            'parent_phone' => '081234567892',
            'status' => 'active',
        ]);
    }
}