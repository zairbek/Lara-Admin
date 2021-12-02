<?php

namespace Future\LaraAdmin\Commands;

use Illuminate\Console\Command;

class FutureCommand extends Command
{
	protected $signature = 'future:install';

	protected $description = 'Future';

	public function handle(): void
	{
		$this->call('future:ui');

		$this->call('vendor:publish', ['--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider', '--tag' => 'migrations']);
		$this->call('vendor:publish', ['--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider', '--tag' => 'config']);
		$this->call('vendor:publish', ['--provider' => 'Future\LaraAdmin\LaraAdminServiceProvider', '--tag' => 'migrations']);
		$this->call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider']);

		$this->call('config:clear');

		$this->info('ура');
	}
}