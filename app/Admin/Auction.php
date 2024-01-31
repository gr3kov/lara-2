<?php

use App\Models\AuctionAccordion;
use App\Models\AuctionCategory;
use App\Models\Status;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\Auction::class, function (ModelConfiguration $model) {
    $model->setTitle('Лоты');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->with(['status']);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('price')->setLabel('Начальная цена'),
            AdminColumn::image('preview_image')->setLabel('Превью'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('start_time', 'Начат аукцион')->setFormat('d.m.Y H:i:s')
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });

    $model->onCreateAndEdit(function () {

        $auctionCategory = [];
        foreach (AuctionCategory::all() as $auctionCategoryItem) {
            $auctionCategory[$auctionCategoryItem->slug] = $auctionCategoryItem->title;
        }

        $form = AdminForm::panel();
        $form->setHtmlAttribute('enctype', 'multipart/form-data');
        $form->addBody(
            AdminFormElement::text('name', 'Наименование')->required(),
            AdminFormElement::number('price', 'Начальная цена')->required(),
            AdminFormElement::number('deposit', 'Депозит')->required(),
            AdminFormElement::number('bet_size', 'Размер ставки')->required(),
            AdminFormElement::number('all_slots', 'Свободные места')->required(),
            AdminFormElement::text('interval_time', 'Интервал времени для ставки')->required(),
            AdminFormElement::datetime('time_to_start', 'Время когда стартует акцион'),
            AdminFormElement::datetime('start_time', 'Когда был начат аукцион')->required(),
            AdminFormElement::wysiwyg('characteristic', 'Характеристики')->required(),
            AdminFormElement::wysiwyg('description', 'Описание')->required(),
            //AdminFormElement::datetime('time_last_interval', 'Время НЕ ТРОГАТЬ (текущее)'),
            //AdminFormElement::datetime('time_last', 'Время НЕ ТРОГАТЬ (завершающее)'),

            AdminFormElement::select('status_id', 'Статус')->required()->setModelForOptions(new Status())->setDisplay('name'),
            AdminFormElement::images('images', 'Фото')->addValidationRule('mimes:jpeg,jpg,png,webp'),
            AdminFormElement::image('preview_image', 'Превью')->addValidationRule('mimes:jpeg,jpg,png,webp'),
            AdminFormElement::select('category', 'Категория')->setOptions($auctionCategory)->required(),
            AdminFormElement::number('bid', 'Ставки к начислению (только для пакета ставок)'),
            AdminFormElement::multiselect('accordions', 'Описание (аккордионы)', AuctionAccordion::class)->setDisplay('code')
//            AdminFormElement::datetime('updated_at', 'Время обновления')
        );
        return $form;
    });
});
