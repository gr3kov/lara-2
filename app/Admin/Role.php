<?php

use App\Models\Role;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Role::class, function (ModelConfiguration $model) {
    $model->setTitle('Роли');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::text('id')->setLabel('id'),
            AdminColumn::text('name')->setLabel('Наименование'),
            AdminColumn::text('description')->setLabel('Описание'),
            AdminColumn::datetime('created_at', 'Создан')->setFormat('d.m.Y'),
            AdminColumn::datetime('updated_at', 'Обновлён')->setFormat('d.m.Y')
        ]);
        $display->paginate(15);
        return $display;
    });
    $model->disableDeleting();

    $model->onCreate(function () {
        $form = AdminForm::panel()->addBody(
            AdminFormElement::text('name', 'Имя')->required(),
            AdminFormElement::text('description', 'Описание')->required()
        );
        return $form;
    });
    $model->onEdit(function ($instance) {
        $form = AdminForm::panel()->addBody(
            AdminFormElement::text('name', 'Имя')->required(),
            AdminFormElement::text('description', 'Описание')->required()
        );
        $users = User::where('role_id', '=', $instance)->get();
        if (!$users->isEmpty()) {
            $tableHeader = '<b>Пользователи с этой ролью</b> <br><br>
			<div class="panel panel-default">
			<table class="table table-striped"><colgroup>
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
			</colgroup>
			<thead>
			<tr>
				<th class="row-header">
			Имя
				</th>
				<th class="row-header">
			Email
				</th>
			</tr>
			</thead>
			<tbody>';
            $tableFooter = '
			</tbody>
				<tfoot>
				<tr>
				</tr>
				</tfoot>
			</table>
			</div>';
            $tableBody = '';


            foreach ($users as $element) {
                $tableBody = $tableBody . '<tr><td class="row-text">' . $element->name . '</td>
				<td class="row-text">' . $element->email . '</td></tr>';
            }
            $form->addBody($tableHeader . $tableBody . $tableFooter);
        }
        return $form;
    });
});
