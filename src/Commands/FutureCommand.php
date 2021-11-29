<?php

namespace Future\LaraAdmin\Commands;

use Illuminate\Console\Command;

class FutureCommand extends Command
{
	protected $signature = 'future:install';

	protected $description = 'Заготовки';

	public function handle(): void
	{
		$this->exportBackend();

		$this->call('future:ui');
		$this->call('vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"');
		$this->call('vendor:publish --provider="Future\LaraAdmin\LaraAdminServiceProvider" --tag="migrations"');
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