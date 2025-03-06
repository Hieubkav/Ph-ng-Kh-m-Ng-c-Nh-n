<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Concern\ModelTree;

class Post extends Model
{
    use HasFactory;
    use ModelTree;

    protected $fillable = [
        'name',
        'content',
        'image',
        'user_id',
        'cat_post_id',
        'is_hot',
        "parent_id", "order"
    ];

    protected $casts = [
        'parent_id' => 'int'
    ];

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function cat_post(){
		return $this->belongsTo(CatPost::class);
	}

    public function children()
    {
        return $this->hasMany(Post::class, 'parent_id')->orderBy('order');
    }
}
