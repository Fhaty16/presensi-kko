<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nis',
        'class_id',
        'avatar',
        'parent_phone',
        'status',
    ];

    /**
     * Student milik satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Student berada di satu kelas.
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}