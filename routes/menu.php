<?php

use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Html;

Menu::macro('main', function () {
    return Menu::mainMenu()
        ->addIfCan(['admin@show'], Html::mainMenuItem('/admin', 'Dashboard', ['icon' => 'fas fa-tachometer-alt']))
        ->add(Html::mainMenuEmptyItem('Настройки'))
        ->customSubmenu(
            'Пользователи',
            Menu::tree()
            ->add(Html::mainMenuItem('/admin/settings/users', 'Пользователи', ['icon' => 'fas fa-user']))
            ->add(Html::mainMenuItem('/admin/settings/roles', 'Группы', ['icon' => 'fas fa-users']))
            ->add(Html::mainMenuItem('/admin/settings/permissions', 'Доступы', ['icon' => 'fas fa-user-lock']))
        )
    ;
});
