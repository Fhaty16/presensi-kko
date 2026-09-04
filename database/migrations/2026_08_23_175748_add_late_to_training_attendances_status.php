<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | UP
    |--------------------------------------------------------------------------
    |
    | Migration ini dahulu dibuat untuk menambahkan status "late"
    | ke ENUM MySQL yang sudah ada.
    |
    | Fresh migration sekarang sudah memiliki "late" langsung dari migration
    | create_training_attendances_table.
    |
    | Namun migration ini tetap dipertahankan untuk kompatibilitas database
    | MySQL lama yang pernah menjalankan migration awal sebelum "late" ada.
    |
    */

    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MYSQL / MARIADB
        |--------------------------------------------------------------------------
        */

        if (
            DB::getDriverName()
            ===
            'mysql'
        ) {

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


        /*
        |--------------------------------------------------------------------------
        | SQLITE
        |--------------------------------------------------------------------------
        |
        | Tidak perlu melakukan apa pun.
        |
        | SQLite tidak mendukung:
        |
        | ALTER TABLE ... MODIFY
        |
        | Status "late" sudah tersedia dari migration create awal.
        |
        */
    }


    /*
    |--------------------------------------------------------------------------
    | DOWN
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MYSQL / MARIADB
        |--------------------------------------------------------------------------
        */

        if (
            DB::getDriverName()
            ===
            'mysql'
        ) {

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


        /*
        |--------------------------------------------------------------------------
        | SQLITE
        |--------------------------------------------------------------------------
        |
        | Tidak ada perubahan yang diperlukan saat rollback SQLite.
        |
        */
    }
};