<?php

use App\Models\BidStats;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(BidStats::class, function (ModelConfiguration $model) {
    $model->setTitle('Ставки - деньги');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('all_bids')->setLabel('Ставок всего'),
            AdminColumn::custom()->setLabel('Ставок денежных')->setCallback(function ($instance) {
                $users = User::where('role_id', '<>', 1)->where('active', 1)->get();
                $allBidInSystem = 0;
                foreach ($users as $user) {
                    $allBidInSystem = $allBidInSystem + $user->bid;
                }
                return $allBidInSystem;
            }),
            AdminColumn::text('all_price')->setLabel('Получено денег'),
            AdminColumn::text('bonus_bids')->setLabel('Бонусные ставки, выдано'),
            AdminColumn::text('bid_costs')->setLabel('Стоимость ставки средняя'),
            AdminColumn::text('costs')->setLabel('Расходы'),
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });
});
