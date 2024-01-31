<?php

use App\Models\UserBidAdd;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(UserBidAdd::class, function (ModelConfiguration $model) {
    $model->setTitle('Добавить ставки');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('user_id')->setLabel('Пользователь'),
            AdminColumn::text('bid')->setLabel('Ставки'),
            AdminColumn::text('success')->setLabel('Добавлено'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);

        return $display;
    });
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::select('user_id', 'Пользователь')->setModelForOptions(new \App\User())->setDisplay('name'),
            AdminFormElement::text('bid', 'Ставки к добавлению')->required(),
            AdminFormElement::text('price', 'Стоимость'),
            AdminFormElement::select('shop_id', 'Пакет ставок')->setModelForOptions(new \App\Models\Shop())->setDisplay('name')
        );
    });
});
