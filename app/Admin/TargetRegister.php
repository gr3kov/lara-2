<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(\App\Models\TargetRegister::class, function (ModelConfiguration $model) {
    $model->setTitle('Трафик по дням');
    $model->enableAccessCheck();
    // Display
    $model->onDisplay(function () {

        if (auth()->user()->isSuperAdmin()) {
            $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(25);
        } else {
            $display = AdminDisplay::datatables()->paginate(25);
            $display->setFilters([
                AdminDisplayFilter::field('target')->setValue(auth()->user()->name)->setTitle(auth()->user()->email),
            ]);
        }

        $display->setColumns([
//            AdminColumn::custom()->setLabel('Чей трафик')->setCallback(function ($instance) {
//                $target = $instance->target;
//                if($instance->target == 1) {
//                    $target = 'Прямая ссылка';
//                }
//                if($instance->target == 2) {
//                    $target = 'Не определен';
//                }
//                if($instance->target == 14232) {
//                    $target = 'Разработчик';
//                }
//                return $target;        }),
            AdminColumn::datetime('date')->setLabel('День')->setFormat('d.m'),
            AdminColumn::text('source')->setLabel('Ссылка')->setHtmlAttribute('style', 'width:500px;overflow:hidden'),
            AdminColumn::text('visitor')->setLabel('Хиты'),
            AdminColumn::text('income')->setLabel('Поступления(сумма)')->setHtmlAttribute('class', 'bg-success text-center'),
            AdminColumn::text('income_count')->setLabel('Количество поступлений'),
            AdminColumn::text('active_visitors')->setLabel('Заплативших юзеров'),
            AdminColumn::custom()->setLabel('% заплативших')->setCallback(function ($instance) {
                if ($instance->visitor > 0 && $instance->visitor > 0) {
                    $percent = ($instance->active_visitors / $instance->visitor) * 100;
                } else {
                    $percent = 0;
                }
                return round($percent, 2) . ' %';
            }),
            AdminColumn::text('register')->setLabel('Зарегистрировалось'),
            AdminColumn::custom()->setLabel('% регистраций')->setCallback(function ($instance) {
                if ($instance->visitor > 0 && $instance->visitor > 0) {
                    $percent = ($instance->register / $instance->visitor) * 100;
                } else {
                    $percent = 0;
                }
                return round($percent, 2) . ' %';
            })->setHtmlAttribute('class', 'bg-success text-center'),
        ]);
        $display->paginate(15);
        $display->setOrder([[0, 'desc']]);
        return $display;
    });
    $model->disableDeleting();
});
