<?php

namespace Future\LaraAdmin\Commands;

use Database\Seeders\GivePermissionSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
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