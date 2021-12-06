<?php

namespace Future\LaraAdmin\Mixins;

use Spatie\Menu\ActiveUrlChecker;
use Spatie\Menu\Laravel\Html;

/** @mixin Html */
class HtmlMixin
{
    public function mainMenuItem()
    {
        return function ($to, $name, $options = []) {
            $active = ActiveUrlChecker::check($to, app('request')->path());

            /** @var Html $this */
            return Html::raw(
                sprintf(
                    '<a href="%s" class="nav-link %s"><i class="nav-icon %s"></i><p>%s %s</p></a>',
                    $to,
                    $active ? 'active' : '',
                    $options['icon'] ?? '',
                    $name,
                    isset($options['arrow']) ? '<i class="right fas fa-angle-left"></i>' : ''
                )
            )->addParentClass('nav-item');
        };
    }

    public function mainMenuEmptyItem()
    {
        return function ($title) {
            /** @var Html $this */
            return Html::raw($title)->addParentClass('nav-header');
        };
    }
}
