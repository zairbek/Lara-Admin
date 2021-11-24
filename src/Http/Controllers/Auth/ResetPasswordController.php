<?php

namespace Future\LaraAdmin\Http\Controllers\Auth;

use Future\LaraAdmin\Http\Controllers\Controller;
use Future\LaraAdmin\Http\Middleware\ResetsPasswords;
use Future\LaraAdmin\LaraAdminServiceProvider;

class ResetPasswordController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = LaraAdminServiceProvider::HOME;

	public function __construct()
	{
		$this->middleware('guest.admin');
	}
}