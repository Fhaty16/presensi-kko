<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingAttendance extends Model
{
    protected $fillable = [
        'training_session_id',
        'student_id',
        'status',
        'notes',
    ];


    /*
    |--------------------------------------------------------------------------
    | SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(
            TrainingSession::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            Student::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LABEL STATUS
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {

            'present' => 'Hadir',

            'permission' => 'Izin',

            'sick' => 'Sakit',

            'absent' => 'Alfa',

            default => '-',
        };
    }
}