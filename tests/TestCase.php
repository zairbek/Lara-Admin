<?php

namespace Future\LaraAdmin\Tests;

use Future\LaraAdmin\LaraAdminServiceProvider;
use Future\LaraAdmin\Tests\Mocks\User;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as TestCaseAlias;

class TestCase extends TestCaseAlias
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();

		$this->artisan('migrate:fresh');
	}

	protected function getEnvironmentSetUp($app)
	{
		$config = $app->make(Repository::class);

		$config->set('auth.defaults.provider', 'users');

		$config->set('auth.providers.users.model', User::class);

		$config->set('auth.guards.api', ['driver' => 'passport', 'provider' => 'users']);

		$app['config']->set('database.default', 'testbench');

		$app['config']->set('passport.storage.database.connection', 'testbench');

		$app['config']->set('database.connections.testbench', [
			'driver'   => 'sqlite',
			'database' => ':memory:',
			'prefix'   => '',
		]);
	}

	public function getPackageProviders($app)
	{
		return [LaraAdminServiceProvider::class];
	}
}