<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        |
        | Guru:
        | - name
        | - nip
        | - password
        | - role = guru
        |
        | Siswa:
        | - name
        | - password
        | - role = siswa
        |
        | NIS siswa disimpan di tabel students.
        |
        */

        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            // NIP hanya digunakan untuk akun guru
            $table->string('nip')
                ->nullable()
                ->unique();

            $table->string('password');

            $table->enum('role', [
                'guru',
                'siswa',
            ])->default('siswa');

            $table->rememberToken();

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Sessions
        |--------------------------------------------------------------------------
        |
        | Digunakan Laravel untuk menyimpan session login.
        |
        */

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->foreignId('user_id')
                ->nullable()
                ->index();

            $table->string('ip_address', 45)
                ->nullable();

            $table->text('user_agent')
                ->nullable();

            $table->longText('payload');

            $table->integer('last_activity')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');

        Schema::dropIfExists('users');
    }
};