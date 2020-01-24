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
    ->middleware(['permission:listado de usuarios']);
  Route::get('users/create','UsersController@create')
    ->name('users.create')
    ->middleware(['permission:crear usuario']);
  Route::get('users/{id}','UsersController@show')
    ->where('id', '[0-9]+')
    ->name('users.show')
    ->middleware(['permission:ver usuario', 'only_ajax']);
  Route::post('users','UsersController@store')
    ->name('users.store')
    ->middleware(['permission:crear usuario', 'only_ajax']);
  Route::get('users/{id}/edit','UsersController@edit')
    ->where('id', '[0-9]+')
    ->name('users.edit', 'only_ajax')
    ->middleware(['permission:actualizar usuario']);
  Route::put('users/{id}','UsersController@update')
    ->where('id', '[0-9]+')
    ->name('users.update')
    ->middleware(['permission:actualizar usuario', 'only_ajax']);
  Route::delete('users/{id}','UsersController@destroy')
    ->where('id', '[0-9]+')
    ->name('users.destroy')
    ->middleware(['permission:eliminar usuario', 'only_ajax']);
  Route::get('/users/export', 'UsersController@export')
    ->name('users.export')
    ->middleware(['permission:listado de usuarios']);

  /* Roles */
  Route::get('roles','RolesController@index')
    ->name('roles.index')
    ->middleware(['permission:listado de roles']);
  Route::get('roles/create','RolesController@create')
    ->name('roles.create')
    ->middleware(['permission:crear rol']);
  Route::get('roles/{id}','RolesController@show')
    ->where('id', '[0-9]+')
    ->name('roles.show')
    ->middleware(['permission:ver rol', 'only_ajax']);
  Route::post('roles','RolesController@store')
    ->name('roles.store')
    ->middleware(['permission:crear rol', 'only_ajax']);
  Route::get('roles/{role}/edit','RolesController@edit')
    ->name('roles.edit')
    ->middleware(['permission:actualizar rol']);
  Route::put('roles/{id}','RolesController@update')
    ->where('id', '[0-9]+')
    ->name('roles.update')
    ->middleware(['permission:actualizar rol', 'only_ajax']);
  Route::delete('roles/{role}','RolesController@destroy')
    ->name('roles.destroy')
    ->middleware(['permission:eliminar rol', 'only_ajax']);

  /*Departments*/
  Route::get('departments','DepartmentsController@index')
    ->name('departments.index')
    ->middleware(['permission:listado de departamentos']);
  Route::get('departments/create','DepartmentsController@create')
    ->name('departments.create')
    ->middleware(['permission:crear departamento']);
  Route::get('departments/{id}','DepartmentsController@show')
    ->where('id', '[0-9]+')
    ->name('departments.show')
    ->middleware(['permission:ver departamento']);
  Route::post('departments','DepartmentsController@store')
    ->name('departments.store')
    ->middleware(['permission:crear departamento', 'only_ajax']);
  Route::get('departments/{id}/edit','DepartmentsController@edit')
    ->where('id', '[0-9]+')
    ->name('departments.edit')
    ->middleware(['permission:actualizar departamento']);
  Route::put('departments/{id}','DepartmentsController@update')
    ->where('id', '[0-9]+')
    ->name('departments.update')
    ->middleware(['permission:actualizar departamento', 'only_ajax']);
  Route::delete('departments/{id}','DepartmentsController@destroy')
    ->where('id', '[0-9]+')
    ->name('departments.destroy')
    ->middleware(['permission:eliminar departamento', 'only_ajax']);
  Route::get('/departments/export', 'DepartmentsController@export')
    ->name('department.export');

  /* Registros */ 
  Route::get('logs','LogsController@index')
    ->name('logs.index')
    ->middleware(['permission:auditoria']);

  /*Configuracion*/
  Route::get('settings','SettingsController@index')
    ->name('settings.index')
    ->middleware(['permission:configuracion empresa']);
  Route::post('settings/{id}','SettingsController@update')
    ->name('settings.store')
    ->middleware(['permission:configuracion empresa', 'only_ajax']);

});