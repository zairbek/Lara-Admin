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