<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolSchedule extends Model
{
    protected $fillable = [
        'class_id',
        'subject_id',
        'day_of_week',
        'schedule_type',
        'label',
        'start_time',
        'end_time',
        'teacher_name',
        'room',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'status' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP KELAS
    |--------------------------------------------------------------------------
    */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(
            SchoolClass::class,
            'class_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP MAPEL
    |--------------------------------------------------------------------------
    */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(
            Subject::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LABEL HARI
    |--------------------------------------------------------------------------
    */
    public function getDayLabelAttribute(): string
    {
        return match ($this->day_of_week) {
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            default => '-',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | NAMA JADWAL
    |--------------------------------------------------------------------------
    */
    public function getDisplayNameAttribute(): string
    {
        if (
            $this->schedule_type === 'lesson'
        ) {
            return
                $this->subject?->name
                ?? 'Mata Pelajaran';
        }

        return
            $this->label
            ?? 'Kegiatan';
    }

    /*
    |--------------------------------------------------------------------------
    | CEK JENIS
    |--------------------------------------------------------------------------
    */
    public function isLesson(): bool
    {
        return
            $this->schedule_type
            === 'lesson';
    }

    public function isBreak(): bool
    {
        return
            $this->schedule_type
            === 'break';
    }
}