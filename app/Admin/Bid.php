<?php

use App\Models\Status;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\Bid::class, function (ModelConfiguration $model) {
    $model->setTitle('Ставки (лог)');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('auction_id')->setLabel('Лот'),
            AdminColumn::text('user_id')->setLabel('Пользователь'),
            AdminColumn::text('new_price')->setLabel('Новая цена'),
            AdminColumn::text('time_to_left')->setLabel('Осталось'),
            AdminColumn::text('auction_code')->setLabel('Код ставки'),
            AdminColumn::text('bid_spend')->setLabel('Потрачено'),
            AdminColumn::text('new_status_id')->setLabel('Новый статус'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y H:i')
        ]);
        $display->paginate(15);
        $display->setOrder([[0, 'desc']]);
        return $display;
    });
});
