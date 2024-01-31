<?php

use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\AuctionPayed::class, function (ModelConfiguration $model) {
    $model->setTitle('Оплаченные лоты');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->setDisplaySearch(true);
        $display->setFilters(AdminDisplayFilter::field('payed')->setValue(1)->setTitle('Оплачены'));
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('price')->setLabel('Стоимость'),
            AdminColumn::text('leader_id')->setLabel('Кто оплатил'),
            AdminColumn::custom()->setLabel('Инстаграм')->setCallback(function ($instance) {
                $user = User::where('id', $instance->leader_id)->first();
                return $user["instagram"];
            }),
            AdminColumn::image('preview_image')->setLabel('Превью'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });
    $model->disableDeleting();
});
