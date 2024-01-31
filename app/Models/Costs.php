<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costs extends Model
{
    protected $table = 'costs';
    protected $fillable = [
        'name',
        'auction_id',
        'price',
    ];

    public function auction()
    {
        return $this->hasOne('App\Models\Status', 'id', 'auction_id');
    }
}
