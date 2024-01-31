<?php

use App\Models\PayOrder;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(PayOrder::class, function (ModelConfiguration $model) {
    $model->setTitle('Операции');
    $model->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('order')->setLabel('Номер заказа'),
            AdminColumn::text('user_id')->setLabel('Пользователь'),
            AdminColumn::text('price')->setLabel('Цена'),
            AdminColumn::text('auction_id')->setLabel('Лот'),
            AdminColumn::text('shop_id')->setLabel('Ставки (id)'),
            AdminColumn::text('status')->setLabel('Статус'),
            AdminColumn::text('success')->setLabel('Успешно'),
            AdminColumn::text('description')->setLabel('Описание'),
            AdminColumn::text('created_at')->setLabel('Дата'),
        ]);
        $display->paginate(15);
        $display->setOrder([[0, 'desc']]);
        return $display;
    });
    $model->disableDeleting();
});
