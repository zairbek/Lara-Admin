<?php

namespace Future\LaraAdmin\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
	/**
	 * @return Application|Factory|View
	 */
	public function __invoke(): View|Factory|Application
	{
		return view('future::pages.index');
	}
}