<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingSession extends Model
{
    protected $fillable = [
        'training_date',
        'sport',
        'location',
        'start_time',
        'end_time',
        'notes',
        'created_by',
    ];


    protected function casts(): array
    {
        return [
            'training_date' => 'date',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PEMBUAT SESI
    |--------------------------------------------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA KEHADIRAN
    |--------------------------------------------------------------------------
    */

    public function attendances(): HasMany
    {
        return $this->hasMany(
            TrainingAttendance::class
        );
    }
}