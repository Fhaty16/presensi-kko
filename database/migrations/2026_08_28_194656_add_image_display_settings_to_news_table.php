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
    | Menambahkan pengaturan tampilan gambar berita.
    |
    | image_fit
    | - contain = gambar tampil utuh
    | - cover   = gambar memenuhi area
    |
    | image_position_x
    | - 0   = kiri
    | - 50  = tengah
    | - 100 = kanan
    |
    | image_position_y
    | - 0   = atas
    | - 50  = tengah
    | - 100 = bawah
    |
    */

    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | IMAGE FIT
            |--------------------------------------------------------------------------
            */

            $table
                ->string(
                    'image_fit',
                    20
                )
                ->default(
                    'contain'
                )
                ->after(
                    'image'
                );


            /*
            |--------------------------------------------------------------------------
            | POSISI HORIZONTAL
            |--------------------------------------------------------------------------
            */

            $table
                ->unsignedTinyInteger(
                    'image_position_x'
                )
                ->default(
                    50
                )
                ->after(
                    'image_fit'
                );


            /*
            |--------------------------------------------------------------------------
            | POSISI VERTIKAL
            |--------------------------------------------------------------------------
            */

            $table
                ->unsignedTinyInteger(
                    'image_position_y'
                )
                ->default(
                    50
                )
                ->after(
                    'image_position_x'
                );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | DOWN
    |--------------------------------------------------------------------------
    |
    | Menghapus kolom apabila migration di-rollback.
    |
    */

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {

            $table->dropColumn([
                'image_fit',
                'image_position_x',
                'image_position_y',
            ]);

        });
    }
};