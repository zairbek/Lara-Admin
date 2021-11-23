<?php

namespace Future\LaraAdmin;

use Future\LaraAdmin\Commands\MainCommand;
use Future\LaraAdmin\Commands\UiCommand;
use Future\LaraAdmin\View\Components\Sidebar;
use Future\LaraAdmin\View\Components\Menu;
use Illuminate\Support\ServiceProvider;

class LaraAdminServiceProvider extends ServiceProvider
{
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				MainCommand::class,
//				AdminCommand::class,
//				AuthCommand::class,
				UiCommand::class
			]);
		}

		$this->registerViews();
		$this->registerViewComponents();
	}

	public function register()
	{
		//
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
}