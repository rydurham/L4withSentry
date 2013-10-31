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


Route::get('login', 'SessionController@create');


// Route::get('logout', 'SessionController@destroy');
// Route::resource('users', 'UserController');


Route::resource('sessions', 'SessionController', array('only' => array('create', 'store', 'destroy')));

// oute::resource('groups', 'GroupController');

Route::get('/', function()
{
	return View::make('home');
});


Route::get('/home', function()
{
	return View::make('home');
});

// App::missing(function($exception)
// {
//     App::abort(404, 'Page not found');
//     //return Response::view('errors.missing', array(), 404);
// });





