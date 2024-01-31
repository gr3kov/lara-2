<?php

use SleepingOwl\Admin\Model\ModelConfiguration;
use App\Models\Auction;

AdminSection::registerModel(\App\Models\ProGuard::class, function (ModelConfiguration $model) {
    $model->setTitle('Сервер защиты');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables();
        $display->setColumns([
            AdminColumn::text('id')->setLabel('ID'),
            AdminColumn::text('from')->setLabel('От, сек'),
            AdminColumn::text('to')->setLabel('До, сек'),
            AdminColumn::text('guard')->setLabel('Активно'),
            AdminColumn::text('auction_id')->setLabel('Лот аукциона id'),
            AdminColumn::custom()->setLabel('Наименование аукциона')->setCallback(function ($instance) {
                $name = Auction::find($instance->auction_id);
                return $name['name'];
            }),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->paginate(15);
        return $display;
    });

    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setHtmlAttribute('enctype', 'multipart/form-data');
        $form->addBody(
            AdminFormElement::multiselect('users', 'Пользователь', \App\User::class)->setLoadOptionsQueryPreparer(function ($element, $query) {
                return $query
                    ->orderBy('created_at', 'desc');
            })->setDisplay('instagram')->setSortable(false),
            AdminFormElement::select('auction_id', 'Лот аукциона')->setModelForOptions(new Auction())->setDisplay('id'),
            AdminFormElement::number('from', 'От, сек')->setLabel('От')->required(),
            AdminFormElement::number('to', 'До, сек')->setLabel('До')->required(),
            AdminFormElement::checkbox('guard', 'Активно')->setLabel('Активно')
        );
        return $form;
    });
});
