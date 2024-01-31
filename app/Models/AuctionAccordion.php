<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionAccordion extends Model
{
    protected $table = 'auction_accordion';
    protected $fillable = [
        'title',
        'description',
        'code',
    ];
}
