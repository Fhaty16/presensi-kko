<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'title',
        'summary',
        'content',
        'category',
        'image',

        /*
        |--------------------------------------------------------------------------
        | PENGATURAN COVER
        |--------------------------------------------------------------------------
        |
        | image_fit tetap dipertahankan karena kolomnya sudah ada.
        | Tetapi editor baru akan selalu memakai mode cover.
        |
        */

        'image_fit',
        'image_position_x',
        'image_position_y',
        'image_zoom',

        /*
        |--------------------------------------------------------------------------
        | PUBLIKASI
        |--------------------------------------------------------------------------
        */

        'status',
        'published_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'published_at' =>
                'datetime',

            'image_position_x' =>
                'float',

            'image_position_y' =>
                'float',

            'image_zoom' =>
                'float',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE PUBLISHED
    |--------------------------------------------------------------------------
    */

    public function scopePublished(
        Builder $query
    ): Builder {

        return $query
            ->where(
                'status',
                'published'
            )
            ->whereNotNull(
                'published_at'
            )
            ->where(
                'published_at',
                '<=',
                now(
                    'Asia/Jakarta'
                )
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CEK PUBLISHED
    |--------------------------------------------------------------------------
    */

    public function isPublished(): bool
    {
        return $this->status === 'published'
            &&
            $this->published_at !== null
            &&
            $this->published_at->lte(
                now(
                    'Asia/Jakarta'
                )
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LABEL STATUS
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {

            'published' =>
                'Published',

            default =>
                'Draft',

        };
    }


    /*
    |--------------------------------------------------------------------------
    | LABEL KATEGORI
    |--------------------------------------------------------------------------
    */

    public function getCategoryLabelAttribute(): string
    {
        return $this->category
            ?: 'Informasi KKO';
    }


    /*
    |--------------------------------------------------------------------------
    | IMAGE POSITION X
    |--------------------------------------------------------------------------
    |
    | Nilai selalu dijaga antara 0 - 100.
    |
    */

    public function getImagePositionXAttribute(
        $value
    ): float {

        $value =
            is_numeric($value)
                ? (float) $value
                : 50;


        return max(
            0,
            min(
                100,
                $value
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IMAGE POSITION Y
    |--------------------------------------------------------------------------
    */

    public function getImagePositionYAttribute(
        $value
    ): float {

        $value =
            is_numeric($value)
                ? (float) $value
                : 50;


        return max(
            0,
            min(
                100,
                $value
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IMAGE ZOOM
    |--------------------------------------------------------------------------
    |
    | 1.00 = normal
    | 2.00 = 200%
    | 3.00 = 300%
    |
    */

    public function getImageZoomAttribute(
        $value
    ): float {

        $value =
            is_numeric($value)
                ? (float) $value
                : 1.00;


        return max(
            1.00,
            min(
                3.00,
                $value
            )
        );
    }
}