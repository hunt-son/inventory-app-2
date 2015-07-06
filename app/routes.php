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
    return View::make('dashboard/index');
})->before('auth');

Route::resource('records','RecordsController');
Route::resource('users','UsersController');
Route::resource('products', 'ProductsController');
Route::resource('Dashboard', 'DashboardsController');

Route::get('login','UsersController@create');
Route::get('logout','UsersController@destroy');