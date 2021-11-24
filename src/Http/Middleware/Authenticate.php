<?php

namespace Future\LaraAdmin\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	/**
	 * @param \Illuminate\Http\Request $request
	 * @return string|null
	 */
	protected function redirectTo($request)
	{
		if (! $request->expectsJson()) {
			return route('admin.auth.sign-in');
		}
	}
}