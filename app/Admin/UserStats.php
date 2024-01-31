<?php

use App\Models\UserStats;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(UserStats::class, function (ModelConfiguration $model) {
    $model->setTitle('Всего пользователей');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('all')->setLabel('Всего'),
            AdminColumn::text('active')->setLabel('Активных'),
            AdminColumn::custom()->setLabel('Активных %')->setCallback(function ($instance) {
                $activePercent = ($instance->active / $instance->all) * 100;
                return $activePercent . '%';
            }),
            AdminColumn::text('have_insta')->setLabel('Проверено'),
            AdminColumn::custom()->setLabel('Проверено %')->setCallback(function ($instance) {
                $haveInstaPercent = ($instance->have_insta / $instance->all) * 100;
                return $haveInstaPercent . '%';
            }),
        ]);
        $display->paginate(15);
        return $display;
    });
});
