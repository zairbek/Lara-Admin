<?php

use Future\LaraAdmin\Http\Controllers\Auth\ForgotPasswordController;
use Future\LaraAdmin\Http\Controllers\Auth\ResetPasswordController;
use Future\LaraAdmin\Http\Controllers\Auth\SignInController;
use Future\LaraAdmin\Http\Controllers\IndexController;
use Future\LaraAdmin\Http\Controllers\Permissions\PermissionsController;
use Future\LaraAdmin\Http\Controllers\Roles\RolesController;
use Future\LaraAdmin\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'web'], function () {
	# USERS SIDE
	Route::get('/', IndexController::class)->name('index');


	# ADMIN
	Route::group(['prefix' => 'admin'], function () {
		# AUTH
		Route::get('/auth/sign-in', [SignInController::class, 'showForm'])->name('admin.auth.sign-in');
		Route::post('/auth/sign-in', [SignInController::class, 'signIn'])->name('admin.auth.sign-in.post');
		Route::get('/auth/sign-out', [SignInController::class, 'signOut'])->name('admin.auth.sign-out');

		Route::get('/auth/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.auth.forgot-password');
		Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.auth.forgot-password.post');

		Route::get('/auth/recover-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
		Route::post('/auth/recover-password', [ResetPasswordController::class, 'reset'])->name('password.update');

		# FOR AUTHORIZED USERS
		Route::group(['middleware' => ['auth.admin', 'permission:admin@show']], function () {
			Route::get('/', fn() => view('future::pages.admin.index'))->name('admin');

			# SETTINGS
			Route::group(['prefix' => 'settings'], function () {
				Route::resource('users', UsersController::class)->names('future.pages.settings.users');
				Route::put('users/{user}/avatar', [UsersController::class, 'avatarUpdate'])->name('future.pages.settings.users.avatar.update');

				Route::resource('roles', RolesController::class)->names('future.pages.settings.roles');
				Route::resource('permissions', PermissionsController::class)->names('future.pages.settings.permissions')->except('destroy');
			});
		});
	});
});