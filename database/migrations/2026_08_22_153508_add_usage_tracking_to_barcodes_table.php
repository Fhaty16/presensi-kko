<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barcodes', function (Blueprint $table) {
            $table->foreignId('used_by_student_id')
                ->nullable()
                ->after('is_active')
                ->constrained('students')
                ->nullOnDelete();

            $table->timestamp('used_at')
                ->nullable()
                ->after('used_by_student_id');
        });
    }

    public function down(): void
    {
        Schema::table('barcodes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('used_by_student_id');
            $table->dropColumn('used_at');
        });
    }
};