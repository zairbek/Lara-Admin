<?php

namespace Future\LaraAdmin\Tests\Feature;

class SignInControllerTest extends FeatureTestCase
{
	/**
	 * @todo Пока не знаю как тестить
	 */
	public function testShowForm()
	{
		$this
			->get(route('admin.auth.sign-in'))
			->assertSuccessful()
		;
	}
}