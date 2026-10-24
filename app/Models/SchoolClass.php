<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table =
        'classes';


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'grade',
        'academic_year',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'grade' =>
                'integer',

            'status' =>
                'boolean',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | SISWA AKTIF DI KELAS INI
    |--------------------------------------------------------------------------
    |
    | Relasi ini tetap menggunakan students.class_id.
    |
    | Artinya hanya menunjukkan siswa yang SAAT INI
    | berada di kelas tersebut.
    |
    */

    public function students(): HasMany
    {
        return $this->hasMany(
            Student::class,
            'class_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RIWAYAT SISWA DI KELAS
    |--------------------------------------------------------------------------
    |
    | Berisi seluruh riwayat siswa yang pernah berada
    | di kelas ini pada tahun ajaran tertentu.
    |
    */

    public function studentClassHistories(): HasMany
    {
        return $this->hasMany(
            StudentClassHistory::class,
            'class_id'
        )
            ->orderBy(
                'academic_year',
                'desc'
            );
    }
}