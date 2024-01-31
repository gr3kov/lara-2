<?php

use App\Models\SupportMessage;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(SupportMessage::class, function (ModelConfiguration $model) {
    $model->setTitle('Поддержка пользователей');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display
            ->setColumns([
                AdminColumn::text('id')->setLabel('id'),
                AdminColumn::text('name')->setLabel('Имя'),
                AdminColumn::text('email')->setLabel('Email'),
                AdminColumn::text('request')->setLabel('Запрос'),
                AdminColumn::text('response')->setLabel('Ответ'),
                AdminColumn::text('code')->setLabel('Код'),
                AdminColumn::text('is_send')->setLabel('Отправлен ответ'),
                AdminColumn::text('old_support_id')->setLabel('Предыдущее сообщение'),
                AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
                AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
            ]);
        $display->paginate(15);
        return $display;
    });
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('name', 'Имя')->required(),
            AdminFormElement::text('email', 'Email')->required(),
            AdminFormElement::textarea('request', 'Запрос')->required(),
            AdminFormElement::textarea('response', 'Ответ')->required(),
            AdminFormElement::text('code', 'Код')->required(),
            AdminFormElement::select('is_send', 'Отправлен ответ')->setOptions(['1' => 'да', '0' => 'нет'])->required()
        );
        return $form;
    });
});
