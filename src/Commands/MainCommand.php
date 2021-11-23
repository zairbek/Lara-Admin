<?php

namespace Future\LaraAdmin\Commands;

use Future\LaraAdmin\Stubs\Presets\BootstrapAdminLte;
use Illuminate\Console\Command;

class MainCommand extends Command
{
	protected $signature = 'admin:install';

	protected $description = 'Swap the front-end scaffolding for the application';

	public function handle()
	{
		$this->call('admin:ui');
//		$this->call('admin:admin');
//		$this->call('admin:auth');

		$this->info('Админ панель готов');
	}
}