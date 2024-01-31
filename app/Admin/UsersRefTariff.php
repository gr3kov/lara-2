<?php

use App\Models\RefTariff;
use App\Models\UsersRefTariff;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(UsersRefTariff::class, function (ModelConfiguration $model) {
    $model->setTitle('Реф тарифы юзеров');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::custom()->setLabel('Пользователь')->setCallback(function ($instance) {
                $user = User::where('id', '=', $instance->user_id)->first();
                return $user["name"];
            }),
            AdminColumn::custom()->setLabel('Реф тариф')->setCallback(function ($instance) {
                $ref = RefTariff::where('id', '=', $instance->ref_tariff_id)->first();
                return $ref["name"];
            }),
            AdminColumn::text('sum')->setLabel('Сумма баланса'),
            AdminColumn::text('active_ref')->setLabel('активных рефералов'),
            AdminColumn::text('active_ref_first_level')->setLabel('активных рефералов первый уровень'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->paginate(15);
        return $display;
    });
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::select('user_id', 'Пользователь')->required()->setModelForOptions(new \App\User())->setDisplay('name'),
            AdminFormElement::select('ref_tariff_id', 'Реф тариф')->required()->setModelForOptions(new \App\Models\RefTariff())->setDisplay('name'),
            AdminFormElement::number('sum', 'Сумма баланса')->required(),
            AdminFormElement::number('active_ref', 'активных рефералов')->required(),
            AdminFormElement::number('active_ref_first_level', 'активных рефералов первый уровень')->required()

        );
        return $form;
    });
});
