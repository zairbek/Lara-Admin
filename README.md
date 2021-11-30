# Laravel Admin

## Вступление
> Laravel пакет для быстрого развертывания авторизацию.

## Todo
- [ ] нужно для всех контроллеров повесить событий (до, после и во время)
- [ ] Обработать exception 
- [ ] Установить статические анализаторы (phpstan, phpcs ...)
- [ ] Дописать тесты (Unit)
- [ ] Дописать ответы ошибок - swagger документация (docs/swagger.json)
- [ ] Нужно перенести на gitlab
- [ ] Написать CI/CD
    - [ ] Запускать тесты
    - [ ] Публикация в Package Registry (Packages & Registries -> Package Registry)

## API документация
Api документация написано на swagger-e  
Документация docs/swagger.json

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

4. Публикуем пакеты js, js, scss файлы конфигурации необходимые для развёртывания админки
```bash
php artisan future:install
```
```bash
npm install && npm run production
```

Откройте файл `config/auth.php`, измените значение `model` на `\Future\LaraAdmin\Models\User::class`:
```php
    'users' => [
        'driver' => 'eloquent',
        'model' => \Future\LaraAdmin\Models\User::class, # Установите это
    ],
```

Выполните миграцию
```bash
php artisan migrate
```

Это команда создаст ролей, доступов и пользователей 
```php
php artisan future:seed
```


5. Готово.


## Расширенное использование

```bash
php artisan vendor:publish
```
