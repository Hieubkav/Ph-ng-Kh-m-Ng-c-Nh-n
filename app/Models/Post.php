<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'image',
        'og_image',
        'pdf',
        'user_id',
        'cat_post_id',
        'is_hot',
        'show_image'
    ];

    protected $casts = [
        'is_hot' => 'string',
        'show_image' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cat_post()
    {
        return $this->belongsTo(CatPost::class);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    /**
     * Get the PDF URL
     */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf ? Storage::disk('public')->url($this->pdf) : null;
    }
}
