<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['title', 'type', 'category', 'content_url', 'duration_minutes'];

    // Búsqueda por categoría
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}