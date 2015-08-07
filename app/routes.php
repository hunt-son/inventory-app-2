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

if( !Auth::check() )
{
    Route::get('/', 'SessionsController@create');
}
else Route::get('/','DashboardsController@index');


Route::get('registration', function()
{
    $user = Auth::getUser();
    if (! $user->hasRole('Owner'))
    {
        return Reditect::back()->with('flash_message', 'You need to be an Owner to register a user.');
    }
    return View::make('registration.create');
});

Route::get('help', function() {
    return View::make('help.index');
});



Route::resource('records','RecordsController');
Route::resource('users','UsersController');

Route::resource('products', 'ProductsController');

Route::resource('Dashboard', 'DashboardsController');

Route::resource('daily', 'DailyController');
Route::resource('sessions', 'SessionsController', ['only' => ['store', 'create', 'destroy']]);
Route::resource('password_resets','PasswordResetsController');

Route::resource('manufacturers', 'ManufacturersController');

Route::get('login','SessionsController@create');
Route::get('logout','SessionsController@destroy');
Route::post('role', 'UsersController@controlRole');