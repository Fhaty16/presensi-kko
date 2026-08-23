<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE training_attendances
            MODIFY status ENUM(
                'present',
                'late',
                'permission',
                'sick',
                'absent'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE training_attendances
            MODIFY status ENUM(
                'present',
                'permission',
                'sick',
                'absent'
            ) NOT NULL
        ");
    }
};