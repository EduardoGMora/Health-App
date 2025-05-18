<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaryEntry extends Model
{
    protected $fillable = ['user_id', 'mood', 'energy_level', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
