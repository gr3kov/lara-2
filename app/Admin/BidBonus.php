<?php

use App\Models\BidBonus;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(BidBonus::class, function (ModelConfiguration $model) {
    $model->setTitle('Ставки бонус (лог)');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('user_id')->setLabel('Пользователь'),
            AdminColumn::text('bid_count')->setLabel('Количество'),
            AdminColumn::text('code')->setLabel('Код'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y H:i'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y H:i')
        ]);
        $display->paginate(15);
        $display->setOrder([[0, 'desc']]);
        return $display;
    });
});
