<?php

namespace Future\LaraAdmin\Commands;

use Future\LaraAdmin\Stubs\Presets\BootstrapAdminLte;
use Illuminate\Console\Command;

class UiCommand extends Command
{
	protected $signature = 'admin:ui';

	protected $description = 'Swap the front-end scaffolding for the application';

	public function handle()
	{
		BootstrapAdminLte::install($this);
		$this->exportBackend();

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
}