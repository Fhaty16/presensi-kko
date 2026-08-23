<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance_settings', function (Blueprint $table) {

            $table->decimal('school_latitude', 10, 7)
                ->nullable();

            $table->decimal('school_longitude', 10, 7)
                ->nullable();

            $table->unsignedInteger('location_radius_meters')
                ->default(150);

            $table->unsignedSmallInteger('barcode_lifetime_seconds')
                ->default(60);
        });
    }

    public function down(): void
    {
        Schema::table('attendance_settings', function (Blueprint $table) {

            $table->dropColumn([
                'school_latitude',
                'school_longitude',
                'location_radius_meters',
                'barcode_lifetime_seconds',
            ]);

        });
    }
};