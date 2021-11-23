<?php

namespace Future\LaraAdmin\Commands;

use Illuminate\Console\Command;

class AdminCommand extends Command
{
	protected $signature = 'admin:admin';

	protected $description = 'Scaffold basic Admin views';

	protected $views = [
		'../Stubs/Admin/bootstrap-adminlte-stubs/layouts/admin.stub' => 'layouts/admin.blade.php',
		'../Stubs/Admin/bootstrap-adminlte-stubs/layouts/auth.stub' => 'layouts/auth.blade.php',
		'../Stubs/Admin/bootstrap-adminlte-stubs/pages/index.stub' => 'pages/index.blade.php',
		'../Stubs/Admin/bootstrap-adminlte-stubs/pages/admin/index.stub' => 'pages/admin/index.blade.php',
		'../Stubs/Admin/bootstrap-adminlte-stubs/components/sidebar.stub' => 'components/sidebar.blade.php',
		'../Stubs/Admin/bootstrap-adminlte-stubs/components/sidebar/menu.stub' => 'components/sidebar/menu.blade.php',
	];

	public function handle()
	{
		$this->ensureDirectoriesExist();
		$this->exportViews();
		$this->exportBackend();
	}

	protected function ensureDirectoriesExist()
	{
		if (! is_dir($directory = $this->getViewPath('layouts'))) {
			mkdir($directory, 0755, true);
		}

		if (! is_dir($directory = $this->getViewPath('pages/admin/auth'))) {
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


	protected function exportBackend()
	{
		file_put_contents(
			base_path('routes/web.php'),
			file_get_contents(__DIR__.'/../Stubs/routes.stub'),
			FILE_APPEND
		);
	}

	protected function getViewPath($path)
	{
		return implode(DIRECTORY_SEPARATOR, [
			config('view.paths')[0] ?? resource_path('views'), $path,
		]);
	}
}