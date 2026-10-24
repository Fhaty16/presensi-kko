<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

        /*
        |--------------------------------------------------------------------------
        | STUDENT LIFECYCLE
        |--------------------------------------------------------------------------
        */

        'graduated_at',
        'exit_date',
        'exit_reason',
        'status_notes',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | TANGGAL LULUS
            |--------------------------------------------------------------------------
            */

            'graduated_at' =>
                'date',


            /*
            |--------------------------------------------------------------------------
            | TANGGAL KELUAR / NONAKTIF
            |--------------------------------------------------------------------------
            */

            'exit_date' =>
                'date',

        ];
    }


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
    | RELASI KELAS AKTIF
    |--------------------------------------------------------------------------
    |
    | class_id pada tabel students selalu menunjukkan kelas siswa
    | yang sedang aktif saat ini.
    |
    | Contoh:
    |
    | Tahun 2026/2027 = X KKO
    | Tahun 2027/2028 = XI KKO
    |
    | Setelah naik kelas, class_id akan diperbarui menjadi XI KKO.
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
    | RIWAYAT KELAS
    |--------------------------------------------------------------------------
    |
    | Menyimpan seluruh perjalanan kelas siswa.
    |
    | Contoh:
    |
    | 2026/2027 -> X KKO
    | 2027/2028 -> XI KKO
    | 2028/2029 -> XII KKO
    |
    */

    public function classHistories(): HasMany
    {
        return $this->hasMany(
            StudentClassHistory::class,
            'student_id'
        )
            ->orderBy(
                'start_date',
                'desc'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RIWAYAT KELAS YANG SEDANG AKTIF
    |--------------------------------------------------------------------------
    |
    | Mengambil satu riwayat kelas dengan is_current = true.
    |
    */

    public function currentClassHistory(): HasOne
    {
        return $this->hasOne(
            StudentClassHistory::class,
            'student_id'
        )
            ->where(
                'is_current',
                true
            )
            ->latestOfMany();
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


    /*
    |--------------------------------------------------------------------------
    | CEK SISWA AKTIF
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status ===
            'active';
    }


    /*
    |--------------------------------------------------------------------------
    | CEK SISWA SUDAH LULUS
    |--------------------------------------------------------------------------
    */

    public function isGraduated(): bool
    {
        return $this->status ===
            'inactive'
            &&
            $this->exit_reason ===
            'graduated';
    }


    /*
    |--------------------------------------------------------------------------
    | CEK SISWA PINDAH SEKOLAH
    |--------------------------------------------------------------------------
    */

    public function isTransferred(): bool
    {
        return $this->status ===
            'inactive'
            &&
            $this->exit_reason ===
            'transferred';
    }
}