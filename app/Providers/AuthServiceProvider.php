<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Models\ActiveUsers::class => \App\Policies\ActiveUsersPolicy::class,
        \App\Models\AuctionAccordion::class => \App\Policies\AuctionAccordionPolicy::class,
        \App\Models\AuctionEdit::class => \App\Policies\AuctionEditPolicy::class,
        \App\Models\AuctionPayed::class => \App\Policies\AuctionPayedPolicy::class,
        \App\Models\Auction::class => \App\Policies\AuctionPolicy::class,
        \App\Models\Autobid::class => \App\Policies\AutobidPolicy::class,
        \App\Models\BidStats::class => \App\Policies\BidStatsPolicy::class,
        \App\Models\BidBonus::class => \App\Policies\BidBonusPolicy::class,
        \App\Models\BidDayStats::class => \App\Policies\BidDayStatsPolicy::class,
        \App\Models\Bid::class => \App\Policies\BidPolicy::class,
        \App\Models\CookieToUrl::class => \App\Policies\CookieToUrlPolicy::class,
        \App\Models\Costs::class => \App\Policies\CostsPolicy::class,
        \App\Models\Docs::class => \App\Policies\DocsPolicy::class,
        \App\Models\Notification::class => \App\Policies\NotificationPolicy::class,
        \App\Models\Operations::class => \App\Policies\OperationsPolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\Shop::class => \App\Policies\ShopPolicy::class,
        \App\Models\SiteConfig::class => \App\Policies\SiteConfigPolicy::class,
        \App\Models\Status::class => \App\Policies\StatusPolicy::class,
        \App\Models\TargetRegister::class => \App\Policies\TargetRegisterPolicy::class,
        \App\Models\UserBidAdd::class => \App\Policies\UserBidAddPolicy::class,
        \App\Models\UserBidStats::class => \App\Policies\UserBidStatsPolicy::class,
        \App\Models\UserStats::class => \App\Policies\UserStatsPolicy::class,
        \App\Models\UsersToUrl::class => \App\Policies\UsersToUrlPolicy::class,
        \App\Models\PayOrder::class => \App\Policies\PayOrderPolicy::class,
        \App\Models\NotificationsNews::class => \App\Policies\NotificationsNewsPolicy::class,
        \App\Models\RefCount::class => \App\Policies\RefCountPolicy::class,
        \App\Models\ProGuard::class => \App\Policies\ProGuardPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
