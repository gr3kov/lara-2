<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionDeposit extends Model
{
    use HasFactory;
    protected $table = 'auction_deposit';
    protected $fillable = [
        'auction_id',                 //ИД аукциона
        'user_id',                    //ИД пользователя
        'deposit_initial',            //Размер депозита (снимается один раз), потом не меняется
        'deposit_balance'            //Остаток депозита (уменьшается при каждом клике) на размер ставки
    ];

    public function makeReserv(User $user, Auction $auction){
        $resDecBid=$user->decBid(array('value'=>$auction->deposit));
        if(!$resDecBid['result']){
            return [
                'result'=>0,
                'value'=>0,
                'text_error'=>($resDecBid['error_code']==5)?
                    'На балансе недостаточно средств для списания депозита'
                    :$resDecBid['error_text']
            ];
        }
        $this->auction_id = $auction->id;
        $this->user_id = $user->id;
        $this->deposit_initial = $auction->deposit;
        $this->deposit_balance = $auction->deposit;
        $this->save();
        return [
            'result'=>1,
            'value'=>$this->deposit_balance
        ];
    }

    public function decReser(User $user, Auction $auction, $sum){
        //Уменьшение суммы депозита (проверка на остаток на уровень выше)
        $dep=$this->where('user_id',$user->id)->where('auction_id',$auction->id)->first();
        $dep->deposit_balance=$dep->deposit_balance-$sum;
        $dep->save();
        return 1;
    }
}
