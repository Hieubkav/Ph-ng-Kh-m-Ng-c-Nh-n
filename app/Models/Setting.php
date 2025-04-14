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
        'zalo',
        'facebook',
        'messenger',
        'google_map',
        'mst',
       'tmp_pic',
        'giay_phep',
        'telephone',
        
    ];
}
