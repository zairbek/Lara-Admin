<?php

namespace Future\LaraAdmin\Commands;

use Future\LaraAdmin\Database\Seeders\GivePermissionSeeder;
use Future\LaraAdmin\Database\Seeders\PermissionSeeder;
use Future\LaraAdmin\Database\Seeders\RoleSeeder;
use Future\LaraAdmin\Database\Seeders\UserSeeder;
use Future\LaraAdmin\Repositories\PermissionRepository;
use Future\LaraAdmin\Repositories\RoleRepository;
use Future\LaraAdmin\Repositories\UserRepository;
use Illuminate\Console\Command;

class SeedUsersRolesPermissionsCommand extends Command
{
	protected $signature = 'future:seed';

	protected $description = 'Добавление пользователей, ролей и доступы';

	public function handle(): void
	{
		app(RoleSeeder::class)->run(new RoleRepository());
		app(PermissionSeeder::class)->run(new PermissionRepository());
		app(GivePermissionSeeder::class)->run(new RoleRepository() ,new PermissionRepository());
		app(UserSeeder::class)->run(new UserRepository());

		$this->info('Роли, доступы и пользователи создались.');
		$this->comment('Пользователи:');
		collect(UserSeeder::USERS)->each(function ($user, $role) {
			$this->comment(sprintf('%s - %s, %s', $role, $user['email'], $user['password']));
		});
	}
}