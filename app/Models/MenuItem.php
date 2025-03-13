<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'parent_id',
        'label',
        'type',
        'link',
        'cat_id',
        'post_id',
        'order'
    ];

    protected $casts = [
        'type' => 'string',
        'parent_id' => 'int'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function cat_post(): BelongsTo
    {
        return $this->belongsTo(CatPost::class, 'cat_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function getUrl(): string
    {
        return match($this->type) {
            'link' => $this->link,
            'cat' => $this->cat_post ? route('catPost', ['id' => $this->cat_post->id]) : '#',
            'post' => $this->post ? route('post', ['id' => $this->post->id]) : '#',
            default => '#'
        };
    }

    public function level(): int
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }
}
