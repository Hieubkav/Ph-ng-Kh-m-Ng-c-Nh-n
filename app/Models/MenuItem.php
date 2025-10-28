<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SolutionForest\FilamentTree\Concern\ModelTree;

class MenuItem extends Model
{
    use ModelTree;

    const TYPE_LINK = 'link';
    const TYPE_CAT = 'cat';
    const TYPE_POST = 'post';
    
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
        'parent_id' => 'integer',
        'cat_id' => 'integer',
        'post_id' => 'integer',
        'order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
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
            self::TYPE_LINK => $this->link,
            self::TYPE_CAT => $this->cat_post ? route('catPost', ['id' => $this->cat_post->id]) : '#',
            self::TYPE_POST => $this->post ? route('post', $this->post->slug) : '#',
            default => '#'
        };
    }

    public function determineOrderColumnName(): string 
    {
        return 'order';
    }

    public function determineParentColumnName(): string 
    {
        return 'parent_id';
    }

    public function determineTitleColumnName(): string 
    {
        return 'label';
    }

    public static function defaultParentKey()
    {
        return null;
    }

    public static function defaultChildrenKeyName(): string 
    {
        return 'children';
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
