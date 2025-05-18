<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'duration_minutes',
        'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}