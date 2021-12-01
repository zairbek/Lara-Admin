<?php

namespace Future\LaraAdmin;

use Future\LaraAdmin\Commands\FutureCommand;
use Future\LaraAdmin\Commands\SeedUsersRolesPermissionsCommand;
use Future\LaraAdmin\Commands\UiCommand;
use Future\LaraAdmin\Http\Middleware\Authenticate;
use Future\LaraAdmin\Http\Middleware\RedirectIfAuthenticated;
use Future\LaraAdmin\Models\User;
use Future\LaraAdmin\View\Components\Sidebar;
use Future\LaraAdmin\View\Components\Menu;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
	 * Ниже мы переопределяем это. И теперь, если мы даже хотим переопределить класс (наследоваться), то нам нужно просто
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

	protected function registerCommands(): void
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				FutureCommand::class,
				UiCommand::class,
				SeedUsersRolesPermissionsCommand::class,
			]);
		}
	}

	protected function registerViews(): void
	{
		$this->loadViewsFrom(__DIR__.'/../resources/views', 'future');
	}

	protected function registerViewComponents(): void
	{
		$this->loadViewComponentsAs('future', [
			Sidebar::class,
			Menu::class,
		]);
	}

	protected function registerPublished(): void
	{
		$this->publishes([
			__DIR__.'/../resources/views' => resource_path('views/vendor/future'),
		], 'future:views:all');

		$this->publishes([
			__DIR__.'/../resources/views/layouts' => resource_path('views/vendor/future/layouts'),
		], 'future:views:layouts');

		$this->publishes([
			__DIR__.'/../resources/views/components' => resource_path('views/vendor/future/components'),
		], 'future:views:components');

		$this->publishes([
			__DIR__.'/../resources/views/pages/admin/auth' => resource_path('views/vendor/future/pages/admin/auth'),
		], 'future:views:admin-auth');
	}

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

	protected function registerMigrations(): void
	{
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

		// Export the migration
		if ($this->app->runningInConsole()) {
			if (! class_exists('CreatePostsTable')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/future_users_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_future_users_table.php'),
					__DIR__ . '/../database/migrations/update_permission_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_update_permission_tables.php'),
					// you can add any number of migrations here
				], 'migrations');
			}
		}
	}
}