<?php

namespace Future\LaraAdmin\Commands;

use Illuminate\Console\Command;

class AdminCommand extends Command
{
	protected $signature = 'admin:install';

	protected $description = 'Scaffold basic Admin views';

	protected $views = [
		'../Stubs/Admin/bootstrap-adminlte-stubs/layouts/app.stub' => 'layouts/app.blade.php',
		'../Stubs/Admin/bootstrap-adminlte-stubs/pages/index.stub' => 'pages/index.blade.php',
		'../Stubs/Admin/bootstrap-adminlte-stubs/components/sidebar.stub' => 'components/sidebar.blade.php',
		'../Stubs/Admin/bootstrap-adminlte-stubs/components/sidebar/menu.stub' => 'components/sidebar/menu.blade.php',
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

		if (! is_dir($directory = $this->getViewPath('pages/auth/passwords'))) {
			mkdir($directory, 0755, true);
		}

		if (! is_dir($directory = $this->getViewPath('components/sidebar'))) {
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