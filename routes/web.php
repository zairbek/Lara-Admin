<?php

use Future\LaraAdmin\Http\Controllers\Auth\SignInController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
	Route::get('/', fn() => view('future::pages.admin.index'))->name('admin');

	Route::group([], function () {
		Route::get('/auth/sign-in', [SignInController::class, 'showForm'])->name('admin.auth.sign-in');
		Route::post('/auth/sign-in', [SignInController::class, 'signIn'])->name('admin.auth.sign-in.post');
		Route::get('/auth/forgot-password', fn() => view('future::pages.admin.auth.forgot-password'))->name('admin.auth.forgot-password');
		Route::get('/auth/recover-password', fn() => view('future::pages.admin.auth.recover-password'))->name('admin.auth.recover-password');
	})->withoutMiddleware('auth');

});

