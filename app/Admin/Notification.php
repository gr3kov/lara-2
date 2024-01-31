<?php

use App\Models\Notification;
use App\Models\Role;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Notification::class, function (ModelConfiguration $model) {
    $model->setTitle('Уведомления');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('title')->setLabel('Заголовок'),
            AdminColumn::text('item_id')->setLabel('item_id'),
            AdminColumn::text('user_id')->setLabel('user_id'),
            AdminColumn::text('type')->setLabel('type'),
            AdminColumn::text('item_type')->setLabel('item_type'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y H:i'),
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });
});
