<?php

namespace Future\LaraAdmin\Mixins;

use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Html;

/** @mixin Menu */
class MenuMixin
{
    public function mainMenu()
    {
        return function () {
            /** @var Menu $this */
            return Menu::new()
                ->wrap('nav', ['class' => 'mt-2'])
                ->addClass('nav nav-pills nav-sidebar flex-column')
                ->setAttributes(['data-widget' => 'treeview', 'role' => 'menu', 'data-accordion' => 'false']);
        };
    }

    public function tree()
    {
        return function () {
            /** @var Menu $this */
            return Menu::new()->addClass('nav nav-treeview')->addParentClass('nav-item');
        };
    }

    public function customSubmenu()
    {
        return function ($name, $callable) {
            /** @var Menu $this */
            return $this->submenu(Html::mainMenuItem('#', $name, ['arrow' => true]), $callable);
        };
    }
}
