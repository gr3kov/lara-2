<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\UsersFavorite;
use App\Models\AuctionCategory;
use App\Models\AuctionAccordion;
use App\Models\AuctionToAccordion;
use App\Helpers\AuctionHelper;
use App\Helpers\CheckListHelper;
use App\Models\UsersNotification;
use App\User;
use Artesaos\SEOTools\Facades\SEOMeta;

class AuctionController extends Controller
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
     * Метод вывода лота аукциона
     *
     * @param $auctionId integer Идентификатор аукциона
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|never
     */
    public function item($auctionId)
    {
        if (!isset($auctionId)) {
            return abort(404);
        }

        $item = Auction::find($auctionId);
        if (!$item) {
            return abort(404);
        }

        $timeDiff = strtotime($item->time_last_interval) - time();
        $item->time_left = $timeDiff > 0 ? $timeDiff : 0;

        $user = \Auth::user();

        $bid = Bid::where('auction_id', $auctionId)->orderBy('id', 'desc');
        $bids = $bid->get();
        $leaderBid = $bid->first();
        $leader = ($leaderBid) ? \App\Models\User::find($leaderBid->user_id) : '';
        $isFavorite = $item->isFavorite();
        $item->lot_number = AuctionHelper::getAuctionNumber($item->id);
        $item->deposit_value = $item->depositValue();
        $item->timer = $item->getTimer();
        $item->status_id = $item->isEnded(); //проверка на завершение, если завершился, получаем новый статус без перезагрузки данных
        if($leader) {
            $getNotification = Notification::query()->where(['item_id' => $item->id, 'user_id' => $leader->id])->first();
            if ($getNotification == null) {
                $notification = Notification::query()->create([
                    'name' => 'Поздравляем с победой в аукционе, вы выиграли: ' . $item->name . '. Для того чтобы забрать его свяжитесь с нами по почте: migom.inc@gmail.com',
                    'title' => 'Победа',
                    'item_id' => $item->id,
                    'user_id' => $leader->id
                ]);

                if ($notification) {
                    UsersNotification::query()->create([
                        'notification_id' => $notification->id,
                        'user_id' => $leader->id,
                        'is_show' => 1
                    ]);
                }
            }
        }


        $additionalDescription = [];
        foreach (AuctionToAccordion::where('auction_id', $item->id)->get() as $ac_nom) {
            $additionalDescription[] = AuctionAccordion::find($ac_nom->accordion_id);
        }

        $auctionCategory = AuctionCategory::where('slug', $item->category)->first();

        return view(
          'auction.item',
          [
            'leader' => $leader,
            'user' => $user,
            'bids' => $bids,
            'isFavorite' => $isFavorite ? true : false,
            'item' => $item,
            'auctionCategory' => $auctionCategory,
            'additionalDescription' => $additionalDescription,
          ]
        );
    }

    public function getAuctionItem($id)
    {
        $data = $this->getData($id);
        return view('index_item', ['data' => $data, 'canPay' => true]);
    }

    public function getData($id)
    {
        $data = [];
        $auction = Auction::find($id);
        $data['auctionItems'] = [];
        $user = \Auth::user();
        $lastDateBid = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();
        if ($auction->status_id == 3) {

        } else {
            $home = new HomeController();
            $auction->leader = $home->getLeaderInsta($auction->id);
            $timeDiff = strtotime($auction->time_last_interval) - time();
            $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
            $auction->lot_number = $home->getAuctionNumber($auction->id);

            if ($timeDiff <= 0 && $user) {
                if ($lastDateBid['user_id'] == $user->id) {
                    $auction->canPay = $home->isCanPay($auction->created_at);
                }
            }
            array_push($data['auctionItems'], $auction);
        }

        return $data;
    }

    public function getAuctionLots()
    {
        $data = [];
        $auctions = Auction::where('status_id', '<>', 3)->get();
        foreach ($auctions as $auction) {
            $timeDiff = strtotime($auction->time_last_interval) - time();
            $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
            $bid = Bid::where('auction_id', $auction->id)->orderby('id', 'desc')->first();
            if ($bid) {
                $user = User::where('id', $bid->user_id)->first();
                $auction->user = $user['instagram'];
                $auction->user_photo = $user['photo'];
            }
            array_push($data, $auction);
        }
        return $data;
    }

    /**
     * Список ставок по указанному аукциону
     * Дёргается аяксом, возвращает json со список ствок и информацией по ним
     *
     * @param $auctionId integer Идентификатор аукциона
     * @return string
     */
    public function getAuctionBidsTable($auctionId)
    {
        $result = [];
        $bids = Bid::where('auction_id', $auctionId)->orderBy('id', 'desc')->get();
        foreach ($bids as $bid) {
            $user=\App\Models\User::find($bid->user_id);
            $result[] = [
              'price' => $bid->new_price,
              'date' =>date('H:i', strtotime($bid->created_at)),
              'name' => $user->name,
              'fln'=>$user->first_letter_name,
              'photo'=>$user->avatar
            ];
        }

        return json_encode($result);
    }

    /////////////////


    /**
     * Страница мои аукционы
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function myAuction()
    {
        $pageNavigation = [
          'myAuctionsActive' => [
            'title' => 'Активные аукционы',
            'slug' => 'myauctions_active',
            'active' => true,
            'auctionItems' => [],
          ],
          'myAuctionsAnons' => [
            'title' => 'Анонсы',
            'slug' => 'myauctions_anons',
            'active' => false,
            'auctionItems' => [],
          ],
          'myAuctionsDisabled' => [
            'title' => 'Победы',
            'slug' => 'myauctions_disabled',
            'active' => false,
            'auctionItems' => [],
          ],
          'myAuctionsFavorites' => [
            'title' => 'Избранное',
            'slug' => 'myauctions_favorites',
            'active' => false,
            'auctionItems' => [],
          ],
          'myAuctionsEnded' => [
            'title' => 'Неактивные аукционы',
            'slug' => 'myauctions_ended',
            'active' => false,
            'auctionItems' => [],
          ],
        ];

        $user = \Auth::user();
        if ($user) {
            $pageNavigation['myAuctionsActive']['auctionItems']=Auction::listActive();
            $pageNavigation['myAuctionsEnded']['auctionItems']=Auction::listEnded();
            $pageNavigation['myAuctionsAnons']['auctionItems']=Auction::listAnons();
            $pageNavigation['myAuctionsDisabled']['auctionItems']=Auction::listDisabled();
            $pageNavigation['myAuctionsFavorites']['auctionItems']=Auction::listFavorites();

            /*$auctions = Auction::where('status_id', 3)->where('restart_flag', 0)->get();
            foreach ($auctions as $auction) {
                $bid = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();
                if ($bid && ($bid->user_id == $user->id)) {
                    $auction->leader = AuctionHelper::getLeader($auction->id);
                    $timeDiff = strtotime($auction->time_last_interval) - time();
                    $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
                    $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                    $auction->canPay = true;
                    $pageNavigation['myAuctionsActive']['auctionItems'][] = $auction;
                    $pageNavigation['myAuctionsEnded']['auctionItems'][] = $auction;
                }
            }
            $auctions = Auction::where('status_id', 1)->get();
            foreach ($auctions as $auction) {
                $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                $pageNavigation['myAuctionsAnons']['auctionItems'][] = $auction;
            }
            $auctions = Auction::where('status_id', 2)->get();
            foreach ($auctions as $auction) {
                $bid = Bid::where('user_id', $user->id)->where('auction_id', $auction->id)->first();
                if ($bid) {
                    $auction->leader = AuctionHelper::getLeader($auction->auction_id);
                    $timeDiff = strtotime($auction->time_last_interval) - time();
                    $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
                    $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                    $pageNavigation['myAuctionsDisabled']['auctionItems'][] = $auction;
                }
            }
            $favorites = UsersFavorite::where('user_id', $user->id)->get();
            foreach ($favorites as $favorite) {
                $auction = Auction::find($favorite->auction_id);
                if ($auction) {
                    $auction->leader = AuctionHelper::getLeader($favorite->auction_id);
                    $timeDiff = strtotime($auction->time_last_interval) - time();
                    $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
                    $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                    $pageNavigation['myAuctionsFavorites']['auctionItems'][] = $auction;
                }
            }*/
        }

        return view(
          'auction.myAuction',
          [
            'title' => 'Мои аукционы',
            'canPay' => true,
            'pageNavigation' => $pageNavigation,
          ]
        );
    }

    /**
     * Страница мои ставки
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function myBids()
    {
        $auctionItems = [];
        $user = \Auth::user();
        if ($user) {


        }

        return view(
          'auction.myBids',
          [
            'title' => 'Мои ставки',
            'auctionItems' => $auctionItems,
          ]
        );
    }


    /**
     * Старница с аукционами конкретной категории
     *
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|never
     */
    public function category($slug = null)
    {
        $auctionCategory = AuctionCategory::where('slug', $slug)->first();

        if (!$auctionCategory) {
            return abort(404);
        }
        $auctionItems = [];
        $auctions = Auction::where('category', $auctionCategory->slug)->take(50)->get();
        $user = \Auth::user();
        foreach ($auctions as $auction) {
            $lastDateToCompare = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($auction->updated_at)));
            $tomorrow = date('Y-m-d', strtotime('+1 day', time()));
            $lastDateBid = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();
            if ($lastDateBid) {
                $lastDateToCompareBid = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($lastDateBid->created_at)));
                if (($auction->status_id == 3) && (($lastDateToCompare <= $tomorrow)
                    || ($auction->payed == 1) || ($lastDateToCompareBid <= $tomorrow))) {
                    continue;
                }

                $auction->leader = AuctionHelper::getLeader($auction->id);
                $timeDiff = strtotime($auction->time_last_interval) - time();
                $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
                if (($timeDiff <= 0 && $user) && ($lastDateBid->user_id == $user->id)) {
                    $auction->canPay = true;
                }
            }
            //$auction->is_favorite = $auction->isFavorite();
            $auction->timer = $auction->getTimer();
            $auction->status_id=$auction->isEnded();
            $auction->deposit_value = $auction->depositValue();
            $auction->leader = $auction->getLeader();
            //$auction->isMember = $auction->isMember();
            $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
            array_push($auctionItems, $auction);
        }

        SEOMeta::setTitle($auctionCategory->title);
        SEOMeta::setDescription($auctionCategory->description);
        SEOMeta::setCanonical(route('category', $slug));

        return view(
          'auction.category',
          [
            'auctionCategory' => $auctionCategory,
            'auctionItems' => $auctionItems,
              'user' => $user
          ]
        );
    }
}
