<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentClassHistory extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'student_id',
        'class_id',
        'academic_year',
        'start_date',
        'end_date',
        'is_current',
        'notes',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'start_date' =>
                'date',

            'end_date' =>
                'date',

            'is_current' =>
                'boolean',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI SISWA
    |--------------------------------------------------------------------------
    |
    | Satu riwayat kelas dimiliki oleh satu siswa.
    |
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            Student::class,
            'student_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI KELAS
    |--------------------------------------------------------------------------
    |
    | Satu riwayat kelas mengarah ke satu kelas.
    |
    */

    public function class(): BelongsTo
    {
        return $this->belongsTo(
            SchoolClass::class,
            'class_id'
        );
    }
}