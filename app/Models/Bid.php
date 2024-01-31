<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Bid extends Model
{
    protected $table = 'bid';
    protected $fillable = [
        'auction_id',
        'user_id',
        'time_to_left',
        'new_price',
        'auction_code',
        'bid_spend',
        'new_status_id',
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function auction()
    {
        return $this->hasOne('App\Models\Auction', 'id', 'auction_id');
    }

    public function add(//Добавляем ставку
      User $user, Auction $auction, $nom=1
    ){
        //@todo здесь добавить проверку на размер депозита, если не хватает - проверить баланс. После списать нужную сумму, если недостаочно - вернуть ошибкау
        $this->auction_id = $auction->id;
        $this->user_id = $user->id;
        $this->time_to_left = $auction->interval_time;
        $this->new_price = $auction->price + 1;
        $this->auction_code = $auction->id . '-' . $nom; // Номер ставки (хз зачем, но так было, не стал менять, поэтому добавил в метод)
        $this->bid_spend = '1'; //потрачено
        $this->new_status_id = 2;
        $this->save();
        return [
          'result'=>1,
        ];
        //Вслучае не прошеджей проверки
        /*return [
          'result'=>0,
          'text_error'=>'Текст ошибки (недостаточно размера счета)'
        ];*/
    }

    public function getResult(//формируем ответ ставки (в случае удачи, проверка производитеся на уровень выше)
      User $user, Auction $auction
    ){
        $result['bids'] = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->take(10)->get();
        $result['auction'] = $auction;
        $result['user'] = [
          'name' => $user->UserName(),
          'photo' => $user->photo,
          'bid' => $user->bid,
        ];
        $result['timer']=$auction->getTimer();
        $result['deposit_value']=$auction->depositValue();
        return $result;
    }

    //Снять плату за ставку
    public function payForBet(User $user, Auction $auction){
        $depositValue=$auction->depositValue();
        if($depositValue['deposit_balance']<$auction->bet_size){
            //Сумма на депозите меньше суммы списания, задействуем баланс пользователя
            $decDep=$depositValue['deposit_balance'];       //Сумма для списания с депозита
            $decBid=$auction->bet_size-$decDep;              //Сумма для списания со счета
            if($decBid>$user->bid)
                return [
                  'result'=>0,
                  'error_core'=>5,
                  'error_text'=>'Стоимость ставки - '.$auction->bet_size.'FLAMES,
                        Остаток депозита - '.$depositValue['deposit_balance'].'FLAMES,
                        Остаток на счету - '.$user->bid.'FLAMES'
                ];
            //Списание с депозита и со счета
            $dep = new AuctionDeposit;
            $dep->decReser($user, $auction, $decDep);
            $user->DecBid(['value'=>$decBid]);
            //Вот тут при желании можно добавить проверочки на удачное списание, но мне кажется проверок и так достаточно на уровень выше
        }else {
             //Списание только с депозита
             $dep = new AuctionDeposit;
             $dep->decReser($user, $auction, $auction->bet_size);
        }
        return ['result'=>1];
    }
}
