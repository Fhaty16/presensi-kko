<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | UP
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MYSQL
        |--------------------------------------------------------------------------
        */

        if (
            DB::getDriverName()
            ===
            'mysql'
        ) {

            DB::statement("
                ALTER TABLE users
                MODIFY role ENUM(
                    'guru',
                    'siswa',
                    'pelatih'
                )
                NOT NULL
                DEFAULT 'siswa'
            ");

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SQLITE / TESTING
        |--------------------------------------------------------------------------
        |
        | SQLite tidak memiliki ENUM dan tidak mendukung MODIFY COLUMN.
        |
        | Pada environment test, role tetap disimpan sebagai teks sehingga
        | nilai guru / siswa / pelatih tetap dapat digunakan.
        |
        */

        if (
            DB::getDriverName()
            ===
            'sqlite'
        ) {
            return;
        }
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
        | MYSQL
        |--------------------------------------------------------------------------
        */

        if (
            DB::getDriverName()
            ===
            'mysql'
        ) {

            DB::statement("
                ALTER TABLE users
                MODIFY role ENUM(
                    'guru',
                    'siswa'
                )
                NOT NULL
                DEFAULT 'siswa'
            ");

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SQLITE / TESTING
        |--------------------------------------------------------------------------
        */

        if (
            DB::getDriverName()
            ===
            'sqlite'
        ) {
            return;
        }
    }
};