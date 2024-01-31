<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionToAccordion extends Model
{
    protected $table = 'auction_to_accordion';
    protected $fillable = [
        'auction_id',
        'accordion_id',
    ];

    public function auction()
    {
        return $this->hasOne('App\Models\Auction', 'id', 'auction_id');
    }

    public function accordion()
    {
        return $this->hasOne('App\Models\AuctionAccordion', 'id', 'accordion_id');
    }
}
