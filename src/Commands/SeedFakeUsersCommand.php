<?php

namespace Future\LaraAdmin\Commands;

use Future\LaraAdmin\Database\Seeders\FakeUserSeeder;
use Future\LaraAdmin\Repositories\UserRepository;
use Illuminate\Console\Command;

class SeedFakeUsersCommand extends Command
{
	protected $signature = 'future:seed:tests_users 
							{--count=10 : Количество фейковых пользователей}
							';

	protected $description = 'Добавление тестовых пользователей';

	public function handle(): void
	{
		app(FakeUserSeeder::class)->run(new UserRepository(), (int) $this->option('count'));

		$this->info('Тестовые пользователи создались.');
	}
}