<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\SiteConfig::class, function (ModelConfiguration $model) {
    $model->setTitle('Конфигурация');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables();
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('code')->setLabel('Код'),
            AdminColumn::text('value')->setLabel('Значение'),
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
            AdminFormElement::text('code', 'Код')->required()->unique(),
            AdminFormElement::text('value', 'Значение')->required()
        );
        return $form;
    });
});
