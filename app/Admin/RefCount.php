<?php

use App\Models\RefCount;
use SleepingOwl\Admin\Model\ModelConfiguration;
use App\User;

AdminSection::registerModel(RefCount::class, function (ModelConfiguration $model) {
    $model->setTitle('Подсчёт рефералов');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::custom()->setLabel('Пользователь')->setCallback(function ($instance) {
                $user = User::where('id', $instance->user_id)->first();
                return $user->email . ' : ' . $user->instagram;
            }),
            AdminColumn::custom()->setLabel('Реферал')->setCallback(function ($instance) {
                $user = User::where('id', $instance->user_id_ref)->first();
                return $user->email . ' : ' . $user->instagram;
            }),
            AdminColumn::text('first_sum')->setLabel('Первая сумма'),
            AdminColumn::text('pay_at')->setLabel('Дата платежа'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
        ]);
        $display->setOrder([[1, 'desc']]);
        $display->paginate(15);
        return $display;
    });
});
