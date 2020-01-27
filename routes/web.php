<?php

// ********** Rutas creadas por Laravel ****************
Route::get('/', 'HomeController@index')->name('home');
Route::get('/notification', 'HomeController@markAsRead')
  ->name('markAsRead')
  ->middleware(['only_ajax']);

/* Rutas de Autenticacion */
Auth::routes();

/* Socialite */
Route::get('auth/{driver}', 'Auth\LoginController@redirectToProvider')->name('social_auth');
Route::get('auth/{driver}/callback', 'Auth\LoginController@handleProviderCallback');

Route::group(['middleware' => ['auth']], function ()
{
  /* Home */
  Route::get('/home', 'HomeController@index')
    ->name('home');

  /* Users */
  Route::get('users','UsersController@index')
    ->name('users.index')
    ->middleware(['permission:usuarios:listado']);
  Route::get('users/create','UsersController@create')
    ->name('users.create')
    ->middleware(['permission:usuarios:ver']);
  Route::get('users/{id}','UsersController@show')
    ->where('id', '[0-9]+')
    ->name('users.show')
    ->middleware(['permission:usuarios:ver', 'only_ajax']);
  Route::post('users','UsersController@store')
    ->name('users.store')
    ->middleware(['permission:usuarios:crear', 'only_ajax']);
  Route::get('users/{id}/edit','UsersController@edit')
    ->where('id', '[0-9]+')
    ->name('users.edit', 'only_ajax')
    ->middleware(['permission:usuarios:actualizar']);
  Route::put('users/{id}','UsersController@update')
    ->where('id', '[0-9]+')
    ->name('users.update')
    ->middleware(['permission:usuarios:actualizar', 'only_ajax']);
  Route::delete('users/{id}','UsersController@destroy')
    ->where('id', '[0-9]+')
    ->name('users.destroy')
    ->middleware(['permission:usuarios:eliminar', 'only_ajax']);
  Route::get('/users/export', 'UsersController@export')
    ->name('users.export')
    ->middleware(['permission:usuarios:listado']);

  /* Roles */
  Route::get('roles','RolesController@index')
    ->name('roles.index')
    ->middleware(['permission:roles:listado']);
  Route::get('roles/create','RolesController@create')
    ->name('roles.create')
    ->middleware(['permission:roles:crear']);
  Route::get('roles/{id}','RolesController@show')
    ->where('id', '[0-9]+')
    ->name('roles.show')
    ->middleware(['permission:roles:ver', 'only_ajax']);
  Route::post('roles','RolesController@store')
    ->name('roles.store')
    ->middleware(['permission:roles:crear', 'only_ajax']);
  Route::get('roles/{role}/edit','RolesController@edit')
    ->name('roles.edit')
    ->middleware(['permission:roles:actualizar']);
  Route::put('roles/{id}','RolesController@update')
    ->where('id', '[0-9]+')
    ->name('roles.update')
    ->middleware(['permission:roles:actualizar', 'only_ajax']);
  Route::delete('roles/{role}','RolesController@destroy')
    ->name('roles.destroy')
    ->middleware(['permission:roles:eliminar', 'only_ajax']);

  /*Departments*/
  Route::get('departments','DepartmentsController@index')
    ->name('departments.index')
    ->middleware(['permission:departamentos:listado']);
  Route::get('departments/create','DepartmentsController@create')
    ->name('departments.create')
    ->middleware(['permission:departamentos:crear']);
  Route::get('departments/{id}','DepartmentsController@show')
    ->where('id', '[0-9]+')
    ->name('departments.show')
    ->middleware(['permission:departamentos:ver']);
  Route::post('departments','DepartmentsController@store')
    ->name('departments.store')
    ->middleware(['permission:departamentos:crear', 'only_ajax']);
  Route::get('departments/{id}/edit','DepartmentsController@edit')
    ->where('id', '[0-9]+')
    ->name('departments.edit')
    ->middleware(['permission:departamentos:actualizar']);
  Route::put('departments/{id}','DepartmentsController@update')
    ->where('id', '[0-9]+')
    ->name('departments.update')
    ->middleware(['permission:departamentos:actualizar', 'only_ajax']);
  Route::delete('departments/{id}','DepartmentsController@destroy')
    ->where('id', '[0-9]+')
    ->name('departments.destroy')
    ->middleware(['permission:departamentos:eliminar', 'only_ajax']);
  Route::get('/departments/export', 'DepartmentsController@export')
    ->name('department.export')
    ->middleware(['permission:departamentos:listado']);

  /* Registros */ 
  Route::get('logs','LogsController@index')
    ->name('logs.index')
    ->middleware(['permission:registros:listado']);

  /*Configuracion*/
  Route::get('settings','SettingsController@index')
    ->name('settings.index')
    ->middleware(['permission:configuraciones:listado']);
  Route::post('settings/{id}','SettingsController@update')
    ->name('settings.store')
    ->middleware(['permission:configuraciones:listado', 'only_ajax']);

});