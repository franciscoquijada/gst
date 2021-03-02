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

    Route::get('/exports', 'UsersController@export')
      ->name('export')
      ->middleware(['permission:usuarios:listado']);
  });

  /* Users - Profile */
  Route::prefix('profile')
  ->name('profile.')
  ->group(function()
  {
    Route::get('/','UsersController@profile')
      ->name('show');
      
    Route::post('/','UsersController@update_profile')
      ->name('update');
  });

  /*Tipos de identificacion*/
  Route::prefix('identifications/types')
  ->name('id_types.')
  ->group(function()
  {
    Route::get('/','IdentificationsTypesController@index')
      ->name('index')
      ->middleware(['permission:tipos identificadores:listado']);

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

  /* Roles */
  Route::get('roles','RolesController@index')
    ->name('roles.index')
    ->middleware(['permission:roles:listado']);

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
