<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;


class RolesAndPermissionsSeeder extends Seeder
{
    public function run (): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        //Permisos
        $crear = Permission::firstOrCreate
        (
            ['name'=>'crear tickets']
        );
        $ver = Permission::firstOrCreate(
            ['name'=>'ver tickets']
        );
        $editar = Permission::firstOrCreate(
            ['name'=>'editar tickets']
        );
        $cerrar = Permission::firstOrCreate(
            ['name'=>'cerrar tickets']
        );
        $gestionarUsuarios = Permission::firstOrCreate(
            ['name'=>'gestionar usuarios']
        );

        //roles
        $admin = Role::firstOrCreate(
            ['name'=>'admin']
        );
        $supervisor = Role::firstOrCreate(
            ['name'=>'supervisor']
        );
        $usuario = Role::firstOrCreate(
            ['name'=>'usuario']
        );
        //asignar permisos
        $admin->givePermissionTo([$crear, $ver, $editar, $cerrar, $gestionarUsuarios]);
        $soporte->givePermissionTo([$crear, $ver, $editar, $cerrar]);
        $cliente->givePermissionTo([$crear, $ver]);
    }
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}
