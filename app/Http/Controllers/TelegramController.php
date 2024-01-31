<?php

namespace App\Http\Controllers;

use App\Helpers\AuctionHelper;
use App\Helpers\TextHelper;
use App\Models\ActiveUsers;
use App\Models\Auction;
use App\Models\Autobid;
use App\Models\BidDayStats;
use App\Models\BidStats;
use App\Models\RefCount;
use Carbon\Carbon;
use Voronkovich\SberbankAcquiring\Client;
use App\Models\AuctionToAccordion;
use App\Models\Notification;
use App\User;

class TelegramController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function telegramRegister()
    {
        //https://api.telegram.org/bot{my_bot_token}/setWebhook?url={url_to_send_updates_to}
        //https://api.telegram.org/bot{token}/getWebhookInfo
    }

    public function index()
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $apiURL = env('TELEGRAM_API_URL') . $botToken . '/';

        $content = file_get_contents("php://input");
        $update = json_decode($content, true);
        $chatID = $update["message"]["chat"]["id"];
        $textFromUser = $update["message"]["text"];
        $userID = $update["message"]["from"]["id"];
        $admin = ["125951145", "733413821"];
        $commands = new BotCommands($apiURL);

        if (in_array($userID, $admin)) {
            $commandsResult = $commands->commandsDoOrFalse($textFromUser, $update);
            if ($commandsResult === false) {
                $commands->commandsAdmin($textFromUser, $update);
            }
        } else {
            $commandsResult = $commands->commandsDoOrFalse($textFromUser, $update);
            if ($commandsResult === false) {
                $commands->commandsDefault($textFromUser, $update);
            }
        }
    }

    public function sendDeliveryItem($id)
    {
        $botToken = env('TELEGRAM_BOT_DELIVERY_TOKEN');
        $apiURL = env('TELEGRAM_API_URL') . $botToken . '/';

        $content = file_get_contents("php://input");
        $update = json_decode($content, true);
        //$chatID = $update["message"]["chat"]["id"];
        $textFromUser = 'dItem' . $id;
        //$userID = $update["message"]["from"]["id"];
        $admin = ["125951145", "733413821"];
        foreach ($admin as $user) {
            $commands = new BotCommands($apiURL);
            $update["message"]["chat"]["id"] = $user;
            $update["message"]["from"]["first_name"] = $user;
            $commands->commandsDeliveryAdmin($textFromUser, $update);
        }
    }

    public function delivery()
    {
        $botToken = env('TELEGRAM_BOT_DELIVERY_TOKEN');
        $apiURL = env('TELEGRAM_API_URL') . $botToken . '/';

        $content = file_get_contents("php://input");
        $update = json_decode($content, true);
        $chatID = $update["message"]["chat"]["id"];
        $textFromUser = $update["message"]["text"];
        $userID = $update["message"]["from"]["id"];
        $admin = ["125951145", "733413821"];
        $commands = new BotCommands($apiURL);

        if (in_array($userID, $admin)) {
            $commandsResult = $commands->commandsDeliveryDoOrFalse($textFromUser, $update);
            if ($commandsResult === false) {
                $commands->commandsDeliveryAdmin($textFromUser, $update);
            }
        } else {
            $commandsResult = $commands->commandsDeliveryDoOrFalse($textFromUser, $update);
            if ($commandsResult === false) {
                $commands->commandsDefault($textFromUser, $update);
            }
        }
    }
}


/*
Доступные команды
help - помощь
start - начать работу
settings - доступные настройки
subscribe - подписаться на акции
unsubscribe - отписаться от акций
Скрытые команды
myid - получить свой идентификатор
get sale - получить текущую акцию
create sale - создать акцию
start sale - запустить рассылку по подписчикам
get sb - получить текущих подписчиков
*/

class BotCommands
{
    public $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function commandsDoOrFalse($command, $update)
    {
        $chatID = $update["message"]["chat"]["id"];
        if ($command == "/myid") {
            $userID = $update["message"]["from"]["id"];
            $this->botReply($userID, $chatID);
        } elseif ($command == "/start") {
            $reply = "Добрый день, этот бот может создавать, копировать, удалять лоты, получать статистику и многое другое";
            $this->botReply($reply, $chatID);
        } else {
            return false;
        }
    }

    public function commandsDeliveryDoOrFalse($command, $update)
    {
        $chatID = $update["message"]["chat"]["id"];
        if ($command == "/myid") {
            $userID = $update["message"]["from"]["id"];
            $this->botReply($userID, $chatID);
        } elseif ($command == "/start") {
            $reply = "Добрый день, этот бот может получать и обрабатывать информацию по доставке лотов";
            $this->botReply($reply, $chatID);
        } else {
            return false;
        }
    }

    public function commandsDefault($command, $update)
    {
        $chatID = $update["message"]["chat"]["id"];
        $first_name = $update["message"]["from"]["first_name"];
        $reply = "Привет, " . $first_name . ", мне можно задать вопросы, используя команды.";
        $this->botReply($reply, $chatID);
    }

    public function commandsAdmin($command, $update)
    {
        $chatID = $update["message"]["chat"]["id"];
        if (preg_match('/(?=create sale)/', $command) == "1") {
            $textForAction = substr($command, 12);
            $this->recordinFile($textForAction);
            $reply = "Акция создана.";
            $this->botReply($reply, $chatID);
        } elseif ($command == "/get sale") {
            $reply = $this->getFromFile();
            $this->botReply($reply, $chatID);
        } elseif ($command == "/start sale") {
            $reply = "Команда в разработке, сейчас невозможно запустить рассылку.";
            $this->botReply($reply, $chatID);
        } elseif ($command == "/get sb") {
            $reply = "Команда в разработке, сейчас невозможно получить подписчиков.";
            $this->botReply($reply, $chatID);
        } elseif ($command == "/help") {
            $reply = urlencode("*Доступные команды:*
1. /help - помощь
2. /start - начать работу
3. /search - поиск лотов, выдаёт список лотов с их ID (номером)
4. /myid - получить свой идентификатор
5. /create - создаёт лот на аукционе, обязательно укажите стоимость через пробел и время в секундах, пример /create 863 2000 240
6. /stats - запрос статистики
7. /month - статистика по месяцам
8. /delivery - получить неотправленные лоты, можно указать количество как /delivery 30
9. /sent - пометить лот как отправленный, пример  /sent1931
10. /ref - получить статистику по рефералам
11. /guard - получить список защитников
            ");
            $this->botReply($reply, $chatID);
        } elseif (preg_match('/(?=search)/', $command) == "1") {
            $textForSearch = substr($command, 8);
            $reply = $this->searchAuction($textForSearch, $chatID);
        } elseif ($command == "/stats") {
            $reply = $this->getStats();
            $replySecond = $this->getStatsMonth();
            $this->botReply($reply, $chatID);
//            $this->botReply($replySecond, $chatID);
        } elseif ($command == "/month") {
            $reply = $this->getStatsMonth();
            $this->botReply($reply, $chatID);
        } elseif ($command == "/unsubscribe") {
            $reply = "Вы успешно отписались от рассылки.";
            $this->botReply($reply, $chatID);
        } elseif ($command == "/settings") {
            $reply = "Доступных настроек на данный момент нет.";
            $this->botReply($reply, $chatID);
        } elseif ($command == "/ref") {
            $reply = $this->getRef();
            $this->botReply($reply, $chatID);

        } elseif (preg_match('/(?=create)/', $command) == "1") {
            $textForSearch = substr($command, 8);
            $reply = $this->createAuction($textForSearch, $chatID);
        } elseif (preg_match('/(?=sent)/', $command) == "1") {
            $id = substr($command, 5);
            $reply = $this->sentAuction($id);
            $this->botReply($reply, $chatID);
        } elseif (preg_match('/(?=delivery)/', $command) == "1") {
            $numbers = substr($command, 10);
            $reply = $this->getNotDelivered($numbers);
            $this->botReply($reply, $chatID);
        } elseif ($command == "/guard") {
            $reply = $this->getGuard();
            $this->botReply($reply, $chatID);
        } else {
            $first_name = $update["message"]["from"]["first_name"];
            $reply = "Команда не распознана.";
            $this->botReply($reply, $chatID);
        }
    }

    public function recordinFile($text)
    {
        $filename = "sale.txt";
        $f = fopen($filename, "w");
        fwrite($f, $text);
        fclose($f);
    }

    public function getFromFile()
    {
        $filename = "sale.txt";
        $f = fopen($filename, "r");
        $actionText = fgets($f);
        fclose($f);
        return $actionText;
    }

    public function botReply($text, $chatID)
    {
        $sendto = $this->apiUrl . "sendmessage?chat_id=" . $chatID . "&text=" . $text . '&parse_mode=markdown';
        file_get_contents($sendto);
    }

    public function searchAuction($textForSearch, $chatID)
    {
        $auctions = Auction::where('name', 'like', '%' . $textForSearch . '%')
            ->where('status_id', 3)->take(10)->orderBy('id', 'desc')->get();
        $reply = "";
        foreach ($auctions as $auction) {
            $reply = $reply . $auction->id . ". " . $auction->name . "\n";
        }
        if ($reply == "") {
            $reply = "ничего не найдено";
        }
        $this->botReply(urlencode($reply), $chatID);
    }

    public function createAuction($auction, $chatID)
    {
        $auctionParams = explode(' ', $auction);
        $start = false;
        if (isset($auctionParams[3])) {
            if ($auctionParams[3] == 'start') {
                $start = true;
            }
        }
        $auction = Auction::find($auctionParams[0]);
        if ($start && $auction) {
            $reply = 'Создан лот *' . $auction->name . '* стоимостью *' . $auctionParams[1] . ' руб.* таймер на *'
                . $auctionParams[2] . '* секунд.';
            $this->createAuctionCopy($auctionParams, $auction);
        } else {
            $reply = 'Будет создан лот *' . $auction->name . '* стоимостью *' . $auctionParams[1] . ' руб.* таймер на *'
                . $auctionParams[2] . '* секунд. Для запуска напишите /create ' . $auctionParams[0] . ' ' . $auctionParams[1] . ' ' . $auctionParams[2] . ' start';
        }
        $this->botReply(urlencode($reply), $chatID);
    }

    public function createAuctionCopy($auctionParmas, $auction)
    {
        $date = date("Y-m-d H:i:s");
        $price = $auctionParmas[1];
        $interval = $auctionParmas[2];

        $auctionItem = new Auction();
        $auctionItem->name = $auction->name;
        $auctionItem->images = $auction->images;
        $auctionItem->characteristic = $auction->characteristic;
        $auctionItem->description = $auction->description;
        $auctionItem->price = $price;
        $auctionItem->interval_time = $interval;
        $auctionItem->start_time = $auction->start_time;
        $auctionItem->status_id = 1;
        $auctionItem->preview_image = $auction->preview_image;
        $auctionItem->category = $auction->category;
        $auctionItem->time_to_start = $date;
        $auctionItem->start_time = $date;
        $auctionItem->bid = $auction->bid;
        $auctionItem->save();

        $accordions = AuctionToAccordion::where('auction_id', $auction->id)->get();
        foreach ($accordions as $accordion) {
            $accordionCopy = new AuctionToAccordion();
            $accordionCopy->auction_id = $auctionItem->getKey();
            $accordionCopy->accordion_id = $accordion->accordion_id;
            $accordionCopy->save();
        }

        $notification = new Notification();
        $notification->name = 'Cоздание лота ' . $auctionItem->name;
        $notification->item_id = $auctionItem->id;
        $notification->type = 'create from telegram';
        $notification->item_type = 'auction';
        $notification->already_send = 0;
        $notification->save();
    }

    public function getStats()
    {
        $bidStats = BidStats::first();
        $reply = "*Общая статистика:* \n 1. Денег внесено: *" . number_format($bidStats->all_price) .
            " ₽*\n 2. Стоимость ставки(ср): *" . $bidStats->bid_costs . " ₽*\n";

        $reply = $reply . "\n*Продано товаров, по дням:* \n";
        $bidDayStats = BidDayStats::orderBy('id', 'desc')->take(5)->get();
        $count = 1;
        foreach ($bidDayStats as $day) {
            $reply = $reply . "*" . date("d.m", strtotime($day->date)) . "*, " .
                'Поступления: *' . number_format($day->income) . " ₽*\n";
            $count++;
        }

        $reply = $reply . "\n*Продано ставок, по дням:* \n";
        $count = 1;
        foreach ($bidDayStats as $bid) {
            $reply = $reply . "*" . date("d.m", strtotime($bid->date)) . "*, " .
                'Сумма: *' . number_format($bid->bid_income) . " ₽*\n";
            $count++;
        }

        $reply = $reply . "\n*Регистраций, по дням:* \n";
        $count = 1;
        foreach ($bidDayStats as $register) {
            $reply = $reply . "*" . date("d.m", strtotime($register->date)) . "*, " .
                'Количество: *' . number_format($register->register) . "*\n";
            $count++;
        }

        $count = 1;
        $auctionLots = Auction::whereIn('status_id', [1, 2])->get();
        $reply = $reply . "\n*Активные лоты:* \n";
        if (count($auctionLots) == 0) {
            $reply = $reply . "Активных лотов нет";
        }
        foreach ($auctionLots as $auction) {
            $reply = $reply . $count . ". " . $auction->name . ", Цена: *" . number_format($auction->price) . " ₽*\n";
            $count++;
        }

        $activeUsers = ActiveUsers::first();
        $reply = $reply . "\n*Играют пользователей:* \n";
        $reply = $reply .
            "1. За 15 минут: *" . $activeUsers->per_15_min . " * \n" .
            "2. За пол часа: *" . $activeUsers->per_half . " * \n" .
            "3. В час: *" . $activeUsers->per_hour . " * \n" .
            "4. Сегодня: *" . $activeUsers->today . " * \n";

        $reply = $reply . "\n*Действующие автоставки:* \n";
        $countAutobids = 0;
        foreach ($auctionLots as $auction) {
            $autobids = Autobid::where('auction_id', $auction->id)->get();
            if (count($autobids) > 0) {
                $countAutobids++;
                $reply = $reply . $countAutobids . ". Лот: *" . $auction->name . " * ";
                foreach ($autobids as $autobid) {
                    $user = User::find($autobid->user_id);
                    $reply = $reply . "*" . $user->instagram . "*, от: *" . $autobid->last_time_sec . "* до: *" .
                        $autobid->next_time_sec . " сек*, ставок: *" . $user->bid . "* \n";
                }
            }
        }
        if ($countAutobids == 0) {
            $reply = $reply . "Нет действующих автоставок\n";
        }
        return urlencode($reply);
    }

    public function getStatsMonth()
    {
        $reply = "\n*Продано лотов, по месяцам:* \n";
        for ($i = 0; $i < 12; $i++) {
            $bidMonthStats = BidDayStats::orderBy('id', 'desc');
            if ($i == 0) {
                $month = Carbon::today()->monthName;
                $bidMonthStats->whereDate('date', '>=', Carbon::today()->firstOfMonth()->toDateString());
            } else {
                $month = Carbon::now()->subMonth($i)->monthName;
                $bidMonthStats->whereMonth('date', Carbon::now()->subMonth($i)->format('m'));
            }
            $reply = $reply . '*' . $month . "*. " .
                'Поступления: *' . number_format($bidMonthStats->sum('income')) . " ₽*\n";
        }

        $reply = $reply . "\n*Продано ставок, по месяцам:* \n";
        for ($i = 0; $i < 12; $i++) {
            $bidMonthStats = BidDayStats::orderBy('id', 'desc');
            if ($i == 0) {
                $month = Carbon::today()->monthName;
                $bidMonthStats->whereDate('date', '>=', Carbon::today()->firstOfMonth()->toDateString());
            } else {
                $month = Carbon::now()->subMonth($i)->monthName;
                $bidMonthStats->whereMonth('date', Carbon::now()->subMonth($i)->format('m'));
            }
            $reply = $reply . '*' . $month . "*. " .
                'Сумма: *' . number_format($bidMonthStats->sum('bid_income')) . " ₽*\n";
        }

        $reply = $reply . "\n*Регистраций, по месяцам:* \n";
        for ($i = 0; $i < 12; $i++) {
            $bidMonthStats = BidDayStats::orderBy('id', 'desc');
            if ($i == 0) {
                $month = Carbon::today()->monthName;
                $bidMonthStats->whereDate('date', '>=', Carbon::today()->firstOfMonth()->toDateString());
            } else {
                $month = Carbon::now()->subMonth($i)->monthName;
                $bidMonthStats->whereMonth('date', Carbon::now()->subMonth($i)->format('m'));
            }
            $reply = $reply . '*' . $month . "*. " .
                'Количество: *' . number_format($bidMonthStats->sum('register')) . "*\n";
        }

        return urlencode($reply);
    }

    public function getNotDelivered($numbers)
    {
        $numbers = $numbers ? $numbers : 10;
        if ($numbers > 15) $numbers = 15;
        $notifications = Notification
            ::where('type', 'winner')
            ->where('item_type', 'auction')
            ->orderBy('updated_at', 'desc')->take($numbers * 100)->get();
        $reply = "* Неотправленные лоты (последние " . $numbers . "): *\n";
        $count = 1;
        foreach ($notifications as $notification) {
            if ($notification->item_id) {
                $auction = Auction::where('isDelivered', 0)
                    ->where('payed', 1)
                    ->where('id', $notification->item_id)->first();
                if ($auction) {
//                    $countReply = strlen($reply);
//                    if($countReply >= 7125) {
//                      break;
//                    }
                    if (strpos($auction->name, 'Пакет') === false) {
                        $reply = $reply . "*" . $count . ". " . $auction->name . "*\n";
                        $reply = $reply . "Номер лота: " . AuctionHelper::getAuctionNumber($auction->id) . "\n";
                        $reply = $reply . "Дата оплаты: " . $notification->updated_at . "\n";
                        $reply = $reply . "Сумма: " . number_format($auction->price) . " ₽\n";
                        $user = User::find($auction->leader_id);
                        $reply = $reply . "Победитель: *" . $user->instagram . "*\n";
                        if ($user->delivery_post_index) {
                            $reply = $reply . "ФИО: " . $user->delivery_name . ", Индекс: " . $user->delivery_post_index . ", Город: " .
                                $user->delivery_city . ", Улица: " . $user->delivery_street .
                                ", Дом: " . $user->delivery_house . ", Квартира: "
                                . $user->delivery_apartment . ", Телефон: " . $user->delivery_phone . "\n";
                        } else {
                            $reply = $reply . "*Адрес не указан*\n";
                        }
                        $reply = $reply . "Пометить как отправленный: /sent" . $auction->id . "\n\n";
                        $count++;
                    }
                }
            }

            if ($count > $numbers) {
                break;
            }
        }

        return urlencode($reply);
    }

    public function sentAuction($id)
    {
        $auction = Auction::find($id);
        $reply = "Лот не найден";
        if ($auction) {
            $auction->isDelivered = 1;
            $auction->timestamps = false;
            $auction->save();
            $reply = "Лот *" . AuctionHelper::getAuctionNumber($auction->id) . "* " . $auction->name .
                " помечен как отправленный.";
        }
        return urlencode($reply);
    }

    public function commandsDeliveryAdmin($command, $update)
    {
        $chatID = $update["message"]["chat"]["id"];
        if ($command == "/help") {
            $reply = urlencode("*Доступные команды:*
1. /help - помощь
2. /start - начать работу
3. /delivery - получить неотправленные лоты, можно указать количество как /delivery 30
4. /sent - пометить лот как отправленный, пример  /sent1931
            ");
            $this->botReply($reply, $chatID);
        } elseif (preg_match('/(?=sent)/', $command) == "1") {
            $id = substr($command, 5);
            $reply = $this->sentAuction($id);
            $this->botReply($reply, $chatID);
        } elseif (preg_match('/(?=delivery)/', $command) == "1") {
            $numbers = substr($command, 10);
            $reply = $this->getNotDelivered($numbers);
            $this->botReply($reply, $chatID);
        } elseif (preg_match('/(?=dItem)/', $command) == "1") { //deliveryItem
            $id = substr($command, 5);
            $reply = $this->getNotDeliveredItem($id);
            $this->botReply($reply, $chatID);
        } else {
            $first_name = $update["message"]["from"]["first_name"];
            $reply = "Команда не распознана.";
            $this->botReply($reply, $chatID);
        }
    }

    public function getNotDeliveredItem($id)
    {
        $notification = Notification
            ::where('type', 'pay')
            ->where('item_type', 'auction')
            ->where('id', $id)->first();
        $reply = "---\n";
        if ($notification) {
            if ($notification->item_id) {
                $auction = Auction::where('isDelivered', 0)
                    ->where('payed', 1)
                    ->where('id', $notification->item_id)->first();
                if ($auction) {
                    if (strpos($auction->name, 'Пакет') === false) {
                        $reply = $reply . "*" . $auction->name . "*\n";
                        $reply = $reply . "Номер лота: " . AuctionHelper::getAuctionNumber($auction->id) . "\n";
                        $reply = $reply . "Дата оплаты: " . $notification->updated_at . "\n";
                        $reply = $reply . "Сумма: " . number_format($auction->price) . " ₽\n";
                        $user = User::find($auction->leader_id);
                        $reply = $reply . "Победитель: *" . $user->instagram . "*\n";
                        if ($user->delivery_post_index) {
                            $reply = $reply . "ФИО: " . $user->delivery_name . ", Индекс: " . $user->delivery_post_index . ", Город: " .
                                $user->delivery_city . ", Улица: " . $user->delivery_street .
                                ", Дом: " . $user->delivery_house . ", Квартира: "
                                . $user->delivery_apartment . ", Телефон: " . $user->delivery_phone . "\n";
                        } else {
                            $reply = $reply . "*Адрес не указан*\n";
                        }
                        $smsNotSentText = "*ТЕЛЕФОН НЕ УКАЗАН ИЛИ СМС НЕ ОТПРАВЛЕНА*\n";
                        if ($user->delivery_phone) {
                            $phone = TextHelper::phoneFormat($user->delivery_phone);
                            if (!$phone) {
                                $reply = $reply . $smsNotSentText;
                            }
                        } else {
                            $reply = $reply . $smsNotSentText;
                        }

                        $reply = $reply . "Пометить как отправленный: /sent" . $auction->id . "\n\n";
                    }
                }
            }
        }
        return urlencode($reply);
    }

    public function getGuard()
    {
        $reply = "*Защита:*\n";
        $auctionLots = Auction::whereIn('status_id', [1, 2])->get();
        $countAutobids = 0;
//        foreach ($auctionLots as $auction) {
//            $autobids = ProGuard::where('auction_id', $auction->id)->where('guard', true)->get();
//            if(count($autobids) > 0) {
//                $countAutobids++;
//                $reply = $reply . $countAutobids .". Лот: *" . $auction->name . " * ";
//                foreach ($autobids as $autobid) {
//                    foreach ($autobid->users as $user) {
//                        $user = User::find($autobid->user_id);
//                        $reply = $reply . "*" . $user->instagram . "*, от: *" . $autobid->from . "* до: *" .
//                            $autobid->to . " сек* \n";
//                    }
//                }
//            }
//        }
        if ($countAutobids == 0) {
            $reply = $reply . "Нет действующей защиты\n";
        }

        return urlencode($reply);
    }

    public function getRef()
    {
        $refCounts = RefCount::get();
        $result = [];
        $resultSum = [];
        foreach ($refCounts as $refCount) {
            $result[$refCount->user_id] = isset($result[$refCount->user_id]) ? $result[$refCount->user_id] + 1 : 1;
            if ($refCount->first_sum) {
                $resultSum[$refCount->user_id] =
                    isset($resultSum[$refCount->user_id]) ? $resultSum[$refCount->user_id] + $refCount->first_sum : $refCount->first_sum;
            }
        }
        $referrals = [];
        $referralsSum = [];
        if (!empty($result)) {
            foreach ($result as $elementKey => $elementValue) {
                $user = User::where('id', $elementKey)->first();
                if ($user) {
                    $referrals[$user->instagram] = $elementValue;
                }
            }
        }

        if (!empty($resultSum)) {
            foreach ($resultSum as $elementKey => $elementValue) {
                $user = User::where('id', $elementKey)->first();
                if ($user) {
                    $referralsSum[$user->instagram] = $elementValue;
                }
            }
        }
        uasort($referralsSum, function ($a, $b) {
            return $a < $b;
        });

        $count = 0;
        $reply = "*Первых 10 пользователей:*\n";
        foreach ($referralsSum as $referralKey => $referralValue) {
            $count++;
            if ($count > 10) {
                break;
            }
            $reply = $reply . $count . ". " . $referralKey . ", сумма: " . $referralValue . " ₽, количество: " . $referrals[$referralKey] . "\n";

        }
        return urlencode($reply);
    }
}
