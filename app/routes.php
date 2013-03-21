<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::controller('user', 'UserController');

Route::resource('groups', 'GroupController');


Route::filter('auth', function()
{
	if (!Sentry::check()) return Redirect::to('user/login');
});

Route::filter('admin_auth', function()
{
	if (!Sentry::check())
	{
		// if not logged in, redirect to login
		return Redirect::to('user/login');
	}

	if (!Sentry::getUser()->hasAccess('admin'))
	{
		// has no access
		return Response::make('Access Forbidden', '403');
	}
});

