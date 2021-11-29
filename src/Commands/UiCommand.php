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

		$this->info('Все файлы необходимые для формирование админки перенеслись.');
		$this->comment('Пожалуйста запустите "npm install && npm run dev" для компиляции css, js файлы.');
	}
}