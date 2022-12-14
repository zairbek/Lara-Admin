<?php

namespace Future\LaraAdmin\Tests\Mocks;

use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @property string $email
 * @property string $password
 * @property null|string $remember_token
 *
 * @package Future\LaraAdmin\Tests\Mocks
 */
class User extends \Illuminate\Foundation\Auth\User
{
	use Notifiable;
}