<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'image',
        'user_id',
        'cat_post_id',
        'is_hot',
    ];

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function cat_post(){
		return $this->belongsTo(CatPost::class);
	}
}
