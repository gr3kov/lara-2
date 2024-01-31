<?php

use App\Models\Auction;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\Costs::class, function (ModelConfiguration $model) {
    $model->setTitle('Расходы');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables();
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('price')->setLabel('Стоимость'),
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
            AdminFormElement::text('name', 'Наименование')->required()->unique(),
            AdminFormElement::number('price', 'Начальная цена')->required(),
            AdminFormElement::select('auction_id', 'Лот аукциона')->setModelForOptions(new Auction())->setDisplay('id')
        );
        return $form;
    });
});
