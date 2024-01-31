<?php

use App\Models\Role;
use App\Models\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    $model->setTitle('Пользователи');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        $display->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('firstname')->setLabel('Имя'),
//			AdminColumn::custom()->setLabel('Тип пользователя')->setCallback(function ($instance) {
//				$role = Role::where('id', $instance->role_id)->first();
//				return $role["name"];        }),
            AdminColumn::image('photo')->setLabel('photo'),
            AdminColumn::email('email')->setLabel('Email'),
            AdminColumn::text('reg_ip')->setLabel('ip'),
            AdminColumn::text('is_ban')->setLabel('Заблокирован'),
            AdminColumn::text('active')->setLabel('Активный'),
            AdminColumn::text('bid')->setLabel('Ставки'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
//			AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->setOrder([[0, 'desc']]);
        $display->paginate(15);
        return $display;
    });
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('firstname', 'Имя')->required(),
            AdminFormElement::text('email', 'Email')->required()->unique()->addValidationRule('email'),
            AdminFormElement::select('role_id', 'Роль')->setModelForOptions(new \App\Models\Role())->setDisplay('name')->setDefaultValue('2'),
            AdminFormElement::password('password', 'Пароль')->hashWithBcrypt(),
            AdminFormElement::number('bid', 'Количество ставок'),
            AdminFormElement::checkbox('is_ban', 'Заблокирован'),
            AdminFormElement::text('instagram', 'Инстаграм'),
            AdminFormElement::text('delivery_name', 'Адрес доставки'),
            AdminFormElement::text('delivery_post_index', 'Индекс доставки'),
            AdminFormElement::text('delivery_city', 'Город'),
            AdminFormElement::text('delivery_street', 'Улица'),
            AdminFormElement::text('delivery_house', 'Дом'),
            AdminFormElement::text('delivery_apartment', 'Квартира'),
            AdminFormElement::text('delivery_phone', 'Телефон доставки'),
            AdminFormElement::text('delivery_email', 'Email доставки'),
            AdminFormElement::checkbox('confirmed', 'Активирован')
        );
    });
});
