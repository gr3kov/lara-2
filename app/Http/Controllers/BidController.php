<?php

namespace App\Http\Controllers;

use App\Helpers\AuctionHelper;
use App\Models\Auction;
use App\Models\Bid;
use App\Events\AuctionMessageSent;
use App\Models\AuctionDeposit;

class BidController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Метод запуска аукциона
     *
     * @param $auctionId integer Идентификатор аукциона
     * @return array
     */
    //@todo не вижу смысла иметь две фукнции start и bid. Они практически идентичны - планирую из 2х сделать одну
    public function startAuction($auctionId)
    {
        $result = [
            'error' => '',
            'auction' => '',
            'user' => '',
        ];
        $user = \Auth::user();
        if ($user->bid > 0) {
            $auction = Auction::where('id', $auctionId)->where('status_id', 1)->first();
            if ($auction) {
                if(($auction->status_id>1)&&($auction->timeLeft()==0)){
                    return ['error'=>'Лот уже завершен'];
                }
                $depositValue=$auction->depositValue();
                if(!$depositValue){//Депозит еще не вносился в данный аукцион
                    if($auction->free_slots<=0)return ['К сожалению, нет свободных слотов'];
                    $auction->takeOneSlot();//Занимаем один слот
                    $dep= new AuctionDeposit();
                    $dep_reserv=$dep->makeReserv($user,$auction);//Резервируем депозит
                    if(!$dep_reserv['result'])//не смогли зарезервировать депозит
                        return [
                          'error'=>$dep_reserv['text_error']
                        ];
                }

                if(time()-strtotime($auction->time_to_start)<0){
                    return [
                      'status'=>'reservation',
                      'auction'=>[
                        'id'=>$auction->id,
                        'free_slots'=>$auction->free_slots-1, // количество слотов уже уменьшилось, но что бы не считывать значение еще раз (не тратиь время сервера) просто указываем на 1цу меньше
                      ],
                      'deposit_value'=>$auction->depositValue(),
                      'button'=>['text'=>'Вы участвуете'],
                      'user'=>['bid'=>$user->bid],
                      'message'=>'Вы участник аукциона. Аукцион начнется - '.$auction->start_time.' не пропустите начало.'
                    ];
                }

                $bid = new Bid();
                $res_payForBet=$bid->payForBet($user,$auction); //Списание платы за ставку
                if($res_payForBet['result']==1){  //деньги списались успешно
                    $bid_result=$bid->add($user,$auction);
                    if($bid_result['result']){

                        $auction->newBid('start');

                        event(new AuctionMessageSent($auction, $user));
                        //AuctionHelper::sendMessageToGuard($auction, $user->id);

                        $result=$bid->getResult($user,$auction);
                    }else $result['error']=$bid_result['text_error'];  //Ошибка добавления ставки (недостаточно средств, другие причины)
                }else{//деньги не были списаны
                    $result['error']=$res_payForBet['error_text']; //выводим ошибку почему не списались деньги
                }
            }
        } else {
            $result['error'] = 'Нет доступных ставок';
        }

        return $result;
    }

    /**
     * Метод установки ставки
     *
     * @param $auctionId integer Идентификатор аукциона
     * @return string[]
     */
    public function bid($auctionId)
    {
        $result = [
            'error' => '',
            'auction' => '',
            'user' => '',
        ];
        $user = \Auth::user();
        if ($user->bid > 0) {
            $auction = Auction::where('id', $auctionId)->where('status_id', 2)->first();
            if ($auction) {
                if($auction->timeLeft()==0){
                    return ['error'=>'Лот уже завершен'];
                }
                $depositValue=$auction->depositValue();
                if(!$depositValue){//Депозит еще не вносился в данный аукцион
                    if($auction->free_slots<=0)return ['К сожалению, нет свободных слотов'];
                    $auction->takeOneSlot();//Занимаем один слот
                    $dep= new AuctionDeposit();
                    $dep_reserv=$dep->makeReserv($user,$auction);//Резервируем депозит
                    if(!$dep_reserv['result'])//не смогли зарезервировать депозит
                        return [
                          'error'=>$dep_reserv['text_error']
                        ];
                }
                $bids = Bid::where('auction_id', $auctionId)->orderby('id', 'desc')->get();
                if ($bids[0]->user_id == $user->id) {
                    $result['error'] = 'Нельзя перебить свою ставку';
                } else {
                    $bid = new Bid();
                    $res_payForBet=$bid->payForBet($user,$auction); //Списание платы за ставку
                    if($res_payForBet['result']==1){  //деньги списались успешно
                        $bid_result=$bid->add($user,$auction,count($bids) + 1);
                        if($bid_result['result']){

                            $auction->newBid('start');

                            event(new AuctionMessageSent($auction, $user));
                            //AuctionHelper::sendMessageToGuard($auction, $user->id);

                            $result=$bid->getResult($user,$auction);
                        }else $result['error']=$bid_result['text_error'];  //Ошибка добавления ставки (недостаточно средств, другие причины)
                    }else{//деньги не были списаны
                        $result['error']=$res_payForBet['error_text']; //выводим ошибку почему не списались деньги
                    }
                }
            } else {
                $result['error'] = 'Аукцион уже завершен';
            }
        } else {
            $result['error'] = 'Нет доступных ставок';
        }
        return $result;
    }
}
