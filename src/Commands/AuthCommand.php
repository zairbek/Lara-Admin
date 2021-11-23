<?php

namespace Future\LaraAdmin\Commands;

use Illuminate\Console\Command;

class AuthCommand extends Command
{
	protected $signature = 'admin:auth';

	protected $description = 'Scaffold basic login views';

	protected $views = [
		'../Stubs/Auth/bootstrap-adminlte-stubs/layouts/auth.stub' => 'layouts/auth.blade.php',
		'../Stubs/Auth/bootstrap-adminlte-stubs/pages/admin/auth/forgot-password.stub' => 'pages/admin/auth/forgot-password.blade.php',
		'../Stubs/Auth/bootstrap-adminlte-stubs/pages/admin/auth/recover-password.stub' => 'pages/admin/auth/recover-password.blade.php',
		'../Stubs/Auth/bootstrap-adminlte-stubs/pages/admin/auth/sign-in.stub' => 'pages/admin/auth/sign-in.blade.php',
	];

	public function handle()
	{
		$this->ensureDirectoriesExist();
		$this->exportViews();
	}

	protected function ensureDirectoriesExist()
	{
		if (! is_dir($directory = $this->getViewPath('layouts'))) {
			mkdir($directory, 0755, true);
		}

		if (! is_dir($directory = $this->getViewPath('pages/admin/auth'))) {
			mkdir($directory, 0755, true);
		}
	}

	protected function exportViews()
	{
		foreach ($this->views as $key => $value) {
			if (file_exists($view = $this->getViewPath($value))) {
				if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
					continue;
				}
			}

			copy(__DIR__. '/' .$key, $view);
		}
	}
	
	protected function getViewPath($path)
	{
		return implode(DIRECTORY_SEPARATOR, [
			config('view.paths')[0] ?? resource_path('views'), $path,
		]);
	}
}