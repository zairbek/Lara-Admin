## Зависимости

- `spatie/laravel-permission` для ролей и доступов
- `spatie/laravel-medialibrary` для работы с файлами

## Миграции

- `database/migrations/future_users_table.php.default.stub`
    - миграция таблицы `users` с переименованием старого таблицы `users` на `__users`
    - публикуется при запуске команды `php artisan future:install`
- `database/migrations/future_users_table.php.drop.stub`
    - миграция таблицы `users` с удалением старого таблицы `users`
    - публикуется при запуске команды `php artisan future:install`
- `database/migrations/update_permission_tables.php.stub`
    - Добавляет в таблицу `permissions, roles` колонку `title`
    - публикуется при запуске команды `php artisan future:install`

## Seeders

- Запускается по команде `php artisan future:install`
- Можно перезапустить по команде `php artisan future:seed`
- `database/seeders/GivePermissionSeeder.php` Привязывает доступов с ролями
- `database/seeders/PermissionSeeder.php` Создает доступов
- `database/seeders/RoleSeeder.php` Создает ролей
- `database/seeders/UserSeeder.php` Создает пользователей и привязывает с ролями
- `database/seeders/SeedFakeUsersCommand.php` Создает тестовых пользователи
  - Можно запустить по команде `php artisan future:seed:tests_users --count=20`

## Views (Шаблоны)

- Если придется в шаблоне что-то менять, то нужно опубликовать
- Опубликовать можно так: `php artisan future:publish`

### Структура шаблонов
```
resources
└── views
    ├── components
    │   ├── menu.blade.php
    │   ├── pagination
    │   │   └── default.blade.php
    │   └── sidebar.blade.php
    ├── layouts
    │   ├── admin.blade.php
    │   └── auth.blade.php
    └── pages
        ├── admin
        │   ├── auth
        │   │   ├── forgot-password.blade.php
        │   │   ├── recover-password.blade.php
        │   │   └── sign-in.blade.php
        │   ├── index.blade.php
        │   └── settings
        │       ├── permissions
        │       │   ├── create.blade.php
        │       │   ├── edit.blade.php
        │       │   ├── index.blade.php
        │       │   └── show.blade.php
        │       ├── roles
        │       │   ├── create.blade.php
        │       │   ├── edit.blade.php
        │       │   ├── index.blade.php
        │       │   └── show.blade.php
        │       └── users
        │           ├── create.blade.php
        │           ├── edit.blade.php
        │           ├── index.blade.php
        │           └── show.blade.php
        └── index.blade.php
```

## Роуты

- `routes/web.php` подключается автоматом через сервис провайдер `srs/LaraAdminServiceProvider.php`

### Префиксы

- Для админской части сайта нужно использовать `'prefix' => 'admin'`, то есть, роут должен быть так: `/admin`

### Middleware

- Для админской части сайта нужно использовать `middleware` `auth.admin`
  - Этот middleware нужен для авторизации админской части сайта
  - Middleware лежит в папке `src/Http/Middleware/Authenticate.php`
  - Middleware зарегистрируется автоматом в файле `LaraAdminServiceProvider.php`, строка - `$router->aliasMiddleware('auth.admin', Authenticate::class);`
  - Middleware `permission:admin@show` посмотрите документацию [laravel-permissions](https://spatie.be/docs/laravel-permission/v5/basic-usage/middleware#package-middleware)

## Папка src

### src/LaraAdminServiceProvider.php

- `registerMorphMap()` Когда мы используем полиморфные связи, в колонку model_type записывается вот так '\Namespace\Classname'. Ниже мы переопределяем это. И теперь, если мы даже хотим переопределить класс (наследоваться), то нам нужно просто поменять в конфиге классы [Документация](https://laravel.com/docs/8.x/eloquent-relationships#custom-polymorphic-types)
- `registerCommands()` Зарегистрируем артизан команды. Пример: `php artisan future:install` [Документация](https://laravelpackage.com/06-artisan-commands.html#registering-a-command-in-the-service-provider)
- `registerViews()` Зарегистрируем blade шаблоны Пример: `view('future::pages.admin.index')` `@extends('future::layouts.admin')` [Документация](https://laravelpackage.com/09-routing.html#views)
- `registerViewComponents()` Зарегистрируем компоненты Пример: `<x-future-sidebar/>` вызовет компонент Future\LaraAdmin\View\Components\Sidebar::class [Документация](https://laravelpackage.com/09-routing.html#view-components)

- `registerPublished()` Зарегистрируем blade шаблоны на публикацию [Документация](https://laravelpackage.com/09-routing.html#customizable-views)
  - Пример: `php artisan future:publish`
  - Пример: `php artisan vendor:publish --provider="Future\LaraAdmin\LaraAdminServiceProvider" --tag="future::views.all"`

- `registerMigrations()` Зарегистрируем миграции на публикацию [Документация](https://laravelpackage.com/08-models-and-migrations.html#publishing-migrations-method-1)

### src/Commands/

### src/Http/Controllers
- Если нужно расширить функционал контроллера, наследуйтесь или переопределите контроллер, и не забудьте также переопределить роут

### src/Http/Middleware
- `Authenticate.php` - 'auth.admin'
- `RedirectIfAuthenticated.php` - 'guest.admin'

### src/Http/Requests
- Обычные реквесты с валидацией


### src/Models
- `User.php` Базовый модель пользователя

### src/Repositories
- Все манипуляции таблицы должны проходить через репозиторий
- Например:
  - Нужно создать пользователя.
  - ```php
    $repo = app(\Future\LaraAdmin\Repositories\UserRepository::class);
    $repo->createUser(['email' => 'email@gmail.com'], 'user');
    ```

### src/Traits
- Трейты

### src/View
- Логика компонентов