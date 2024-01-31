<?php

use App\Models\ActiveUsers;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(ActiveUsers::class, function (ModelConfiguration $model) {
    $model->setTitle('Игают сегодня');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('per_15_min')->setLabel('За 15 минут'),
            AdminColumn::text('per_half')->setLabel('За пол часа'),
            AdminColumn::text('per_hour')->setLabel('В час'),
            AdminColumn::text('today')->setLabel('Сегодня (начиная с 00:00 по UTC)'),
        ]);
        $display->paginate(15);
        return $display;
    });
});
