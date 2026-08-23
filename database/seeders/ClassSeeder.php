<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        SchoolClass::create([
            'name' => 'X KKO 1',
            'grade' => 10,
            'academic_year' => '2026/2027',
            'status' => true,
        ]);

        SchoolClass::create([
            'name' => 'X KKO 2',
            'grade' => 10,
            'academic_year' => '2026/2027',
            'status' => true,
        ]);

        SchoolClass::create([
            'name' => 'XI KKO 1',
            'grade' => 11,
            'academic_year' => '2026/2027',
            'status' => true,
        ]);

        SchoolClass::create([
            'name' => 'XI KKO 2',
            'grade' => 11,
            'academic_year' => '2026/2027',
            'status' => true,
        ]);

        SchoolClass::create([
            'name' => 'XII KKO',
            'grade' => 12,
            'academic_year' => '2026/2027',
            'status' => true,
        ]);
    }
}