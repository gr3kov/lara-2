<?php

use App\Models\RefTariff;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(RefTariff::class, function (ModelConfiguration $model) {
    $model->setTitle('Реф тарифы');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('description')->setLabel('Описание'),
            AdminColumn::text('min_sum')->setLabel('Минимальная сумма'),
            AdminColumn::text('min_active_ref')->setLabel('Мин активных рефералов'),
            AdminColumn::text('min_active_ref_first_level')->setLabel('Мин на первом уровне'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->paginate(15);
        return $display;
    });
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('name', 'Наименование')->required()->unique(),
            AdminFormElement::wysiwyg('description', 'Описание')->required(),
            AdminFormElement::number('rate_commission', 'Реферальная комиссия 1 уровень')->required(),
            AdminFormElement::number('rate_commission_2', 'Реферальная комиссия 2 уровень')->required(),
            AdminFormElement::number('rate_commission_3', 'Реферальная комиссия 3 уровень')->required(),
            AdminFormElement::number('rate_bonus', 'Ежедневный бонус 1 уровень')->required(),
            AdminFormElement::number('rate_bonus_2', 'Ежедневный бонус 2 уровень')->required(),
            AdminFormElement::number('rate_bonus_3', 'Ежедневный бонус 3 уровень')->required(),
            AdminFormElement::number('min_sum', 'Минимальная сумма')->required(),
            AdminFormElement::number('min_active_ref', 'Мин активных рефералов')->required(),
            AdminFormElement::number('min_active_ref_first_level', 'Мин на первом уровне')->required()
        );
        return $form;
    });
});
