<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hotline',
        'email',
        'address',
        'logo',
        'slogan',
        'image_schedule',
        'zalo',
        'facebook',
        'messenger',
        'google_map',
        'mst',
        'hr_status',
        'hr_content',
    ];
}
