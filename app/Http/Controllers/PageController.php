<?php
/**
 * Контроллер вывода условно статических страниц, в основном текстов договоров и описания работы сайта
 *
 */

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Docs;
use App\Models\Page;
use App\User;
use App\Helpers\AuctionHelper;
use App\Helpers\CheckListHelper;
use Artesaos\SEOTools\Facades\SEOMeta;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//       $this->middleware('auth');
    }

    /**
     * Страница частых вопросов
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function faq()
    {
        SEOMeta::setTitle('Вопрос - ответ на онлайн аукционе Flame Auctoin');
        SEOMeta::setDescription('Рубрика вопрос - ответ с подробной информацией о онлайн аукционе Flame Auctoin. Блок вопрос - ответ на сайте онлайн аукциона Flame Auctoin.');
        SEOMeta::setCanonical(route('faq'));
        SEOMeta::addKeyword('вопрос ответ');

        return view(
            'pages.faq',
            [
                'title' => 'Частые вопросы',
                'array' => Page::$_faqArray,
            ]
        );
    }

    /**
     * Страница пользовательского соглашения
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function agreement()
    {
        $docs = Docs::where('code', 'agreement')->first();

        SEOMeta::setTitle('Пользовательское соглашение с онлайн аукционом Flame Auctoin');
        SEOMeta::setDescription('Ознакомиться с пользовательским соглашением онлайн аукциона Flame Auctoin. Прочитать соглашение пользователя онлайн аукциона Flame Auctoin.');
        SEOMeta::setCanonical(route('agreement'));
        SEOMeta::addKeyword('пользовательское соглашение');

        return view(
            'pages.static',
            [
                'title' => 'Пользовательское соглашение',
                'docs' => $docs,
            ]
        );
    }

    /**
     * Страница офферты
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function offer()
    {
        $docs = Docs::where('code', 'offer')->first();

        SEOMeta::setTitle('Публичная оферта онлайн аукциона Flame Auctoin');
        SEOMeta::setDescription('Ознакомиться с публичной офертой онлайн аукциона Flame Auctoin. Прочитать публичную оферту от онлайн аукциона Flame Auctoin.');
        SEOMeta::setCanonical(route('offer'));
        SEOMeta::addKeyword('публичная оферта');

        return view(
            'pages.static',
            [
                'title' => 'Публичная оферта',
                'docs' => $docs,
            ]
        );
    }

    /**
     * Страница гарантии безопасности
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function security()
    {
        $docs = Docs::where('code', 'security')->first();

        SEOMeta::setTitle('Гарантия безопасности покупки и продажи товаров в онлайн аукционе Flame Auctoin');
        SEOMeta::setDescription('Гарантия безопасности в оналйн аукционе Flame Auctoin. Ознакомиться с гарантия безопасности участия в онлайн аукционе Flame Auctoin.');
        SEOMeta::setCanonical(route('security'));

        return view(
            'pages.static',
            [
                'title' => 'Гарантия безопасности',
                'docs' => $docs,
            ]
        );
    }

    /**
     * Страница тактики победы
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function tactics()
    {
        SEOMeta::setTitle('Тактика победы в онлайн аукционе Flame Auctoin');
        SEOMeta::setDescription('Тактика победы в онлайн аукционе Flame Auctoin для каждого. Как победить в онлайн аукционе Flame Auctoin гарантированная тактика.');
        SEOMeta::setCanonical(route('tactics'));
        SEOMeta::addKeyword('тактика победы');

        CheckListHelper::instance()->mark(7);

        return view(
            'pages.tactics',
            [
                'title' => 'Тактика победы',
            ]
        );
    }

    /**
     * Страница о нас
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function about()
    {
        $totalUsers = User::where('is_ban', '!=', 1)->get()->count();
        $auctionsToday = Auction::whereDate('created_at', \DB::raw('CURDATE()'))->get()->count();
        $lastUserRegistration = User::where('is_ban', '!=', 1)->orderBy('created_at', 'desc')->take(10)->get();

        SEOMeta::setTitle('Подробная информация о онлайн аукционе Flame Auctoin');
        SEOMeta::setDescription('Подробная информация о нашей команде и партнерах. Вся информация про онлайн аукцион Flame Auctoin.');
        SEOMeta::setCanonical(route('about'));
        SEOMeta::addKeyword('о нас');

        CheckListHelper::instance()->mark(1);

        return view(
            'pages.about',
            [
                'title' => 'О нас',
                'totalUsers' => $totalUsers,
                'auctionsToday' => $auctionsToday,
                'lastUserRegistration' => $lastUserRegistration,
            ]
        );
    }

    public function pay()
    {
        return view('pay');
    }

    public function how()
    {
        $docs = Docs::where('code', 'how')->first();

        SEOMeta::setTitle('Как работает онлайн аукцион Flame Auctoin в России');
        SEOMeta::setDescription('Информация о работе онлайн аукциона Flame Auctoin в России. Читать подробное описание работы аукциона Flame Auctoin на всей территории России.');
        SEOMeta::setCanonical('https://imperialonline.ru/how');
        SEOMeta::addKeyword('как работает, россия');

        return view('how', ['data' => $docs]);
    }

    /**
     * Страница доставки и оплаты
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function delivery()
    {
        SEOMeta::setTitle('Доставка товара купленного в онлайн аукционе Flame Auctoin');
        SEOMeta::setDescription('Доставка товара выигранного лота в онлайн аукционе Flame Auctoin в России. Информация о доставки товара по территории России.');
        SEOMeta::setCanonical(route('delivery'));
        SEOMeta::addKeyword('доставка товара, россия');

        return view(
            'pages.delivery',
            [
                'title' => 'Доставка и оплата',
            ]
        );
    }

    public function partners()
    {
        return view('partners');
    }

    public function payMethods()
    {
        return view('pay_methods');
    }

    public function changePasswordFinish()
    {
        return view('change_password');
    }

    public function activateInfo()
    {
        return view('activate_info');
    }

    /**
     * Страница победителей
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function winners()
    {
        $count = 20;
        $auctionItems = [];
        $auctions = Auction::where('status_id', 3)
          ->where('name', 'not like', 'Пакет%')->orderBy('updated_at', 'desc');
        if ($count > 0) {
            $auctions->take($count);
        }
        $auctions = $auctions->get();
        foreach ($auctions as $auction) {
            $lastDateToCompare = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($auction->updated_at)));
            $tomorrow = date('Y-m-d', strtotime('+1 day', time()));
            if ($lastDateToCompare >= $tomorrow) {
                continue;
            }
            $auction->leader = AuctionHelper::getLeader($auction->id);
            if (!$auction->leader) {
                continue;
            }
            $timeDiff = strtotime($auction->time_last_interval) - time();
            $auction->time_left = $timeDiff > 0 ? $timeDiff : 0;
            $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
            array_push($auctionItems, $auction);
        }

        SEOMeta::setTitle('Архив победителей в онлайн аукционе Flame Auctoin');
        SEOMeta::setDescription('Архив предыдущих победителей в онлайн аукционе Flame Auctoin. Ознакомиться с архивом победителей и выигранным товаром в онлайн аукционе Flame Auctoin.');
        SEOMeta::setCanonical(route('winners'));
        SEOMeta::addKeyword('Лента победителей');

        CheckListHelper::instance()->mark(6);

        return view(
          'auction.winners',
          [
            'title' => 'Лента победителей',
            'auctionItems' => $auctionItems,
          ]
        );
    }

    /**
     * Страница с аукционами (условно главная)
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function auction()
    {
        // Ожидаемые аукционы
        $auctionItems = [];
        $auctions = Auction::whereDate('time_to_start', '<=', \DB::raw('CURDATE()'))
          ->where('restart_flag', 0)->orderBy('status_id', 'asc')->orderBy('price', 'desc')->get();
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
                //$auction->is_favorite = $auction->isFavorite();
                $auction->timer = $auction->getTimer();
                $auction->deposit_value = $auction->depositValue();
                $auction->lot_number = AuctionHelper::getAuctionNumber($auction->id);
                //$auction->isMember = $auction->isMember();
                if (($timeDiff <= 0 && $user) && ($lastDateBid->user_id == $user->id)) {
                    $auction->canPay = true;
                }
                array_push($auctionItems, $auction);
            }
        }

        $categories = AuctionHelper::auctionCategoryItems();

        SEOMeta::setTitle('Онлайн аукцион Flame Auctoin в России купить и продать вещь на аукционе');
        SEOMeta::setDescription('Онлайн аукцион Flame Auctoin оставить заявку на участие в аукционе России. Купить на аукционе вищь и выставить вещь на онлайн аукцион товаров в интернете в России.');
        SEOMeta::setCanonical(route('home'));
        SEOMeta::addKeyword('онлайн аукцион, Flame Auctoin, россия, купить, продать, вещь, оставить, заявка, участие, выставить, товар, интернет');

        return view(
          'auction.auction',
          [
            'title' => 'Онлайн аукцион',
            'auctionItems' => $auctionItems,
            'categories' => $categories,
              'user' => $user
          ]
        );
    }

    public function userInfo($id = null){
        if($id){
            $user = \App\Models\User::find($id);
            $current_user = \Auth::user();
            if($user)return json_encode([
              'id'=>$user->id,
              'name'=>$user->UserName(),
              'fln'=>$user->first_letter_name,
              'photo' => $user->photo,
              'its_you'=>($user->id==$current_user->id)
            ]);
        }
    }
}
