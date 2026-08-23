<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('training_attendances', function (Blueprint $table) {
            $table->dateTime('checked_in_at')
                ->nullable()
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('training_attendances', function (Blueprint $table) {
            $table->dropColumn('checked_in_at');
        });
    }
};