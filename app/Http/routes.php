<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'clear-view-cache'], function() {
	Route::get('/', function () {
		return view('app');
	});

	Route::get('home', function () {
		return view('home');
	});

	Route::post('oauth/access_token', function () {
		return Response::json(Authorizer::issueAccessToken());
	});

	Route::group(['prefix' => 'auth'], function () {
		// Authentication routes...
		Route::get('login', 'Auth\AuthController@getLogin');
		Route::post('login', 'Auth\AuthController@postLogin');
		Route::get('logout', 'Auth\AuthController@getLogout');

		// Registration routes...
		Route::get('register', 'Auth\AuthController@getRegister');
		Route::post('register', 'Auth\AuthController@postRegister');
	});

	Route::group(['prefix' => 'password'], function () {
		// Password reset link request routes...
		Route::get('email', 'Auth\PasswordController@getEmail');
		Route::post('email', 'Auth\PasswordController@postEmail');

		// Password reset routes...
		Route::get('reset/{token}', 'Auth\PasswordController@getReset');
		Route::post('reset', 'Auth\PasswordController@postReset');
	});

	Route::group(['middleware' => 'oauth'], function () {
		Route::group(['prefix' => 'user'], function() {
			Route::get('/', 'UserController@show');
			Route::get('/index', 'UserController@index');
			Route::get('authenticated', 'UserController@show');
		});

		Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);

		Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);

		Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);

		Route::group(['prefix' => 'project', 'middleware' => 'check-project-permission'], function () {
			Route::get('{id}/note', 'ProjectNoteController@index');
			Route::post('{id}/note', 'ProjectNoteController@store');
			Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
			Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
			Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');

			Route::get('{id}/file', 'ProjectFileController@index');
			Route::get('{id}/file/{fileId}', 'ProjectFileController@show');
			Route::get('{id}/file/{fileId}/download', 'ProjectFileController@download');
			Route::post('{id}/file', 'ProjectFileController@store');
			Route::put('{id}/file/{fileId}', 'ProjectFileController@update');
			Route::delete('{id}/file/{fileId}', 'ProjectFileController@destroy');

			Route::get('{id}/task', 'ProjectTaskController@index');
			Route::post('{id}/task', 'ProjectTaskController@store');
			Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
			Route::put('{id}/task/{taskId}', 'ProjectTaskController@update');
			Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');

			Route::get('{id}/member', 'ProjectMemberController@index');
			Route::post('{id}/member', 'ProjectMemberController@store');
			Route::get('{id}/member/{memberId}', 'ProjectMemberController@show');
			Route::put('{id}/member/{memberId}', 'ProjectMemberController@update');
			Route::delete('{id}/member/{memberId}', 'ProjectMemberController@destroy');
		});
	});
});
