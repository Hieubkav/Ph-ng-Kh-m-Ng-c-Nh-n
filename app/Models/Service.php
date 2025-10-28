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
    
    protected $appends = ['image_url'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function servicePosts()
    {
        return $this->hasMany(ServicePost::class);
    }
    
    /**
     * Get the image URL attribute
     * If image is a number 1-6, return service icon path
     * Otherwise return storage path for uploaded image
     */
    public function getImageUrlAttribute()
    {
        if (is_numeric($this->image) && $this->image >= 1 && $this->image <= 6) {
            return asset('images/service_icon/' . $this->image . '.webp');
        }
        
        // For old uploaded images
        if ($this->image) {
            return config('app.asset_url') . '/storage/' . $this->image;
        }
        
        // Default icon if no image
        return asset('images/service_icon/1.webp');
    }
}
