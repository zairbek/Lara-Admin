<?php

use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Html;

Menu::macro('main', function () {
    return Menu::mainMenu()
        ->addIfCan(['admin@show'], Html::mainMenuItem('/admin', 'Dashboard', ['icon' => 'fas fa-tachometer-alt']))
        ->addIfCan(['admin@show'], Html::mainMenuEmptyItem('Настройки'))
        ->customSubmenu(
            'Пользователи',
            Menu::tree()
            ->addIfCan(['users@show'], Html::mainMenuItem('/admin/settings/users', 'Пользователи', ['icon' => 'fas fa-user']))
            ->addIfCan(['roles@show'], Html::mainMenuItem('/admin/settings/roles', 'Группы', ['icon' => 'fas fa-users']))
            ->addIfCan(['permissions@show'], Html::mainMenuItem('/admin/settings/permissions', 'Доступы', ['icon' => 'fas fa-user-lock']))
        )
    ;
});
