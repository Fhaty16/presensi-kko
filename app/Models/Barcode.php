<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barcode extends Model
{
    protected $fillable = [
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
            'used_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function usedByStudent(): BelongsTo
    {
        return $this->belongsTo(
            Student::class,
            'used_by_student_id'
        );
    }
}