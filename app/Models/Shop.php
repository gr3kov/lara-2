<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Shop extends Model
{
    protected $table = 'shop';
    protected $fillable = [
        'name',
        'count',
        'price',
        'image',
        'old_price',
        'sale_percent',
    ];

//    protected $casts = [
//        'image' => 'image',
//    ];
}
