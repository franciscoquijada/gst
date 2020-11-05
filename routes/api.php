<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function (Request $request) {
    return Inspiring::quote();
})->name('api.test');	


/* Api */
Route::middleware(['auth:api'])
  ->name('api.')
  ->group( function ()
{
	Route::get('/test-token', function (Request $request) {
	    return Inspiring::quote();
	})->name('test.token');

	Route::prefix('users')
	  ->name('users.')
	  ->group(function()
	  {
	  	Route::get('/', 'UsersController@list')
	      ->name('list')
	      ->middleware(['permission:usuarios:listado']);
	    Route::get('/{id}','UsersController@show')
	      ->name('show')
	      ->middleware(['permission:usuarios:ver']);
	    Route::post('users','UsersController@store')
	      ->name('store')
	      ->middleware(['permission:usuarios:crear']);
	    Route::get('/{id}/edit','UsersController@edit')
	      ->name('edit')
	      ->middleware(['permission:usuarios:actualizar']);
	    Route::put('/{id}','UsersController@update')
	      ->name('update')
	      ->middleware(['permission:usuarios:actualizar']);
	    Route::delete('/{id}','UsersController@destroy')
	      ->name('destroy')
	      ->middleware(['permission:usuarios:eliminar']);
	  });

});