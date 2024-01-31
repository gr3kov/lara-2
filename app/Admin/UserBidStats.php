<?php

use App\Models\UserBidStats;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(UserBidStats::class, function (ModelConfiguration $model) {
    $model->setTitle('Пользователи - ставки');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('user_id')->setLabel('user id'),
            AdminColumn::text('instagram')->setLabel('Instagram'),
            AdminColumn::text('current_bid')->setLabel('Имеется ставок'),
//            AdminColumn::text('buy_bid')->setLabel('Куплено ставок'),
            AdminColumn::text('bid_spent')->setLabel('Потрачено ставок'),
            AdminColumn::text('income')->setLabel('Принёс денег'),
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });
});
