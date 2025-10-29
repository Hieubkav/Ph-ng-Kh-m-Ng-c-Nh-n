<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'youtube_url',
        'display_order',
        'is_hot',
        'is_active',
    ];

    protected $casts = [
        'is_hot' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getYoutubeIdAttribute(): ?string
    {
        if (blank($this->youtube_url)) {
            return null;
        }

        $patterns = [
            '/youtu\.be\/([^\?&]+)/',
            '/youtube\.com\/watch\?v=([^\?&]+)/',
            '/youtube\.com\/embed\/([^\?&]+)/',
            '/youtube\.com\/shorts\/([^\?&]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->youtube_url, $matches)) {
                return $matches[1];
            }
        }

        $parsed = parse_url($this->youtube_url);
        if (!empty($parsed['query'])) {
            parse_str($parsed['query'], $query);
            if (isset($query['v'])) {
                return $query['v'];
            }
        }

        return null;
    }

    public function getEmbedUrlAttribute(): ?string
    {
        $videoId = $this->youtube_id;

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        $videoId = $this->youtube_id;

        return $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : null;
    }
}
