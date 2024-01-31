<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\UsersToUrl::class, function (ModelConfiguration $model) {
    $model->setTitle('Статистика по куки');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('url')->setLabel('Ссылка'),
            AdminColumn::text('host')->setLabel('Хост'),
            AdminColumn::text('user_id')->setLabel('Пользователь'),
            AdminColumn::text('target')->setLabel('Таргет'),
            AdminColumn::text('source')->setLabel('Источник'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y H:i'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y H:i')
        ]);
        $display->paginate(15);
        $display->setOrder([[0, 'desc']]);
        return $display;
    });
});
