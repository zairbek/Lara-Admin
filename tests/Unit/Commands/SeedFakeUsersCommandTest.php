<?php

namespace Future\LaraAdmin\Tests\Unit\Commands;

use Future\LaraAdmin\Tests\Unit\UnitTestCase;

class SeedFakeUsersCommandTest extends UnitTestCase
{
	public function test()
	{
		$res = $this->artisan('future:seed:tests_users', [])->execute();

		dd($res);
	}
}