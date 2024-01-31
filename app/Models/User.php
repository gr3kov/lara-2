<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['first_letter_name','avatar'];

    public function isSuperAdmin()
    {
        $admin = User::where('id', '=', $this->id)
            ->where('role_id', '=', 1)
            ->first();
        if ($admin) {
            return true;
        } else {
            return false;
        }
    }

    public function isManager()
    {
        $operator = User::where('id', '=', $this->id)
            ->where('role_id', '=', 2)
            ->first();
        if ($operator) {
            return true;
        } else {
            return false;
        }
    }

    public function UserName(){
        if($this->instagram)return $this->instagram;
        if($this->telegram)return $this->telegram;
        if($this->email)return $this->email;
    }

    public function IncBid($data){//Операция зачисления на счет (в будущем можно будет передать время и дату
        //планируется следующий формат
        //[
        //  'value'=>'',
        //  'dt'=>'Дата + время',
        //  'text'=>'Информация для записи в историю',
        //]
        $this->bid=$this->bid+$data['value'];
        $result['value']=$this->bid;
        $this->save();
        $result['result']=1;
        return $result;
    }

    public function DecBid($data){//Операция зачисления на счет (в будущем можно будет передать время и дату
        if(!is_int($data['value'])){
            return [
              'result'=>0,
              'error_code'=>6,
              'error_text'=>'Значение для списание - "'.$data['value'].'" не является целым',
              'balance'=>$this->bid,
            ];
        }
        if($this->bid<$data['value']){
            return [
              'result'=>0,
              'error_code'=>5,
              'error_text'=>'Недостаточно суммы на балансе для списания',
              'balance'=>$this->bid,
            ];
        }
        $balance=$this->bid-$data['value'];
        $this->bid=$balance;
        $this->save();
        $result['value']=$balance;
        $result['result']=1;
        return $result;
    }

    public function getNameAttribute(){ //Получаем имям пользователя
        return $this->UserName();
    }

    public function getFirstLetterNameAttribute(){//Получаем перву букву пользователя для иконки
        $name = $this->UserName();
        if(strlen($name)>1)$fln=mb_strtoupper($name[0]);
        return $fln;
    }

    public function getAvatarAttribute(){
        if ($this->photo) return /*asset(env('AVATAR_PATH')).*/'/images/avatar/'.$this->photo;
            else return '/img/noavatar.svg';
    }

    public function referrals() {
        return $this->hasMany(RefCount::class, 'user_id', 'id');
    }

    public function getAllPartnersAttribute(): array
    {
        $partners = $this->referrals()->get();
        return $this->getAllPartners($partners);
    }

    public function getAllPartnersCountAttribute(): int
    {
        return count($this->all_partners);
    }

    public function getActiveReferralsCountAttribute(): int
    {
        return $this->active_referrals->count();
    }

    public function getActiveReferralsAttribute()
    {
        return $this->referrals()->where('first_sum', '!=', null)->get();
    }


    private function getAllPartners($partners, $all = []) : array
    {
        foreach ($partners as $partner) {
            $all[] = $partner;
            if($partner->referral != null) {
                $all = $this->getAllPartners($partner->referral->referrals, $all);
            }
        }

        return $all;
    }
}
