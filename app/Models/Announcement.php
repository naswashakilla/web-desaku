<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'image',
        'is_published',
        'user_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // relasi ke user yang membuat pengumuman
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // scope untuk yang sudah dipublish (untuk halaman warga)
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}