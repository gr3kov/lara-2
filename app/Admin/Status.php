<?php

use App\Models\Status;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Status::class, function (ModelConfiguration $model) {
    $model->setTitle('Статус');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('code')->setLabel('Код'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->paginate(15);
        return $display;
    });
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('name', 'Наименование')->required(),
            AdminFormElement::text('code', 'Код')->required()->unique()
        );
    });
});
