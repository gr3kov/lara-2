<?php

use App\Models\FeedBack;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(FeedBack::class, function (ModelConfiguration $model) {
    $model->setTitle('Отзывы');
    $model->enableAccessCheck();

    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display
            ->setColumns([
                AdminColumn::text('id')->setLabel('id'),
                AdminColumn::custom()->setLabel('Пользователь')->setCallback(function ($instance) {
                    $user = User::where('id', '=', $instance->user_id)->first();
                    return $user["name"];
                }),
                AdminColumn::text('request')->setLabel('Отзыв'),
                AdminColumn::text('response')->setLabel('Ответ администратора'),
                AdminColumn::text('active')->setLabel('Видимость отзыва'),
                AdminColumn::datetime('response_date', 'Дата ответа')->setFormat('d.m.Y'),
                AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
                AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
            ]);

        $display->paginate(15);
        return $display;
    });
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::select('user_id', 'Пользователь')->required()->setModelForOptions(new \App\User())->setDisplay('name'),
            AdminFormElement::text('request', 'Отзыв')->required(),
            AdminFormElement::text('response', 'Ответ'),
            AdminFormElement::select('active', 'Видимость отзыва')->setOptions(['no' => 'нет', 'yes' => 'да'])->required(),
            AdminFormElement::datetime('created_at', 'Создан'),
            AdminFormElement::datetime('updated_at', 'Обновлён'),
            AdminFormElement::datetime('response_date', 'Дата ответа')
        );
        return $form;
    });
});
