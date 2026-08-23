<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    protected $fillable = [
        'student_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'attachment',
        'status',
        'reviewed_at',
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
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP SISWA
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }


    /*
    |--------------------------------------------------------------------------
    | LABEL JENIS PENGAJUAN
    |--------------------------------------------------------------------------
    |
    | permission = Izin
    | sick       = Sakit
    |
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
    | LABEL STATUS
    |--------------------------------------------------------------------------
    |
    | pending  = Menunggu
    | approved = Disetujui
    | rejected = Ditolak
    |
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
    | CSS CLASS STATUS
    |--------------------------------------------------------------------------
    */

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {

            'pending' => 'status-pending',

            'approved' => 'status-approved',

            'rejected' => 'status-rejected',

            default => '',
        };
    }
}