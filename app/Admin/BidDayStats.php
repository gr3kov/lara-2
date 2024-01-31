<?php

use App\Models\BidDayStats;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(BidDayStats::class, function (ModelConfiguration $model) {
    $model->setTitle('Доход Расход (дни)');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('date')->setLabel('Дата'),
            AdminColumn::text('income')->setLabel('Доход (без комиссии <br> и оплаты товара)'),
            AdminColumn::text('bid_income')->setLabel('Куплено ставок'),
            AdminColumn::text('register')->setLabel('Зарегистрировались'),
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });
});
