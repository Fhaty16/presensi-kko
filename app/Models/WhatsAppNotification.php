<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppNotification extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'whatsapp_notifications';


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'student_id',
        'attendance_id',
        'event_key',

        'notification_type',
        'attendance_status',

        'recipient_phone',
        'message',

        'status',

        'provider_message_id',
        'error_message',

        'attempts',

        'sent_at',
        'last_attempt_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'student_id' => 'integer',

            'attendance_id' => 'integer',

            'attempts' => 'integer',

            'sent_at' => 'datetime',

            'last_attempt_at' => 'datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | STUDENT
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            Student::class,
            'student_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ATTENDANCE
    |--------------------------------------------------------------------------
    */

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(
            Attendance::class,
            'attendance_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE PENDING
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk mengambil pesan yang belum dikirim.
    |
    */

    public function scopePending(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'pending'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE SENT
    |--------------------------------------------------------------------------
    */

    public function scopeSent(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'sent'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE FAILED
    |--------------------------------------------------------------------------
    */

    public function scopeFailed(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'failed'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MARK PROCESSING
    |--------------------------------------------------------------------------
    */

    public function markAsProcessing(): void
    {
        $this->update([
            'status' => 'processing',

            'attempts' =>
                $this->attempts + 1,

            'last_attempt_at' =>
                now('Asia/Jakarta'),

            'error_message' =>
                null,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MARK SENT
    |--------------------------------------------------------------------------
    */

    public function markAsSent(
        ?string $providerMessageId = null
    ): void {
        $this->update([
            'status' => 'sent',

            'provider_message_id' =>
                $providerMessageId,

            'sent_at' =>
                now('Asia/Jakarta'),

            'error_message' =>
                null,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MARK FAILED
    |--------------------------------------------------------------------------
    */

    public function markAsFailed(
        ?string $errorMessage = null
    ): void {
        $this->update([
            'status' => 'failed',

            'error_message' =>
                $errorMessage,

            'last_attempt_at' =>
                now('Asia/Jakarta'),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MARK SKIPPED
    |--------------------------------------------------------------------------
    */

    public function markAsSkipped(
        ?string $reason = null
    ): void {
        $this->update([
            'status' => 'skipped',

            'error_message' =>
                $reason,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SUDAH TERKIRIM?
    |--------------------------------------------------------------------------
    */

    public function isSent(): bool
    {
        return $this->status
            === 'sent';
    }


    /*
    |--------------------------------------------------------------------------
    | BOLEH DIKIRIM?
    |--------------------------------------------------------------------------
    */

    public function canBeSent(): bool
    {
        return in_array(
            $this->status,
            [
                'pending',
                'failed',
            ],
            true
        );
    }
}