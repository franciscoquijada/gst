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
/*
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});*/


Route::group([
    'middleware' => 'api|web'
], function ($router) {

    /* Grupos */
    Route::prefix('groups')
        ->name('groups.')
        ->group(function()
        {
            /*Route::get('/list','GroupsController@list')
                ->name('list');
            // ->middleware(['permission:grupos:listado'])*/

            Route::post('groups','GroupsController@store')
                ->name('store')
                ->middleware(['permission:grupos:crear', 'only_ajax']);

            Route::get('/{id}/edit','GroupsController@edit')
                ->name('edit')
                ->middleware(['permission:grupos:actualizar']);

            Route::put('/{id}','GroupsController@update')
                ->name('update')
                ->middleware(['permission:grupos:actualizar', 'only_ajax']);
            Route::delete('/{id}','GroupsController@destroy')
                ->name('destroy')
                ->middleware(['permission:grupos:eliminar', 'only_ajax']);
            Route::delete('/{id}','GroupsController@destroy')
                ->name('destroy')
                ->middleware(['permission:grupos:eliminar', 'only_ajax']);
        });

    });



/* Test Connections */
Route::prefix('test')
    ->group(function()
    {
        Route::get('/', function (Request $request) {
            return Inspiring::quote();
        });

        Route::middleware('auth:api')
            ->get('/token', function (Request $request) {
            return Inspiring::quote();
        });
    });





/*

Route::get('/test', function (Request $request) {
    return Inspiring::quote();
})->name('api.test');	
*/

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
