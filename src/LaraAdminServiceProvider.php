<?php

namespace Future\LaraAdmin;

use Carbon\Carbon;
use Future\LaraAdmin\Commands\AdminCommand;
use Future\LaraAdmin\Commands\AuthCommand;
use Future\LaraAdmin\Commands\MainCommand;
use Future\LaraAdmin\Commands\UiCommand;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class LaraAdminServiceProvider extends ServiceProvider
{
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				MainCommand::class,
				AdminCommand::class,
				AuthCommand::class,
				UiCommand::class
			]);
		}
	}

	public function register()
	{
		//
	}
}