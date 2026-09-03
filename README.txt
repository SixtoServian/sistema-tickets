Guía práctica Sistema de tickets de programacion 4 UTN
Tema: Roles y Permisos en PHP con Laravel 13
Alumno: Sixto Servian

Introducción
    Desarrollar un sistema de tickets en Laravel 13 donde existan los roles Administrador, Supervisor y Usuario.
Cada rol deberá poseer diferentes permisos. El sistema deberá impedir tanto desde la interfaz como desde las rutas
y controladores que un usuario realice acciones para las cuales no posee autorización.

Utilizaremos:
    Laravel 13.
    PHP 8.3 o superior.
    MySQL.
    Blade / Livewire.
    Starter Kit oficial de Laravel.
    Spatie Laravel Permission.
    Tailwind CSS / Flux UI.
    Composer.
    Node.js y NPM.

El sistema tendrá tres roles:
    Rol:
    Funciones:
        AdministradorCrear, visualizar, editar y cerrar tickets. Gestionar usuarios.
        SupervisorCrear, visualizar, editar y cerrar tickets.
        UsuarioCrear y visualizar tickets.

Los permisos serán:
●​ crear tickets
●​ ver tickets
●​ editar tickets
●​ cerrar tickets
●​ gestionar usuariosLa aplicación se desarrollará en cuatro etapas.

    ETAPA 1 — Crear Laravel 13 y configurar autenticación
    Objetivo - Al finalizar esta etapa tendremos:
Base de datos configurada.
Starter Kit funcionando.
Registro de usuarios.
Inicio de sesión.
Cierre de sesión.
Dashboard protegido.

    1. Verificar requisitos
    Antes de comenzar comprobamos PHP:
php -v
Composer:
composer -V
Node:
node -v
NPM:
npm -v
    También podemos verificar el instalador de Laravel:laravel --version
Si Laravel Installer no está instalado:
composer global require laravel/installer
2. Crear el proyecto
Desde la carpeta donde almacenaremos nuestros proyectos:
laravel new sistema-tickets
El instalador preguntará qué Starter Kit queremos utilizar.
Seleccionamos:
Livewire
Cuando pregunte por autenticación seleccionamos la opción estándar de Laravel.
Para base de datos podemos seleccionar:
MySQL
Entramos al proyecto:
cd sistema-tickets
3. Instalar dependencias frontend
Ejecutamos:
npm installLuego:
npm run build
4. Crear la base de datos
Desde MySQL, phpMyAdmin, HeidiSQL o MySQL Workbench creamos:
CREATE DATABASE sistema_tickets;
5. Configurar .env
Abrimos:
.env
Buscamos:
DB_CONNECTION=mysql
Configuramos:
DB_CONNECTION=mysql​
DB_HOST=127.0.0.1​
DB_PORT=3306​
DB_DATABASE=sistema_tickets​
DB_USERNAME=root​
DB_PASSWORD=
La contraseña dependerá de nuestra instalación de MySQL.6. Ejecutar migraciones
php artisan migrate
Laravel creará las tablas necesarias, entre ellas:
users​
password_reset_tokens​
sessions​
cache​
jobs
7. Ejecutar el proyecto
Podemos utilizar:
composer run dev
O simplemente:
php artisan serve
Si utilizamos php artisan serve, normalmente podremos ingresar a:
http://127.0.0.1:8000
8. Probar registro
Ingresamos a la opción:
Register
Creamos un usuario.
Por ejemplo:Nombre: Juan Perez
Email: juan@test.com
Password: 12345678
Luego iniciamos sesión.
Verificación de la etapa 1
Antes de continuar debemos comprobar:
●​
●​
●​
●​
●​
●​
Laravel inicia correctamente.
La base de datos funciona.
Podemos registrar usuarios.
Podemos iniciar sesión.
Podemos cerrar sesión.
Existe un Dashboard protegido.
Si todo funciona podemos continuar.
ETAPA 2 — Implementar Roles y
Permisos
Objetivo
En esta etapa incorporaremos:
●​
●​
●​
●​
●​
●​
Spatie Laravel Permission.
Roles.
Permisos.
Usuarios de prueba.
Asignación de permisos a roles.
Asignación de roles a usuarios.
La documentación actual de Spatie indica instalar el paquete mediante Composer, publicar
sus migraciones/configuración, limpiar caché y ejecutar las migraciones.1. Instalar Spatie Permission
Ejecutamos:
composer require spatie/laravel-permission
2. Publicar configuración y migraciones
php artisan vendor:publish
--provider="Spatie\Permission\PermissionServiceProvider"
Esto generará:
config/permission.php
y una migración para las tablas de roles y permisos.
3. Limpiar caché
php artisan optimize:clear
4. Ejecutar las migraciones
php artisan migrate
Ahora tendremos tablas similares a:
roles
permissions
model_has_roles
model_has_permissions
role_has_permissions5. Modificar el modelo User
Abrimos:
app/Models/User.php
Agregamos:
use Spatie\Permission\Traits\HasRoles;
Luego agregamos el trait dentro de la clase.
Por ejemplo:
<?php​
​
namespace App\Models;​
​
use Illuminate\Database\Eloquent\Factories\HasFactory;​
use Illuminate\Foundation\Auth\User as Authenticatable;​
use Illuminate\Notifications\Notifiable;​
use Spatie\Permission\Traits\HasRoles;​
​
class User extends Authenticatable​
{​
use HasFactory, Notifiable, HasRoles;​
​
protected $fillable = [​
'name',​
'email',​
'password',​
];​
​
protected $hidden = [​
'password',​
'remember_token',​
];​
}Spatie requiere incorporar HasRoles al modelo que recibirá roles y permisos.
6. Crear un Seeder
Ejecutamos:
php artisan make:seeder RolesAndPermissionsSeeder
Se creará:
database/seeders/RolesAndPermissionsSeeder.php
7. Crear permisos y roles
Modificamos el archivo:
<?php​
​
namespace Database\Seeders;​
​
use Illuminate\Database\Seeder;​
use Spatie\Permission\Models\Permission;​
use Spatie\Permission\Models\Role;​
use Spatie\Permission\PermissionRegistrar;​
​
class RolesAndPermissionsSeeder extends Seeder​
{​
public function run(): void​
{​
app()[PermissionRegistrar::class]​
->forgetCachedPermissions();​
​
// -------------------------​
// PERMISOS​
// -------------------------​
​
$crear = Permission::firstOrCreate([​'name' => 'crear tickets'​
]);​
​
$ver = Permission::firstOrCreate([​
'name' => 'ver tickets'​
]);​
​
$editar = Permission::firstOrCreate([​
'name' => 'editar tickets'​
]);​
​
$cerrar = Permission::firstOrCreate([​
'name' => 'cerrar tickets'​
]);​
​
$gestionarUsuarios = Permission::firstOrCreate([​
'name' => 'gestionar usuarios'​
]);​
​
// -------------------------​
// ROLES​
// -------------------------​
​
$admin = Role::firstOrCreate([​
'name' => 'admin'​
]);​
​
$supervisor = Role::firstOrCreate([​
'name' => 'supervisor'​
]);​
​
$usuario = Role::firstOrCreate([​
'name' => 'usuario'​
]);​
​
// -------------------------​
// PERMISOS DEL ADMIN​
// -------------------------​
​
$admin->syncPermissions([​
$crear,​
$ver,​
$editar,​$cerrar,​
$gestionarUsuarios,​
]);​
​
// -------------------------​
// PERMISOS DEL SUPERVISOR​
// -------------------------​
​
$supervisor->syncPermissions([​
$crear,​
$ver,​
$editar,​
$cerrar,​
]);​
​
// -------------------------​
// PERMISOS DEL USUARIO​
// -------------------------​
​
$usuario->syncPermissions([​
$crear,​
$ver,​
]);​
}​
}
La idea recomendada es:
USUARIO
↓
ROL
↓
PERMISOS
En lugar de asignar muchos permisos directamente a cada usuario.
8. Registrar nuestro Seeder
Abrimos:database/seeders/DatabaseSeeder.php
Dejamos:
<?php​
​
namespace Database\Seeders;​
​
use Illuminate\Database\Seeder;​
​
class DatabaseSeeder extends Seeder​
{​
public function run(): void​
{​
$this->call([​
RolesAndPermissionsSeeder::class,​
]);​
}​
}
9. Ejecutar Seeder
php artisan db:seed
Podemos comprobar los permisos creados ejecutando:
php artisan permission:show
Spatie proporciona actualmente este comando para visualizar la matriz de roles y permisos.
10. Crear usuarios de prueba
Ahora agregaremos tres usuarios.
En:RolesAndPermissionsSeeder.php
agregamos los imports:
use App\Models\User;​
use Illuminate\Support\Facades\Hash;
Luego, debajo de la creación de roles:
$adminUser = User::firstOrCreate(​
['email' => 'admin@test.com'],​
[​
'name' => 'Administrador',​
'password' => Hash::make('12345678'),​
]​
);​
​
$adminUser->syncRoles(['admin']);​
​
​
$supervisorUser = User::firstOrCreate(​
['email' => 'supervisor@test.com'],​
[​
'name' => 'Supervisor',​
'password' => Hash::make('12345678'),​
]​
);​
​
$supervisorUser->syncRoles(['supervisor']);​
​
​
$normalUser = User::firstOrCreate(​
['email' => 'usuario@test.com'],​
[​
'name' => 'Usuario',​
'password' => Hash::make('12345678'),​
]​
);​
​
$normalUser->syncRoles(['usuario']);Volvemos a ejecutar:
php artisan db:seed
Usuarios disponibles
Usuario
Contraseña
Rol
admin@test.com12345678admin
supervisor@test.com12345678supervisor
usuario@test.com12345678usuario
11. Probar roles con Tinker
Ejecutamos:
php artisan tinker
Luego:
$user = App\Models\User::where('email', 'admin@test.com')->first();
Probamos:
$user->hasRole('admin');
Debe devolver:
●​ true
Probamos:
$user->can('gestionar usuarios');
Debe devolver:●​ true
Ahora:
$user = App\Models\User::where('email', 'usuario@test.com')->first();
Probamos:
$user->can('cerrar tickets');
Debe devolver:
●​ false
Para salir:
●​ exit
Verificación de la etapa 2
Debemos tener:
●​ Spatie instalado.
●​ Tabla roles.
●​ Tabla permissions.
●​ Rol admin.
●​ Rol supervisor.
●​
●​
●​
●​
Rol usuario.
Cinco permisos.
Tres usuarios de prueba.
Cada usuario tiene su rol correspondiente.