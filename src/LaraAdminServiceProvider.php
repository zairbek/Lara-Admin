<?php

namespace Future\LaraAdmin;

use Future\LaraAdmin\Commands\FutureCommand;
use Future\LaraAdmin\Commands\PublishResourcesCommand;
use Future\LaraAdmin\Commands\SeedFakeUsersCommand;
use Future\LaraAdmin\Commands\SeedUsersRolesPermissionsCommand;
use Future\LaraAdmin\Commands\UiCommand;
use Future\LaraAdmin\Http\Middleware\Authenticate;
use Future\LaraAdmin\Http\Middleware\RedirectIfAuthenticated;
use Future\LaraAdmin\View\Components\Sidebar;
use Future\LaraAdmin\View\Components\Menu;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

class LaraAdminServiceProvider extends ServiceProvider
{
	public const HOME = '/admin';

	public function boot()
	{
		$this->registerMorphMap();
		$this->registerCommands();
		$this->registerViews();
		$this->registerViewComponents();
		$this->registerPublished();
		$this->registerRoutes();
		$this->registerMiddlewares();
		$this->registerMigrations();
	}

	public function register()
	{
		//
	}

	/**
	 * Когда мы используем полиморфные связи, в колонку model_type записывается вот так '\Namespace\Classname'
	 * Ниже мы переопределяем это. И теперь, если мы даже хотим переопределить класс (наследоваться), то нам нужно просто поменять в конфиге классы
	 * @url https://laravel.com/docs/8.x/eloquent-relationships#custom-polymorphic-types
	 */
	protected function registerMorphMap(): void
	{
		Relation::morphMap([
			'users' => config('auth.providers.users.model'),
			'roles' => config('permission.models.role'),
			'permissions' => config('permission.models.permission')
		]);
	}

	/**
	 * Зарегистрируем артизан команды
	 *
	 * @example php artisan future:install
	 * @url https://laravelpackage.com/06-artisan-commands.html#registering-a-command-in-the-service-provider
	 */
	protected function registerCommands(): void
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				FutureCommand::class,
				UiCommand::class,
				SeedUsersRolesPermissionsCommand::class,
				PublishResourcesCommand::class,
				SeedFakeUsersCommand::class,
			]);
		}
	}

	/**
	 * Зарегистрируем blade шаблоны
	 *
	 * @example view('future::pages.admin.index')
	 * @example @extends('future::layouts.admin')
	 * @url https://laravelpackage.com/09-routing.html#views
	 */
	protected function registerViews(): void
	{
		$this->loadViewsFrom(__DIR__.'/../resources/views', 'future');
	}

	/**
	 * Зарегистрируем компоненты
	 *
	 * @example <x-future-sidebar/> вызовет компонент Future\LaraAdmin\View\Components\Sidebar::class
	 * @url https://laravelpackage.com/09-routing.html#view-components
	 */
	protected function registerViewComponents(): void
	{
		$this->loadViewComponentsAs('future', [
			Sidebar::class,
			Menu::class,
		]);
	}

	/**
	 * Зарегистрируем blade шаблоны на публикацию
	 *
	 * @example php artisan future:publish
	 * @example php artisan vendor:publish --provider="Future\LaraAdmin\LaraAdminServiceProvider" --tag="future::views.all"
	 * @url https://laravelpackage.com/09-routing.html#customizable-views
	 */
	protected function registerPublished(): void
	{
		$this->publishes([
			__DIR__.'/../resources/views' => resource_path('views/vendor/future'),
		], 'future::views.all');
		$this->publishes([
			__DIR__.'/../resources/views/layouts' => resource_path('views/vendor/future/layouts'),
		], 'future::views.layouts');
		$this->publishes([
			__DIR__.'/../resources/views/components' => resource_path('views/vendor/future/components'),
		], 'future::views.components');
		$this->publishes([
			__DIR__.'/../resources/views/pages/admin' => resource_path('views/vendor/future/pages/admin'),
		], 'future::views.pages.admin');
		$this->publishes([
			__DIR__.'/../resources/views/pages/admin/index.blade.php' => resource_path('views/vendor/future/pages/admin/index.blade.php'),
		], 'future::views.pages.admin.index');
		$this->publishes([
			__DIR__.'/../resources/views/pages/admin/auth' => resource_path('views/vendor/future/pages/admin/auth'),
		], 'future::views.pages.admin.auth');
		$this->publishes([
			__DIR__.'/../resources/views/pages/admin/settings/permissions' => resource_path('views/vendor/future/pages/admin/settings/permissions'),
		], 'future::views.pages.admin.permissions');
		$this->publishes([
			__DIR__.'/../resources/views/pages/admin/settings/roles' => resource_path('views/vendor/future/pages/admin/settings/roles'),
		], 'future::views.pages.admin.roles');
		$this->publishes([
			__DIR__.'/../resources/views/pages/admin/settings/users' => resource_path('views/vendor/future/pages/admin/settings/users'),
		], 'future::views.pages.admin.users');
	}

	/**
	 * Зарегистрируем роуты
	 *
	 * @url https://laravelpackage.com/09-routing.html#routes
	 */
	protected function registerRoutes(): void
	{
		$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
	}

	protected function registerMiddlewares(): void
	{
		$router = $this->app->make(Router::class);
		$router->aliasMiddleware('auth.admin', Authenticate::class);
		$router->aliasMiddleware('guest.admin', RedirectIfAuthenticated::class);
		$router->aliasMiddleware('role', RoleMiddleware::class);
		$router->aliasMiddleware('permission', PermissionMiddleware::class);
		$router->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
	}

	/**
	 * Зарегистрируем миграции на публикацию
	 *
	 * @url https://laravelpackage.com/08-models-and-migrations.html#publishing-migrations-method-1
	 */
	protected function registerMigrations(): void
	{
		// Export the migration
		if ($this->app->runningInConsole()) {
			if (! class_exists('FutureUsersTable')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/future_users_table.php.default.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_future_users_table.php'),
					// you can add any number of migrations here
				], 'migrations:create_future_users_table.rename_old_users_table');
			}
			if (! class_exists('FutureUsersTable')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/future_users_table.php.drop.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_future_users_table.php'),
					// you can add any number of migrations here
				], 'migrations:create_future_users_table.drop_old_users_table');
			}
			if (! class_exists('UpdatePermissionTables')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/update_permission_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_update_permission_tables.php'),
					// you can add any number of migrations here
				], 'migrations:update_permissions_table');
			}
		}
	}
}