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


## Зависимости:
```json
{
  "php": "^8.0",
  "spatie/laravel-permission": "^5.4",
  "spatie/laravel-medialibrary": "^9.9" 
}
```

## Совместимости
### Протестировано

- `future/lara-admin:^1.0` = `laravel/framework:^8.65`

## Установка
Так как наш репозиторий является приватным, нам сначала нужно авторизоваться в композере:
1. Нам нужно получить access token от gitlab    
   ![Настройки](https://gitlab.com/future-group/backend/packages/lara-admin/-/raw/5bb14df767b9c98305e32eb02dc1e8a3fb273c5b/docs/img/img.png)   
   ![Настройки](https://gitlab.com/future-group/backend/packages/lara-admin/-/raw/5bb14df767b9c98305e32eb02dc1e8a3fb273c5b/docs/img/img_1.png)
   ![Настройки](https://gitlab.com/future-group/backend/packages/lara-admin/-/raw/5bb14df767b9c98305e32eb02dc1e8a3fb273c5b/docs/img/img_2.png)


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
