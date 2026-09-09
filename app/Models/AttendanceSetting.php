<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'cutoff_time',
        'auto_alpha',

        'attendance_start_time',
        'late_after_minutes',

        'school_latitude',
        'school_longitude',
        'location_radius_meters',
        'barcode_lifetime_seconds',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'auto_alpha' =>
                'boolean',

            'late_after_minutes' =>
                'integer',

            'school_latitude' =>
                'decimal:7',

            'school_longitude' =>
                'decimal:7',

            'location_radius_meters' =>
                'integer',

            'barcode_lifetime_seconds' =>
                'integer',
        ];
    }
}