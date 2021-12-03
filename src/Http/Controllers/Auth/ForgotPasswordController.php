<?php

namespace Future\LaraAdmin\Http\Controllers\Auth;

use Future\LaraAdmin\Http\Controllers\Controller;
use Future\LaraAdmin\Traits\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
	use SendsPasswordResetEmails;

	public function __construct()
	{
		$this->middleware('guest.admin');
	}
}