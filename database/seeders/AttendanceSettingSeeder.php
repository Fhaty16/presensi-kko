<?php

namespace Database\Seeders;

use App\Models\AttendanceSetting;
use Illuminate\Database\Seeder;

class AttendanceSettingSeeder extends Seeder
{
    public function run(): void
    {
        AttendanceSetting::create([
            'cutoff_time' => '07:00:00',
            'auto_alpha' => true,
        ]);
    }
}