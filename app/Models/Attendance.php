<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'barcode_id',
        'attendance_date',
        'check_in_time',
        'status',
        'notes',
        'wa_sent',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'wa_sent' => 'boolean',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function barcode(): BelongsTo
    {
        return $this->belongsTo(Barcode::class);
    }
}