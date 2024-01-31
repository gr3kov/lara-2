<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\Shop::class, function (ModelConfiguration $model) {
    $model->setTitle('Ставки (магазин)');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables();
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('price')->setLabel('Стоиомость'),
            AdminColumn::text('count')->setLabel('Количество'),
            AdminColumn::image('image')->setLabel('Изображение'),
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
            AdminFormElement::text('name', 'Наименование')->required(),
            AdminFormElement::number('price', 'Начальная цена')->required(),
            AdminFormElement::number('old_price', 'Старая цена'),
            AdminFormElement::number('sale_percent', 'Проценты, скидка (как текст)'),
            AdminFormElement::number('count', 'Количество')->required(),
            AdminFormElement::image('image', 'Изображение')->addValidationRule('mimes:jpeg,jpg,png')
        );
        return $form;
    });
});
