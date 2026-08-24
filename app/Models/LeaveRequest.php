<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'student_id',

        'attendance_scope',
        'training_session_id',

        'type',
        'start_date',
        'end_date',
        'reason',
        'attachment',

        'status',

        'reviewed_by',
        'reviewed_at',

        'approved_by',
        'approved_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',

            'reviewed_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP STUDENT
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP TRAINING SESSION
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
    | TYPE LABEL
    |--------------------------------------------------------------------------
    */

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'permission' => 'Izin',
            'sick' => 'Sakit',
            default => '-',
        };
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS LABEL
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => '-',
        };
    }


    /*
    |--------------------------------------------------------------------------
    | ATTENDANCE SCOPE LABEL
    |--------------------------------------------------------------------------
    */

    public function getAttendanceScopeLabelAttribute(): string
    {
        return match ($this->attendance_scope) {
            'training' => 'Latihan KKO',
            'school' => 'Presensi Sekolah',
            default => 'Presensi Sekolah',
        };
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    public function isTrainingRequest(): bool
    {
        return $this->attendance_scope === 'training';
    }


    public function isSchoolRequest(): bool
    {
        return $this->attendance_scope !== 'training';
    }
}