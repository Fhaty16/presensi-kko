<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | UP
    |--------------------------------------------------------------------------
    |
    | Menambahkan informasi siklus siswa tanpa mengubah field status lama.
    |
    | students.status tetap:
    |
    | active
    | inactive
    |
    | Sedangkan alasan siswa menjadi inactive disimpan di exit_reason.
    |
    */

    public function up(): void
    {
        Schema::table(
            'students',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | TANGGAL LULUS
                |--------------------------------------------------------------------------
                |
                | Diisi jika siswa sudah dinyatakan lulus.
                |
                | Contoh:
                | 2029-05-15
                |
                */

                $table
                    ->date('graduated_at')
                    ->nullable()
                    ->after('status')
                    ->index();


                /*
                |--------------------------------------------------------------------------
                | TANGGAL KELUAR
                |--------------------------------------------------------------------------
                |
                | Digunakan untuk semua kondisi siswa yang sudah tidak aktif.
                |
                | Contoh:
                |
                | Lulus
                | Pindah sekolah
                | Mengundurkan diri
                | Kondisi lainnya
                |
                */

                $table
                    ->date('exit_date')
                    ->nullable()
                    ->after('graduated_at');


                /*
                |--------------------------------------------------------------------------
                | ALASAN KELUAR / NONAKTIF
                |--------------------------------------------------------------------------
                |
                | Nilai yang nantinya kita gunakan:
                |
                | graduated   = Lulus
                | transferred = Pindah Sekolah
                | resigned    = Mengundurkan Diri
                | inactive    = Dinonaktifkan
                | other       = Lainnya
                |
                | Dibuat string, bukan ENUM, agar fleksibel untuk jangka panjang.
                |
                */

                $table
                    ->string(
                        'exit_reason',
                        50
                    )
                    ->nullable()
                    ->after('exit_date')
                    ->index();


                /*
                |--------------------------------------------------------------------------
                | CATATAN STATUS SISWA
                |--------------------------------------------------------------------------
                |
                | Contoh:
                |
                | - Lulus tahun ajaran 2028/2029
                | - Pindah sekolah ke ...
                | - Dinonaktifkan sementara
                |
                */

                $table
                    ->text('status_notes')
                    ->nullable()
                    ->after('exit_reason');
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWN
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::table(
            'students',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | HAPUS INDEX
                |--------------------------------------------------------------------------
                */

                $table->dropIndex([
                    'graduated_at',
                ]);

                $table->dropIndex([
                    'exit_reason',
                ]);


                /*
                |--------------------------------------------------------------------------
                | HAPUS COLUMN
                |--------------------------------------------------------------------------
                */

                $table->dropColumn([
                    'graduated_at',
                    'exit_date',
                    'exit_reason',
                    'status_notes',
                ]);
            }
        );
    }
};