<?php

namespace Future\LaraAdmin;

use Future\LaraAdmin\Commands\UiCommand;
use Future\LaraAdmin\View\Components\Sidebar;
use Future\LaraAdmin\View\Components\Menu;
use Illuminate\Support\ServiceProvider;

class LaraAdminServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->registerCommands();
		$this->registerViews();
		$this->registerViewComponents();
		$this->registerPublished();
	}

	public function register()
	{
		//
	}

	protected function registerCommands(): void
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				UiCommand::class
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
			__DIR__.'/../resources/views' => resource_path('views/vendor/courier'),
		], 'views');
	}
}