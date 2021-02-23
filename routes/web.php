<?php

/* Rutas de Autenticacion */
Auth::routes(['register' => false]);

/* Socialite */
Route::get('auth/{driver}', 'Auth\SocialAuthController@redirectToProvider')
  ->name('social_auth');
Route::get('auth/{driver}/callback', 'Auth\SocialAuthController@handleProviderCallback');

/* Ajax */
Route::prefix('ajax')
  ->middleware(['auth', 'only_ajax'])
  ->name('ajax.')
  ->group( function ()
{
  Route::match(['get', 'post'], 'locations','AjaxController@get_locations')
    ->name('locations');
  Route::match(['get', 'post'], 'country','AjaxController@get_country')
    ->name('country');
  Route::match(['get', 'post'], 'notification', 'AjaxController@mark_as_read')
    ->name('mark_as_read');
  Route::match(['get', 'post'], 'token', 'AjaxController@generate_token')
    ->name('generate_token');
});

Route::group(['middleware' => ['auth']], function ()
{
  /* Home */
  Route::get('/', 'HomeController@index')
    ->name('home');

  /* Users */
  Route::prefix('users')
  ->name('users.')
  ->group(function()
  {
    Route::get('/','UsersController@index')
      ->name('index')
      ->middleware(['permission:usuarios:listado']);
    Route::get('create','UsersController@create')
      ->name('create')
      ->middleware(['permission:usuarios:ver']);
    Route::get('/exports', 'UsersController@export')
      ->name('export')
      ->middleware(['permission:usuarios:listado']);
  });

  Route::prefix('profile')
  ->name('profile.')
  ->group(function()
  {
    Route::get('/','UsersController@profile')->name('show');
    Route::post('/','UsersController@update_profile')->name('update');
  });

  /* Roles */
  Route::prefix('roles')
  ->name('roles.')
  ->group(function()
  {
    Route::get('/','RolesController@index')
      ->name('index')
      ->middleware(['permission:roles:listado']);
    Route::get('create','RolesController@create')
      ->name('create')
      ->middleware(['permission:roles:crear']);
    Route::get('{id}','RolesController@show')
      ->name('show')
      ->middleware(['permission:roles:ver', 'only_ajax']);
    Route::post('roles','RolesController@store')
      ->name('store')
      ->middleware(['permission:roles:crear', 'only_ajax']);
    Route::get('{role}/edit','RolesController@edit')
      ->name('edit')
      ->middleware(['permission:roles:actualizar']);
    Route::put('{id}','RolesController@update')
      ->name('update')
      ->middleware(['permission:roles:actualizar', 'only_ajax']);
    Route::delete('{role}','RolesController@destroy')
      ->name('destroy')
      ->middleware(['permission:roles:eliminar', 'only_ajax']);
  });

  /*Tipos de identificacion*/
  Route::prefix('identifications/types')
  ->name('id_types.')
  ->group(function()
  {
    Route::get('/','IdentificationsTypesController@index')
      ->name('index')
      ->middleware(['permission:tipos identificadores:listado']);
    Route::get('create','IdentificationsTypesController@create')
      ->name('create')
      ->middleware(['permission:tipos identificadores:crear']);
    Route::get('/{id}','IdentificationsTypesController@show')
      ->name('show')
      ->middleware(['permission:tipos identificadores:ver']);
    Route::post('types','IdentificationsTypesController@store')
      ->name('store')
      ->middleware(['permission:tipos identificadores:crear', 'only_ajax']);
    Route::get('/{id}/edit','IdentificationsTypesController@edit')
      ->name('edit')
      ->middleware(['permission:tipos identificadores:actualizar']);
    Route::put('/{id}','IdentificationsTypesController@update')
      ->name('update')
      ->middleware(['permission:tipos identificadores:actualizar', 'only_ajax']);
    Route::delete('/{id}','IdentificationsTypesController@destroy')
      ->name('destroy')
      ->middleware(['permission:tipos identificadores:eliminar', 'only_ajax']);
    Route::get('export', 'IdentificationsTypesController@export')
      ->name('export')
      ->middleware(['permission:tipos identificadores:listado']);
  });

  /*Grupos*/
  Route::prefix('groups')
  ->name('groups.')
  ->group(function()
  {
    Route::get('/','GroupsController@index')
      ->name('index')
      ->middleware(['permission:grupos:listado']);

    Route::get('export', 'GroupsController@export')
      ->name('export')
      ->middleware(['permission:grupos:listado']);
  });

  /* Registros */
  Route::get('logs','LogsController@index')
    ->name('logs.index')
    ->middleware(['permission:registros:listado']);

  /*Configuracion*/
  Route::prefix('settings')
  ->name('settings.')
  ->group(function()
  {
    Route::get('/','SettingsController@index')
      ->name('index')
      ->middleware(['permission:configuraciones:listado']);
    Route::post('{id}','SettingsController@update')
      ->name('store')
      ->middleware(['permission:configuraciones:listado', 'only_ajax']);
  });
});
