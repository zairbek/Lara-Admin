<?php

namespace Future\LaraAdmin\View\Components\Sidebar;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Menu extends Component
{
    public Collection $menu;

    /**
     * Create a new component instance.
     *
     * @return void
     * @throws \Exception
     */
    public function __construct()
    {
        $this->menu = collect(
            [
                new MenuItem(
                    'Dashboard',
                    active: false,
                    link: '/',
                    icon: 'fas fa-tachometer-alt',
                    notification: [
                        'type' => 'info',
                        'text' => 'new'
                    ],
                ),
                new MenuItem(
                    title: 'Настройки'
                ),
                new MenuItem(
                    'Пользователи',
                    active: false,
                    link: '#',
                    icon: 'fas fa-user',
                    child: collect([
                        new MenuItem(
                            title: 'Пользователи',
                            active: true,
                            link: '/',
                            icon: 'fas fa-user'
                        ),
                        new MenuItem(
                            title: 'Группы',
                            active: false,
                            link: '/',
                            icon: 'fas fa-users'
                        ),
                        new MenuItem(
                            title: 'Доступы',
                            active: false,
                            link: '/',
                            icon: 'fas fa-user-lock'
                        )
                    ])
                )
            ]
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('future::components.sidebar.menu');
    }
}
