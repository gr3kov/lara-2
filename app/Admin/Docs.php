<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\Docs::class, function (ModelConfiguration $model) {
    $model->setTitle('Документы');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables();
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('code')->setLabel('Код'),
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });

    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setHtmlAttribute('enctype', 'multipart/form-data');
        $form->addBody(
            AdminFormElement::text('code', 'Код')->required(),
            AdminFormElement::wysiwyg('description', 'Текст')->required()
        );
        return $form;
    });
});
