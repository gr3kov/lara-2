<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Age18;
use App\Http\Middleware\SystemStats;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AgeController;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ActivateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::middleware([SystemStats::class, Age18::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'indexRedirect']);

    Route::get('/land', [LandingController::class, 'index'])->name('landing');

    Route::get('/auction', [PageController::class, 'auction'])->name('auction');
    Route::get('/item/{id}', [AuctionController::class, 'item'])->name('item');
    Route::get('/getAuctionLots', [AuctionController::class, 'getAuctionLots'])->name('getAuctionLots');
    Route::get('/getAuctionBidsTable/{id}', [AuctionController::class, 'getAuctionBidsTable'])->name('getAuctionBidsTable');
    Route::get('/getAuctionItem/{id}', [AuctionController::class, 'getAuctionItem'])->name('getAuctionItem');
    Route::get('/category/{slug?}', [AuctionController::class, 'category'])->name('category');
    Route::get('/winners', [PageController::class, 'winners'])->name('winners');
    Route::get('/user-info/{id}', [PageController::class, 'userInfo'])->name('userInfo');
    Route::get('/my-auction', [AuctionController::class, 'myAuction'])->name('myAuction');

    Route::get('/startAuction/{id}', [BidController::class, 'startAuction'])->name('startAuction');
    Route::get('/bid/{id}', [BidController::class, 'bid'])->name('bid');

    Route::get('/notifications', [NotificationController::class, 'notifications'])->name('notifications');
    Route::get('/getNotification', [NotificationController::class, 'getNotification'])->name('getNotification');
    Route::get('/readNotification', [NotificationController::class, 'readNotification'])->name('readNotification');
    Route::get('/notificationToggle', [NotificationController::class, 'notificationToggle'])->name('notification-toggle');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::match(['get', 'post'], '/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::get('/get/email-verify-code', [ProfileController::class, 'sendVerifyEmail'])->name('sendVerifyEmail');
    Route::get('/referral', [ProfileController::class, 'referral'])->name('referral');
    Route::get('/password/change', [ProfileController::class, 'passwordChange'])->name('password-change');
    Route::post('/avatar/change', [ProfileController::class, 'avatarChange'])->name('avatarChange');
    Route::get('/avatar/delete', [ProfileController::class, 'avatarDelete'])->name('avatarDelete');
    Route::get('/add/favorite/{id}', [ProfileController::class, 'addToFavorite'])->name('add-favorite');

    Route::get('/delivery', [PageController::class, 'delivery'])->name('delivery');
    Route::get('/offer', [PageController::class, 'offer'])->name('offer');
    Route::get('/pay-methods', [PageController::class, 'payMethods'])->name('pay-methods');
    Route::get('/security', [PageController::class, 'security'])->name('security');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
//    Route::get('/partners', [PageController::class, 'partners'])->name('partners');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/how', [PageController::class, 'how'])->name('how');
    Route::get('/change-password/finish', [PageController::class, 'changePasswordFinish'])->name('change-password-finish');
    Route::get('/tactics', [PageController::class, 'tactics'])->name('tactics');
    Route::get('/activate/info', [PageController::class, 'activateInfo'])->name('activate-info');

    Route::get('/payment/{type}/{id}', [PaymentController::class, 'payment'])->name('payment');
    Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment-callback');

    Route::get('logout', [LoginController::class, 'logoutAction']);
    Route::match(['get', 'post'], 'login', [LoginController::class, 'loginAction'])->name('login');
    Route::match(['get', 'post'], 'register', [RegisterController::class, 'registerAction'])->name('register');
    Route::get('/ref/{code}', [ReferralController::class, 'registerReferral'])->name('register-referral');

    Route::get('/activate/{token?}', [ActivateController::class, 'index'])->name('activate');
    Route::get('/yandex/', [MoneyController::class, 'accountAuth']);
    Route::get('/process/', [MoneyController::class, 'redirectFunction']);
    Route::get('/buy/bid/{id}', [MoneyController::class, 'buyBid'])->name('buy-bid');
    Route::get('/buy/auction/{id}', [MoneyController::class, 'buyAuction'])->name('buy-auction');
    Route::get('/pay/ok', [MoneyController::class, 'payOk'])->name('pay-ok');

    Route::get('/news', [NewsController::class, 'list'])->name('news');
    Route::get('/tokens', [TokenController::class, 'list'])->name('tokens');

    Route::get('/get-last-week-earning', [ProfileController::class, 'getLastWeekEarning']);
    Route::get('/get-last-month-earning', [ProfileController::class, 'getLastMonthEarning']);
});

Route::middleware([SystemStats::class])->group(function () {
    Route::get('/email/unsubscribe', [EmailController::class, 'unsubscribe']);
    Route::get('/age/ok', [AgeController::class, 'ageSet']);
    Route::post('/bid/access', [GuardController::class, 'bid']);
    Route::get('/age/exit', [AgeController::class, 'ageExit']);
    Route::get('/age', [AgeController::class, 'checkAgePage']);
    Route::get('/agreement', [PageController::class, 'agreement'])->name('agreement');
    Route::any('/telegram/send', [TelegramController::class, 'index'])->name('telegram-send');
    Route::any('/telegram/send/delivery', [TelegramController::class, 'delivery'])->name('telegram-delivery-send');
    Route::any('/sms/send/', [SmsController::class, 'send'])->name('sms-send');
});
