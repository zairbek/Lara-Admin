## Зависимости:

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