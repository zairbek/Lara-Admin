# Laravel Admin

## Вступление
> Laravel пакет для быстрого развертывания админку.

## Todo
- [ ] нужно для всех контроллеров повесить событий (до, после и во время)
- [ ] Обработать exception 
- [ ] Установить статические анализаторы (phpstan, phpcs ...)
- [ ] Дописать тесты (Unit)
- [ ] Дописать ответы ошибок - swagger документация (docs/swagger.json)
- [ ] Написать CI/CD
    - [ ] Запускать тесты

[comment]: <> (## API документация)

[comment]: <> (Api документация написано на swagger-e  )

[comment]: <> (Документация docs/swagger.json)

## Установка
Так как наш репозиторий является приватным, нам сначала нужно авторизоваться в композере:
1. Нам нужно получить access token от gitlab    
   ![Настройки](docs/img/img.png)   
   ![Настройки](docs/img/img_1.png) 
   ![Настройки](docs/img/img_2.png) 

2. Авторизуемся:
```bash
composer config http-basic.gitlab.com ___token___ <ACCESS_TOKEN> # вместо <ACCESS_TOKEN> вставьте ваш ACCESS_TOKEN из предыдущего шага  
```

3. Устанавливаем:
```bash
composer config repositories.gitlab.com/14060480 '{"type": "composer", "url": "https://gitlab.com/api/v4/group/14060480/-/packages/composer/packages.json"}'
```
```bash
composer req future/lara-admin
```
Или выбрать конкретную версию пакета
```bash
composer req future/lara-admin:0.1.0
```
> Примеры взято из Packages & Registries -> Package Registry

4. Откройте файл `config/auth.php`, измените значение `model` на `\Future\LaraAdmin\Models\User::class`:
```php
    'users' => [
        'driver' => 'eloquent',
        'model' => \Future\LaraAdmin\Models\User::class, # Установите это
    ],
```

5. Публикуем пакеты js, js, scss файлы конфигурации необходимые для развёртывания админки
```bash
php artisan future:install
```
```bash
npm install && npm run production
```



[comment]: <> (Выполните миграцию)

[comment]: <> (```bash)

[comment]: <> (php artisan migrate)

[comment]: <> (```)

[comment]: <> (Это команда создаст ролей, доступов и пользователей )

[comment]: <> (```bash)

[comment]: <> (php artisan future:seed)

[comment]: <> (```)


5. Готово.


# Что содержит пакет:

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