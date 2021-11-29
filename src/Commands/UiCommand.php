<?php

namespace Future\LaraAdmin\Commands;

use Future\LaraAdmin\Stubs\Presets\BootstrapAdminLte;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class UiCommand extends Command
{
	protected $signature = 'future:ui';

	protected $description = 'Swap the front-end scaffolding for the application';

	public function handle()
	{
		BootstrapAdminLte::install($this);

		$this->info('Bootstrap scaffolding installed successfully.');
		$this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
	}
}