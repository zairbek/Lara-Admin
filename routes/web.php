<?php

use Future\LaraAdmin\Http\Controllers\Auth\ForgotPasswordController;
use Future\LaraAdmin\Http\Controllers\Auth\ResetPasswordController;
use Future\LaraAdmin\Http\Controllers\Auth\SignInController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web'], function () {
	Route::group(['prefix' => 'admin'], function () {
		Route::get('/auth/sign-in', [SignInController::class, 'showForm'])->name('admin.auth.sign-in');
		Route::post('/auth/sign-in', [SignInController::class, 'signIn'])->name('admin.auth.sign-in.post');
		Route::get('/auth/sign-out', [SignInController::class, 'signOut'])->name('admin.auth.sign-out');

		Route::get('/auth/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.auth.forgot-password');
		Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.auth.forgot-password.post');

		Route::get('/auth/recover-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
		Route::post('/auth/recover-password', [ResetPasswordController::class, 'reset'])->name('password.update');
	});

	Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin', 'permission:admin@show']], function () {
		Route::get('/', fn() => view('future::pages.admin.index'))->name('admin');
	});
});