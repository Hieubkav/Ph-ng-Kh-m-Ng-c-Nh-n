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
