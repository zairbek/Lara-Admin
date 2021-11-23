<?php

namespace Future\LaraAdmin\Http\Controllers\Auth;

use Future\LaraAdmin\Http\Controllers\Controller;
use Future\LaraAdmin\LaraAdminServiceProvider;
use Future\LaraAdmin\Traits\Auth\AuthenticatesUsers;

class SignInController extends Controller
{
	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = LaraAdminServiceProvider::HOME;
}