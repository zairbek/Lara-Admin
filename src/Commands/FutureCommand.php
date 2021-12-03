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


		if ($this->confirm('Переименовать старую таблицу users? (yes=переименовать|no=удалить)', true)) {
			$this->call('vendor:publish', ['--provider' => 'Future\LaraAdmin\LaraAdminServiceProvider', '--tag' => 'migrations:create_future_users_table.rename_old_users_table']);
		} else {
			$this->call('vendor:publish', ['--provider' => 'Future\LaraAdmin\LaraAdminServiceProvider', '--tag' => 'migrations:create_future_users_table.drop_old_users_table']);
		}

		$this->call('vendor:publish', ['--provider' => 'Future\LaraAdmin\LaraAdminServiceProvider', '--tag' => 'migrations:update_permissions_table']);
		$this->call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider']);
		$this->call('config:clear');

		if ($this->confirm('Выполняем миграцию?')) {
			$this->call('migrate');
		}

		if ($this->confirm('Создаем пользователей? (Группы и доступы)')) {
			$this->call('future:seed');
		}

		if ($this->confirm('Создаем тестовые пользователи?')) {
			$count = (int) $this->ask('Сколько?', 10);

			$this->call('future:seed:tests_users', ['--count' => $count]);
		}

		$this->call('future:publish');
	}
}