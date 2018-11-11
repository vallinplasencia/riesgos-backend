# RiesgosBackend
 RiesgosBackend es el proyecto que consta de una API para gestionar los riesgos de los equipos tecnologicos de una empresa.


## Tecnologia
* [Laravel 5.7](https://laravel.com/)

## Instalacion

### Clonado el repo
``` bash
# clonando el repositorio
$ git clone https://github.com/vallinplasencia/riesgos-backend.git riesgos-backend

# Navedando al directorio del proyecto
$ cd riesgos-backend

# Instalando las dependencias del proyecto
$ composer install

# Generando App Key
$ php artisan key:generate

# Crear solamente la BD
## Entras a la consola de mysql con el usuario y clave correspndiente
$ mysql -u nombUsuario -p
## Creas la bd
$> CREATE DATABASE xxxx CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Migrando la BD y poblandola con datos de prueba(Creando tablas y sus datos de prueba)
$ php artisan migrate --seed

# Tambien se puede utilizar el comando....
$ php artisan migrate:fresh --seed
```

## Forma para correr el proyecto.

Monatarlo en un servidor WEB y visitar [riesgos-backend.mii](http://riesgos-backend.mii)

### Requisitos del servidor.
El servidor debe cumplir con los requisitos q obliga Laravel a que tenga el servidor.
[Requisitos del proyecto](https://laravel.com/docs/5.7)

Lo ideal para el desarrollo seria montar el proyecto en un virtual host aqui esta la configuracion para este VirtualHost.

``` bash
<VirtualHost *:80>
	ServerName riesgos-backend.mii
	ServerAlias www.riesgos-backend.mii
	DocumentRoot "\Directorio\del\proyecto\public"
	DirectoryIndex index.php

	#ErrorLog "logs/riesgos-backend.mii-error.log"
    #CustomLog "logs/riesgos-backend.mii-access.log" common

	#php_flag log_errors on
    #php_flag display_errors off
    #php_value error_reporting 2147483647
    #php_value error_log "logs\php_errors.log"

	<Directory "\Directorio\del\proyecto\public">
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
```
Se deberia poner como nombre del servidor riesgos-backend.mii para que funcione todo.
Esto es porque este proyecto es una API rest q se gestiona con [riesgos-frontend](https://github.com/vallinplasencia/riesgos-frontend.git).
Con el objetivo de verificarlo(este proyecto) le integre la parte del Frontend  y esta carga los datos como si el proyecto estuviera montado en el dominio http://riesgos-backend.mii.

Recordar que para correr el proyecto LOCALMENTE en la url [riesgos-backend.mii](http://riesgos-backend.mii) hay q editar el archivo hosts del sistema operativo.

Todo Listo. Ahora navegar a [riesgos-backend.mii](http://riesgos-backend.mii)

## LICENSE

Esta aplicacion está bajo licencia [MIT license](https://opensource.org/licenses/MIT).

## ***************** MAS DATOS INTERESANTES *****************

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
