<?php

namespace Future\LaraAdmin\Commands;

use Future\LaraAdmin\Database\Seeders\GivePermissionSeeder;
use Future\LaraAdmin\Database\Seeders\PermissionSeeder;
use Future\LaraAdmin\Database\Seeders\RoleSeeder;
use Future\LaraAdmin\Database\Seeders\UserSeeder;
use Illuminate\Console\Command;

class SeedUsersRolesPermissionsCommand extends Command
{
	protected $signature = 'future:seed';

	protected $description = 'Добавление пользователей, ролей и доступы';

	public function handle(): void
	{
		app(RoleSeeder::class)->run();
		app(PermissionSeeder::class)->run();
		app(GivePermissionSeeder::class)->run();
		app(UserSeeder::class)->run();
	}
}