<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ServicePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'image',
        'og_image',
        'pdf',
        'service_id',
        'show_image'
    ];

    protected $casts = [
        'show_image' => 'string'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($servicePost) {
            if ($servicePost->pdf) {
                Storage::disk('public')->delete($servicePost->pdf);
            }
            if ($servicePost->image) {
                Storage::disk('public')->delete($servicePost->image);
            }
        });
    }
}
