<?php

use App\Models\NotificationsNews;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(NotificationsNews::class, function (ModelConfiguration $model) {
    $model->setTitle('Новости');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('title')->setLabel('Наименование'),
            AdminColumn::text('shown')->setLabel('Показано'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y H:i'),
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });

    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setHtmlAttribute('enctype', 'multipart/form-data');
        $form->addBody(
            AdminFormElement::text('title', 'Заголовок')->required(),
            AdminFormElement::textarea('text', 'Текст')->required(),
            AdminFormElement::image('image', 'Превью')->addValidationRule('mimes:jpeg,jpg,png')
        );
        return $form;
    });
});
