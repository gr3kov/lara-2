<?php

use App\Models\InstagramServer;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(InstagramServer::class, function (ModelConfiguration $model) {
    $model->setTitle('Серверы для Инстаграм');
    $model->enableAccessCheck();

    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display
            ->setColumns([
                AdminColumn::text('id')->setLabel('id'),
                AdminColumn::text('ip')->setLabel('IP'),
                AdminColumn::text('interval')->setLabel('Интервал сек'),
                AdminColumn::text('request_count')->setLabel('Количество запросов сделано'),
                AdminColumn::text('request_time_wait')->setLabel('Время ожидания дней'),
                AdminColumn::text('last_request_date')->setLabel('Последний запрос'),
                AdminColumn::text('off')->setLabel('off'),
                AdminColumn::text('message')->setLabel('message'),

            ]);
        $display->paginate(15);
        return $display;
    });

    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('ip', 'IP')->required(),
            AdminFormElement::number('interval', 'Интервал сек')->required(),
            AdminFormElement::number('request_time_wait', 'Время ожидания дней')->required(),
            AdminFormElement::datetime('last_request_date', 'Последний запрос'),
            AdminFormElement::checkbox('off', 'off')
        );
    });
});
