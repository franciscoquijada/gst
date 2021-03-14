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

/* Test Connections */
Route::prefix('test')
    ->group(function()
    {
        Route::get('/', function (Request $request) {
            return Inspiring::quote();
        });
    });


/* Api */
Route::middleware(['auth:api'])
  ->name('api.')
  ->group( function ()
{
	Route::get('/test-token', function (Request $request) {
	    return Inspiring::quote();
	})->name('test.token');

  /* Compañias */
  Route::prefix('companies')
    ->name('companies.')
    ->group(function()
    {
      Route::get('/list','CompaniesController@list')
        ->name('list')
        ->middleware(['permission:companias:listado']);

      Route::post('/','CompaniesController@store')
        ->name('store')
        ->middleware(['permission:companias:crear']);

      Route::get('/{id}/edit','CompaniesController@edit')
        ->name('edit')
        ->middleware(['permission:companias:actualizar']);

      Route::put('/{id}','CompaniesController@update')
        ->name('update')
        ->middleware(['permission:companias:actualizar']);
      Route::delete('/{id}','CompaniesController@destroy')
        ->name('destroy')
        ->middleware(['permission:companias:eliminar']);
      Route::delete('/{id}','CompaniesController@destroy')
        ->name('destroy')
        ->middleware(['permission:companias:eliminar']);
    });


    /* User */
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

      Route::post('/','UsersController@store')
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

  /*Tipos de identificacion*/
  Route::prefix('identifications/types')
    ->name('id_types.')
    ->group(function()
    {
      Route::get('/','IdentificationsTypesController@list')
        ->name('list')
        ->middleware(['permission:tipos identificadores:listado']);
      
      Route::get('/{id}','IdentificationsTypesController@show')
        ->name('show')
        ->middleware(['permission:tipos identificadores:ver']);

      Route::post('/','IdentificationsTypesController@store')
        ->name('store')
        ->middleware(['permission:tipos identificadores:crear']);

      Route::get('/{id}/edit','IdentificationsTypesController@edit')
        ->name('edit')
        ->middleware(['permission:tipos identificadores:actualizar']);

      Route::put('/{id}','IdentificationsTypesController@update')
        ->name('update')
        ->middleware(['permission:tipos identificadores:actualizar']);

      Route::delete('/{id}','IdentificationsTypesController@destroy')
        ->name('destroy')
        ->middleware(['permission:tipos identificadores:eliminar']);
    });

  /* Metadata */
  Route::prefix('metadata')
    ->name('metadata.')
    ->group( function()
    {
      Route::get('/','MetasController@list')
        ->name('list')
        ->middleware(['permission:metadata:listado']);
      
      Route::get('/{id}','MetasController@show')
        ->name('show')
        ->middleware(['permission:metadata:ver']);

      Route::post('/','MetasController@store')
        ->name('store')
        ->middleware(['permission:metadata:crear']);

      Route::get('/{id}/edit','MetasController@edit')
        ->name('edit')
        ->middleware(['permission:metadata:actualizar']);

      Route::put('/{id}','MetasController@update')
        ->name('update')
        ->middleware(['permission:metadata:actualizar']);

      Route::delete('/{id}','MetasController@destroy')
        ->name('destroy')
        ->middleware(['permission:metadata:eliminar']);
    });

  /* Registros */
  Route::get('logs','LogsController@list')
    ->name('logs.list')
    ->middleware(['permission:registros:listado']);

  /* Roles */
  Route::prefix('roles')
    ->name('roles.')
    ->group(function()
    {
      Route::get('/','RolesController@list')
        ->name('list')
        ->middleware(['permission:roles:listado']);

      Route::get('{id}','RolesController@show')
        ->name('show')
        ->middleware(['permission:roles:ver']);

      Route::post('/','RolesController@store')
        ->name('store')
        ->middleware(['permission:roles:crear']);

      Route::get('{role}/edit','RolesController@edit')
        ->name('edit')
        ->middleware(['permission:roles:actualizar']);

      Route::put('{id}','RolesController@update')
        ->name('update')
        ->middleware(['permission:roles:actualizar']);
        
      Route::delete('{role}','RolesController@destroy')
        ->name('destroy')
        ->middleware(['permission:roles:eliminar']);
    });

});