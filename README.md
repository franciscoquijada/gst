# Sistema de gestión

_Sistema de gestión base_

### Pre-requisitos

_Php 7.2 o superior_

### Instalación

* Script instalacion **php -r "file_exists('.env') || copy('.env.example', '.env');"**
* Configurar entorno archivo **.env**
* Ejecutar las migraciones **composer install && php artisan key:generate && php artisan storage:link && chmod -R 777 storage bootstrap/cache && php artisan passport:install && php artisan migrate --seed**

### Adicionales

* (Opcional) MongoDB para los logs: configurar controlador y ejecutar **composer require "mongodb/mongodb" && composer require "jenssegers/mongodb"**

## Construido con 

* [Laravel](https://laravel.com/) - El framework web usado
* [DataTable](https://datatables.net/) - Manejo de Tablas HTML
* [Vue.js](https://vuejs.org/) - Para realizar peticiones via Ajax
* [Bootstrap](https://getbootstrap.com/) - Usado para el frontend
* [SB Admin 2](https://startbootstrap.com/themes/sb-admin-2/) - Usado para el dashboard
* [Laravel-Socialite](https://laravel.com/docs/5.7/socialite) - Para acceder con redes sociales
* [Laravel-permissions](https://github.com/spatie/laravel-permission) - Para el manejo de roles y permisos


## Autor ✒️
* **LPinto** *
