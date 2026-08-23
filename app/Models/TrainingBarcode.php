<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingBarcode extends Model
{
    protected $fillable = [
        'training_session_id',
        'token',
        'expired_at',
        'is_active',
        'used_by_student_id',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime',
            'is_active' => 'boolean',
            'used_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(
            TrainingSession::class,
            'training_session_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SISWA YANG MENGGUNAKAN BARCODE
    |--------------------------------------------------------------------------
    */

    public function usedByStudent(): BelongsTo
    {
        return $this->belongsTo(
            Student::class,
            'used_by_student_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK BARCODE MASIH VALID
    |--------------------------------------------------------------------------
    */

    public function isValid(): bool
    {
        return $this->is_active
            && is_null($this->used_at)
            && $this->expired_at
            && $this->expired_at->isFuture();
    }
}