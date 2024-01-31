<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Bid;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddBidUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user:bid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add bid to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $userInsta = '--';
//        $user = User::where('instagram', $userInsta)->first();
//        var_dump($user->bid);
//        $user->bid = $user->bid + 1;
//        var_dump($user->bid);
//        $user->save();
        $this->getReports();
    }

    public function getReports()
    {
        $auctionLotId = 127;
        $auction = Auction::find($auctionLotId);
        var_dump('===========');
        var_dump('Лот');
        var_dump('===========');
        var_dump('Наименование аукциона: ' . $auction->name);
        var_dump('Последнее Обновление лота аукциона: ' . \Carbon\Carbon::parse($auction->updated_at)->format('i:s'));
        var_dump('Изменение от предыдущей ставки внутри лота: ' . \Carbon\Carbon::parse($auction->time_last_interval)->format('i:s'));
        var_dump('===========');
        var_dump('Ставки');
        var_dump('===========');
        $bids = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->take(4)->get();
        foreach ($bids as $bid) {
            var_dump('Кто: ' . User::find($bid->user_id)['instagram']);
            var_dump('Когда: ' . \Carbon\Carbon::parse($bid->updated_at)->format('i:s'));
            var_dump('Новое время: ' . \Carbon\Carbon::parse($bid->time_to_left)->format('i:s'));
            var_dump('Что: ' . Auction::find($bid->auction_id)['name']);
        }
    }
}
