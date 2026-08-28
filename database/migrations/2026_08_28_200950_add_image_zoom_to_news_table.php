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
    | image_zoom digunakan oleh editor cover berita.
    |
    | 1.00 = ukuran normal
    | 1.50 = zoom 150%
    | 2.00 = zoom 200%
    | 3.00 = zoom 300%
    |
    */

    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {

            $table
                ->decimal(
                    'image_zoom',
                    4,
                    2
                )
                ->default(
                    1.00
                )
                ->after(
                    'image_position_y'
                );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | DOWN
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {

            $table->dropColumn(
                'image_zoom'
            );

        });
    }
};