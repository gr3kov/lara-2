<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayOrder extends Model
{
    // Подготовлен к проведению оплаты
    const STATUS_PREPARED = 'prepared';
    // Платеж находится в обработке
    const STATUS_IN_PROGRESS = 'in_progress';
    // Платеж успешно произведен
    const STATUS_APPROVED = 'approved';
    // Произошла ошибка при проведении платежа
    const STATUS_FAILED = 'failed';
    // Был перерасчёт платежа
    const STATUS_RECALCULATION = 'recalculation';

    protected $table = 'pay_order';
    protected $fillable = [
        'user_id',
        'price',
        'description',
        'auction_id',
        'token_id',
        'status',
        'response',
    ];

    public function token()
    {
        return $this->hasOne('App\Models\Token', 'id', 'token_id');
    }

    public function auction()
    {
        return $this->hasOne('App\Models\Auction', 'id', 'auction_id');
    }
}
