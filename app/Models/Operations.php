<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operations extends Model
{
    protected $table = 'operations';
    protected $fillable = [
        'operation_id',
        'amount',
        'comment',
        'message',
        'details',
        'title',
        'direction',
        'table_name',
        'account_id'
    ];
}
