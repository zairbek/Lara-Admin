<?php

namespace Future\LaraAdmin\Commands;

use Future\LaraAdmin\Stubs\Presets\BootstrapAdminLte;
use Illuminate\Console\Command;

class UiCommand extends Command
{
	protected $signature = 'ui:install';

	protected $description = 'Swap the front-end scaffolding for the application';

	public function handle()
	{
		BootstrapAdminLte::install();

		$this->info('Bootstrap scaffolding installed successfully.');
		$this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
	}
}