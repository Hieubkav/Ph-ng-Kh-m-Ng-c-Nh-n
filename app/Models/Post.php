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
        'content',
        'image',
        'pdf',
        'user_id',
        'cat_post_id',
        'is_hot'
    ];

    protected $casts = [
        'is_hot' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cat_post()
    {
        return $this->belongsTo(CatPost::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($post) {
            if ($post->pdf) {
                Storage::disk('public')->delete($post->pdf);
            }
        });
    }
}
