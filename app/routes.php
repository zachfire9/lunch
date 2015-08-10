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

// Route::get('/user', function()
// {
// 	return 'Hello World';
// });


Route::resource('/user', 'UserController');
Route::post('user/search', 'UserController@search');
Route::get('user/add_friend/{id}', 'UserController@add_friend');
Route::delete('user/remove_friend/{id}', 'UserController@remove_friend');
Route::resource('/lunch', 'LunchController');
Route::resource('/restaurant', 'RestaurantController');
Route::controller('/', 'HomeController');