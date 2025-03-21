<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'url_thumbnail',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function scopeVisible($query)
    {
        return $query->where('status', 'show');
    }

    protected static function boot()
    {
        parent::boot();
        
        // Khi một schedule được set status='show', các schedule khác sẽ được set về 'hidden'
        static::saved(function ($schedule) {
            if ($schedule->status === 'show') {
                static::where('id', '!=', $schedule->id)
                    ->update(['status' => 'hidden']);
            }
        });
    }
}
