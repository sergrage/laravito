<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

Route::get('/ajax/regions', 'Ajax\RegisterController@get')->name('ajax.regions');

// namespace - 'Cabinet/HomeController@index'
// prefix  -/cabinet
//as  --- name('cabinet.home')


Route::group(
	[
		'prefix' => 'cabinet',
		'as' => 'cabinet.',
		'namespace' => 'Cabinet',
		'middleware' => ['auth'],
	],
	function(){
		Route::get('/', 'HomeController@index')->name('home');
		Route::get('/profile', 'ProfileController@index')->name('profile.home');
		Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
		Route::put('/profile/update', 'ProfileController@update')->name('profile.update');

		Route::resource('adverts', 'Adverts\AdvertsController');
	});


Route::group(
	[
		'prefix' => 'admin',
		'as' => 'admin.',
		'namespace' => 'Admin',
		'middleware' => ['auth', 'can:admin-panel'],
	],
	function(){
		Route::get('/', 'HomeController@index')->name('home');
		Route::resource('regions', 'RegionController');
		Route::resource('users', 'UsersController');

		Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');


        Route::group(['prefix' => 'adverts', 'as' => 'adverts.', 'namespace' => 'Adverts'], function () {
            Route::resource('categories', 'CategoryController');

            Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
                Route::post('/first', 'CategoryController@first')->name('first');
                Route::post('/up', 'CategoryController@up')->name('up');
                Route::post('/down', 'CategoryController@down')->name('down');
                Route::post('/last', 'CategoryController@last')->name('last');
                Route::resource('attributes', 'AttributeController')->except('index');
            });
	});
	}
);