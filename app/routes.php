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
	if(Sentry::check()) {
		$user = Sentry::getUser();
		return View::make('hello', compact('user'));
	} 
	return View::make('hello');
});

Route::controller('signin', 'AuthController');

Route::resource('wishlists', 'WishlistsController');
Route::resource('user', 'UsersController');
Route::resource('wishes', 'WishesController');

Route::get('register', 'UsersController@register');
Route::get('settings', 'UsersController@settings');
Route::get('changeCover', 'UsersController@showChangeCover');
Route::post('changeCover', 'UsersController@changeCover');
Route::get('changeUrl', 'UsersController@showChangeUrl');
Route::post('changeUrl', 'UsersController@changeProfileUrl');
Route::get('reset', 'UsersController@showPasswordReset');
Route::post('reset', 'UsersController@requestPasswordReset');
Route::get('a/{activationCode}', 'UsersController@activateUser');
Route::get('r/{resetCode}', 'UsersController@resetPassword');
Route::get('changeWishlistImage/{wishlistid}', 'WishlistsController@changeImage');
Route::get('changeWishImage/{wishId}', 'WishesController@changeImage');
Route::get('changeProfilePicture', 'UsersController@changeProfilePic');
Route::get('{slug}', 'WishlistsController@index');
Route::get('{slug}/{wishlistSlug}', 'WishlistsController@show');
Route::get('wishes/create/{wishlistid}', 'WishesController@create');

// Event::listen('illuminate.query', function($sql)
// {
//     var_dump($sql);
// }); 