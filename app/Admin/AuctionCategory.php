<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\AuctionCategory::class, function (ModelConfiguration $model) {
    $model->setTitle('Список категорий');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('title')->setLabel('Наименование'),
            AdminColumn::text('code')->setLabel('Код'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->paginate(15);
        $display->setOrder([[0, 'desc']]);
        return $display;
    });

    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setHtmlAttribute('enctype', 'multipart/form-data');
        $form->addBody(
            AdminFormElement::text('title', 'Наименование')->required(),
            AdminFormElement::text('code')->setLabel('Код')->required()->unique(),
            AdminFormElement::wysiwyg('description', 'Описание')->required()
        );
        return $form;
    });
});
