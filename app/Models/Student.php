<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'nis',
        'class_id',
        'sport',
        'avatar',
        'parent_phone',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELASI USER
    |--------------------------------------------------------------------------
    |
    | Setiap siswa terhubung ke satu akun user.
    |
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI KELAS
    |--------------------------------------------------------------------------
    |
    | Setiap siswa berada di satu kelas.
    |
    */

    public function class(): BelongsTo
    {
        return $this->belongsTo(
            SchoolClass::class,
            'class_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI PRESENSI LATIHAN
    |--------------------------------------------------------------------------
    |
    | Satu siswa dapat memiliki banyak riwayat presensi latihan.
    |
    */

    public function trainingAttendances(): HasMany
    {
        return $this->hasMany(
            TrainingAttendance::class,
            'student_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI BARCODE LATIHAN YANG PERNAH DIGUNAKAN
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk mengetahui QR latihan mana saja
    | yang pernah digunakan oleh siswa.
    |
    */

    public function usedTrainingBarcodes(): HasMany
    {
        return $this->hasMany(
            TrainingBarcode::class,
            'used_by_student_id'
        );
    }
}