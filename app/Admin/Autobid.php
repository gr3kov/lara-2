<?php

use App\Models\Auction;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\Autobid::class, function (ModelConfiguration $model) {
    $model->setTitle('Автоставки');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables();
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('user_id')->setLabel('User id'),
            AdminColumn::text('last_time_sec')->setLabel('От'),
            AdminColumn::text('next_time_sec')->setLabel('До'),
            AdminColumn::text('date_time_start')->setLabel('Дата время старта'),
            AdminColumn::text('date_time_stop')->setLabel('Дата время остановки'),
            AdminColumn::text('active')->setLabel('Активно'),
            AdminColumn::text('auction_id')->setLabel('Лот аукциона id'),
            AdminColumn::custom()->setLabel('Лот аукциона')->setCallback(function ($instance) {
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
            AdminFormElement::number('last_time_sec', 'От')->required()->setMin(3),
            AdminFormElement::number('next_time_sec', 'До')->required()->setMin(4),
            AdminFormElement::datetime('date_time_start', 'Дата время старта')->required(),
            AdminFormElement::datetime('date_time_stop', 'Дата время остановки')->required(),
            AdminFormElement::select('user_id', 'Пользователь')->setModelForOptions(new User())->setDisplay('name'),
            AdminFormElement::select('auction_id', 'Лот аукциона')->setModelForOptions(new Auction())->setDisplay('id'),
            AdminFormElement::checkbox('active', 'Активно')->setLabel('Активно')
        );
        return $form;
    });
});
