# Sistema de gestión

_Sistema de gestión base_

### Pre-requisitos

_Docker_

Crear alias 
`alias dcli='docker-compose -f docker-compose.cli.yml run --rm'`

### Instalación

* Levantar el contenedor **docker-compose up -d**
* Script instalacion **dcli composer install**
* Ejecutar las migraciones **dcli artisan migrate --seed && dcli artisan module:migrate --seed**

### Instalación

* Usuario **admin@admin.cl**
* Pass **admin**

## Construido con 

* [Docker](https://www.docker.com/) - Manejador de contenedores
* [Laravel](https://laravel.com/) - El framework web usado
* [DataTable](https://datatables.net/) - Manejo de Tablas HTML
* [Vue.js](https://vuejs.org/) - Para realizar peticiones via Ajax
* [Bootstrap](https://getbootstrap.com/) - Usado para el frontend
* [SB Admin 2](https://startbootstrap.com/themes/sb-admin-2/) - Usado para el dashboard
* [Laravel-Socialite](https://laravel.com/docs/5.7/socialite) - Para acceder con redes sociales
* [Laravel-permissions](https://github.com/spatie/laravel-permission) - Para el manejo de roles y permisos

## Autor ✒️
* **LPinto** *
