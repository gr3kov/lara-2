<?php

use App\Models\AuctionAccordion;
use App\Models\Status;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\AuctionEdit::class, function (ModelConfiguration $model) {
    $model->setTitle('Лоты (изменение текущих)');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables();
        $display->with(['status']);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('price')->setLabel('Начальная цена'),
            AdminColumn::image('preview_image')->setLabel('Превью'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });

    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setHtmlAttribute('enctype', 'multipart/form-data');
        $form->addBody(
            AdminFormElement::text('name', 'Наименование')->required(),
            AdminFormElement::wysiwyg('characteristic', 'Характеристики')->required(),
            AdminFormElement::wysiwyg('description', 'Описание')->required(),
            AdminFormElement::select('status_id', 'Статус')->required()->setModelForOptions(new Status())->setDisplay('name'),
            AdminFormElement::images('images', 'Фото')->addValidationRule('mimes:jpeg,jpg,png'),
            AdminFormElement::image('preview_image', 'Превью')->addValidationRule('mimes:jpeg,jpg,png'),
            AdminFormElement::select('category', 'Категория')->setOptions(['digital' => 'Цифровая техника', 'tour' => 'Туристические путевки', 'bid' => 'Пакеты ставок'])->required(),
            AdminFormElement::number('bid', 'Ставки к начислению (только для пакета ставок)'),
            AdminFormElement::multiselect('accordions', 'Описание (аккордионы)', AuctionAccordion::class)->setDisplay('code'),
            AdminFormElement::datetime('updated_at', 'Время обновления'),
            AdminFormElement::datetime('created_at', 'Дата создания'),
            AdminFormElement::checkbox('restart_flag', 'Перезапущено')
        );
        return $form;
    });
});
