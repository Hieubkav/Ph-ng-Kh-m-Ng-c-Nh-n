<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'order_service',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function servicePosts()
    {
        return $this->hasMany(ServicePost::class);
    }
}
