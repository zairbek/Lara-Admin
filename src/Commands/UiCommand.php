<?php

namespace Future\LaraAdmin\Commands;

use Future\LaraAdmin\Stubs\Presets\BootstrapAdminLte;
use Illuminate\Console\Command;

class UiCommand extends Command
{
	protected $signature = 'future:install';

	protected $description = 'Swap the front-end scaffolding for the application';

	public function handle()
	{
		BootstrapAdminLte::install($this);
		$this->exportBackend();
		$this->exportModels();
		$this->exportSeeders();

		$this->info('Bootstrap scaffolding installed successfully.');
		$this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
	}

	protected function exportBackend(): void
	{
		file_put_contents(
			base_path('routes/web.php'),
			file_get_contents(__DIR__.'/../Stubs/routes.stub'),
			FILE_APPEND
		);
	}

	protected function exportModels(): void
	{
		copy(__DIR__.'/../Stubs/Models/User.stub', app_path('Models/User.php'));
		copy(__DIR__.'/../Stubs/Repositories/UserRepository.php.stub', app_path('Repositories/UserRepository.php'));
	}

	protected function exportSeeders(): void
	{
		copy(__DIR__.'/../../database/seeders/GivePermissionSeeder.php.stub', database_path('seeders/GivePermissionSeeder.php'));
		copy(__DIR__.'/../../database/seeders/PermissionSeeder.php.stub', database_path('seeders/PermissionSeeder.php'));
		copy(__DIR__.'/../../database/seeders/RoleSeeder.php.stub', database_path('seeders/RoleSeeder.php'));
		copy(__DIR__.'/../../database/seeders/UserSeeder.php.stub', database_path('seeders/UserSeeder.php'));
	}
}