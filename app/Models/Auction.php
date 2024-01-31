<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Bid;
use App\Helpers\AuctionHelper;
use App\Models\AuctionDeposit;
use Illuminate\Support\Facades\DB;

class Auction extends Model
{
    protected $table = 'auction';
    protected $fillable = [
        'name',
        'images',
        'characteristic',
        'description',
        'price',
        'interval_time', //время между ставками
        'start_time', //когда был начат аукцион
        'time_to_start', //время когда стартует акцион
        'status_id', //Статус аукциона (новый, идет, завершен)
        'time_left', //осталось времени
        'time_last_interval', //время с последнего интервала
        'preview_image',
        'category',
        'payed',
        'leader_id',
        'bid',
        'restart_flag', //рестарт ставок 0 - не перезапущено 1 - перезапущено путем создания дубликата
        'deposit',  //размер депозита
        'bet_size',  //размер ставки (по умолчанию 1)
        'all_slots', // Всего мест
        'busy_slots', // Занятые места (будет изменяться скриптом, но не пользователем
    ];

    protected $casts = [
        'images' => 'array',
        'image' => 'image',
    ];

    protected $appends = [
      'lot_number',
      'leader',
      'is_favorite',
      'deposit_value',
      'time_left',
      'timer',
      'is_member',
      'is_status_id',
      'free_slots'
    ];

    public function status()
    {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    public function accordions()
    {
        return $this->belongsToMany('App\Models\AuctionAccordion', 'auction_to_accordion', 'auction_id', 'accordion_id');
    }

    /*public function scopeListActive(){    //Список лотов (активные)
        $user = \Auth::user();
        $return=[];
        if ($user) {
            $auctions = Auction::where('status_id', 3)->where('restart_flag', 0)->get();
            foreach ($auctions as $auction) {
                $bid = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();
                if ($bid && ($bid->user_id == $user->id)) {
                    //$auction->leader = AuctionHelper::getLeader($auction->id);
                    //$auction->leader = $auction->getLeader();
                    //$auction->is_favorite = $auction->isFavorite();
                    //$timeDiff = strtotime($auction->time_last_interval) - time();
                    //$auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
                    //$auction->timer = $auction->getTimer();
                    //$auction->deposit_value = $auction->depositValue();
                    //$auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                    //$auction->status_id=$auction->isEnded();
                    $auction->canPay = true;
                    $return[] = $auction;
                }
            }
        }
        return $return;
    }*/

    public function scopeListActive(){    //Список лотов (активные)
        $user = \Auth::user();
        if ($user) {
            $list_id =DB::table('auction')
              ->join('auction_deposit', 'auction.id', '=', 'auction_deposit.auction_id')
              ->select('auction.id')
              ->where('auction_deposit.user_id',$user->id)
              ->where('auction.status_id',2);
            return $this::whereIn('id', $list_id)->get();
        }
    }

    /*public function scopeListEnded(){      //Список лотов (закончились)
        $user = \Auth::user();
        $return=[];
        if ($user) {
            $auctions = Auction::where('status_id', 3)->where('restart_flag', 0)->get();
            foreach ($auctions as $auction) {
                $bid = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();
                if ($bid && ($bid->user_id == $user->id)) {
                    //$auction->leader = AuctionHelper::getLeader($auction->id);
                    $auction->leader = $auction->getLeader();
                    //$auction->is_favorite = $auction->isFavorite();
                    $timeDiff = strtotime($auction->time_last_interval) - time();
                    $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
                    $auction->timer = $auction->getTimer();
                    $auction->deposit_value = $auction->depositValue();
                    $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                    $auction->status_id=$auction->isEnded();
                    $auction->canPay = true;
                    $return[] = $auction;
                }
            }
        }
        return $return;
    }*/

    public function scopeListEnded(){      //Список лотов (закончились)
        $user = \Auth::user();
        if ($user) {
            $list_id =DB::table('auction')
              ->join('auction_deposit', 'auction.id', '=', 'auction_deposit.auction_id')
              ->select('auction.id')
              ->where('auction_deposit.user_id',$user->id)
              ->where('auction.status_id',3);
            return $this::whereIn('id', $list_id)->get();
        }
    }

    /*public function scopeListAnons(){     //Список лотов (анонс)
        $return=[];
        $user = \Auth::user();
        if ($user) {
            $auctions = Auction::where('status_id', 1)->get();
            foreach ($auctions as $auction) {
                //$auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                $auction->leader = $auction->getLeader();
                //$auction->is_favorite = $auction->isFavorite();
                $auction->timer = $auction->getTimer();
                $auction->deposit_value = $auction->depositValue();
                //$auction->isMember = $auction->isMember();
                $auction->status_id=$auction->isEnded();
                $return[] = $auction;
            }
        }
        return $return;
    }*/

    public function scopeListAnons(){     //Список лотов (анонс)
        $user = \Auth::user();
        if ($user) {
            $list_id =DB::table('auction')
              ->join('auction_deposit', 'auction.id', '=', 'auction_deposit.auction_id')
              ->select('auction.id')
              ->where('auction_deposit.user_id',$user->id)
              ->where('auction.status_id',1);
            return $this::whereIn('id', $list_id)->get();
        }
    }

    /*public function scopeListDisabled(){  //Список лотов (неактивные)
        $return=[];
        $user = \Auth::user();
        if ($user) {
            $auctions = Auction::where('status_id', 2)->get();
            foreach ($auctions as $auction) {
                $bid = Bid::where('user_id', $user->id)->where('auction_id', $auction->id)->first();
                if ($bid) {
                    //$auction->leader = AuctionHelper::getLeader($auction->id);
                    $auction->leader = $auction->getLeader();
                    //$auction->is_favorite = $auction->isFavorite();
                    $timeDiff = strtotime($auction->time_last_interval) - time();
                    $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
                    $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                    $auction->timer = $auction->getTimer();
                    $auction->deposit_value = $auction->depositValue();
                    //$auction->isMember = $auction->isMember();
                    $auction->status_id=$auction->isEnded();
                    $return[] = $auction;
                }
            }
        }
        return $return;
    }*/

    public function scopeListDisabled(){  //Список лотов (неактивные)
        $user = \Auth::user();
        if ($user) {
            $list_id =DB::table('auction')
              ->join('auction_deposit', 'auction.id', '=', 'auction_deposit.auction_id')
              ->select('auction.id')
              ->where('auction_deposit.user_id',$user->id)
              ->where('auction.status_id',3);
            return $this::whereIn('id', $list_id)->get();
        }
    }



    public function scopeListFavorites(){ //Список избранных лотов
        $return=[];
        $user = \Auth::user();
        if ($user) {
            $favorites = UsersFavorite::where('user_id', $user->id)->get();
            foreach ($favorites as $favorite) {
                $auction = Auction::find($favorite->auction_id);
                if ($auction) {// @todo И этот кусок можно будет сделать более элегантным
                    /*//$auction->leader = AuctionHelper::getLeader($favorite->auction_id);
                    $auction->leader = $auction->getLeader();
                    //$auction->is_favorite = true;
                    $timeDiff = strtotime($auction->time_last_interval) - time();
                    $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
                    $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                    $auction->timer = $auction->getTimer();
                    $auction->deposit_value = $auction->depositValue();
                    //$auction->isMember = $auction->isMember();
                    $auction->status_id=$auction->isEnded();*/
                    $return[] = $auction;
                }
            }
        }
        return $return;

    }

    public function isFavorite(){ //находится ли данный аукцион в списке избранных
        $user = \Auth::user();
        if ($user) {
            $FavoriteQuery = UsersFavorite::query();
            $FavoriteQuery->where('user_id', $user->id);
            $FavoriteQuery->where('auction_id', $this->id);
            $favorites = $FavoriteQuery->first();
            if($favorites)return true;
        }
        return false;
    }

    public function lastBid(){        // Последняя ставка в торгах
        return Bid::where('auction_id', $this->id)->orderby('created_at','desc')->first();
    }

    public function lastBidUser(){
        //Пользователь по последней ставке
        $bid=$this->lastBid();
        if($bid){
            $user = User::where('id',$bid->user_id)->first();
            return array(
                'bid'=>$bid,
                'user'=>$user
            );
        }
        return false;
    }

    public function getTimer(){
        //Получаем информацию по времени завершения (для кнопки)
        if($this->status->code == 'bid')
            return [
              'dv_all'=>floor($this->interval_time / 60) . ' : ' . ($this->interval_time % 60 < 10 ? '0' . $this->interval_time % 60 : $this->interval_time % 60),
              'time_left'=>$this->time_left,
              'dv_left'=>(floor($this->time_left / 60) < 10 ? '0' : '') . floor($this->time_left / 60) . ' : ' . ($this->time_left % 60 < 10 ? '0' . $this->time_left % 60 : $this->time_left % 60)
            ];
        if($this->status->code == 'start')
            return [
              'dv_all'=>floor($this->interval_time / 60) . ' : ' . ($this->interval_time % 60 < 10 ? '0' . $this->interval_time % 60 : $this->interval_time % 60),
              'time_left'=>$this->interval_time,
              'dv_left'=>floor($this->interval_time / 60) . ' : ' . ($this->interval_time % 60 < 10 ? '0' . $this->interval_time % 60 : $this->interval_time % 60)
            ];
        if($this->status->code == 'completed')
            return [
              'dv_all'=>floor($this->interval_time / 60) . ' : ' . ($this->interval_time % 60 < 10 ? '0' . $this->interval_time % 60 : $this->interval_time % 60),
              'time_left'=>0,
              'dv_left'=>floor($this->interval_time / 60) . ' : ' . ($this->interval_time % 60 < 10 ? '0' . $this->interval_time % 60 : $this->interval_time % 60)
            ];
    }

    public function depositValue(){
        //Получаем информацию по размеру депозита в текущем аукционе, текущего пользователя
        $user = \Auth::user();
        if ($user) {
            return AuctionDeposit::where('auction_id',$this->id)->where('user_id',$user->id)->orderby('created_at','desc')->first();
        }
        return false;
    }

    public function getLeader(){
        // Получаем инфу по лидеру ставок
        $leaderBid = $this->lastBid();
        if($leaderBid){
            $leader = User::find($leaderBid->user_id);
            $leader['name']=$leader->UserName();
            return $leader;
        }return null;
    }

    public function isMember(){   //Является ли текущий пользователь участнико аукциона
        $user = \Auth::user();
        if($user){
            $bid=Bid::where('auction_id',$this->id)->where('user_id',$user->id)->first();
            if($bid)return true;
        }
        return false;
    }

    public function newBid($start=null){
        $time = date('Y-m-d H:i:s', strtotime('+' . $this->interval_time . ' seconds'));
        $this->time_last_interval = $time;
        $this->price = $this->price + 1;
        $this->time_left = $this->interval_time; // сначала только интервал
        if($start){
            $this->start_time = date('Y-m-d H:i:s'); // когда начался аукцион
            $this->status_id = 2;
        }
        $this->save();
    }

    public function changeStatus($status_code){//Смена статуса аукциона
        if($status_code==2){
            if($this->status_id==3)return [
              'resutl'=>0,
              'error_text'=>'Невозможно сменить статус по завершенному аукциону'
            ];
            //Здесь можем отправлять нотификации по началу торгов пользователям
        }elseif($status_code==3){
            //Здесь можем отправлять нотификации по началу торгов пользователям
        }
        $auc=Auction::find($this->id);
        $auc->status_id=$status_code;
        $this->status_id=$status_code;
        $auc->save();
    }

    public function timeLeft(){//Сколько осталось времени
        $time_diff = strtotime($this->time_last_interval) - strtotime(date('Y-m-d H:i:s'));
        if($time_diff>0)return $time_diff;
            else{
                if($this->status_id==2)
                    $this->changeStatus(3);//Завершить аукцион
                return 0;
            }
    }

    public function isEnded(){
        if(($this->status_id==2)&&($this->timeLeft()==0))return 3;
            else return $this->status_id;
    }

    public function getIsFavoriteAttribute(){
        return $this->isFavorite();
    }

    public function getIsMemberAttribute(){
        return $this->isMember();
    }

    public function getFreeSlotsAttribute(){
        return $this->all_slots-$this->busy_slots;
    }

    public function takeOneSlot(){//Занять один слот
        if($this->free_slots<=0) return 0;
        $auc=Auction::find($this->id);
        $auc->busy_slots=$auc->busy_slots+1;
        $auc->save();
    }

    public function getLeaderAttribute(){
        return $this->getLeader();
    }

    public function getDepositValueAttribute(){
        return $this->depositValue();
    }

    public function getTimeLeftAttribute(){
        return $this->timeLeft();
    }

    public function getIsStatusIdAttribute(){
        return $this->isEnded();
    }

    public function getTimerAttribute(){
        return $this->getTimer();
    }

    public function getLotNumberAttribute(){
        return sprintf("%'.06d\n", $this->id);
    }

}
