<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Permisos
        $crear = Permission::firstOrCreate(
            ['name' => 'crear tickets']
        );
        $ver = Permission::firstOrCreate(
            ['name' => 'ver tickets']
        );
        $editar = Permission::firstOrCreate(
            ['name' => 'editar tickets']
        );
        $cerrar = Permission::firstOrCreate(
            ['name' => 'cerrar tickets']
        );
        $gestionarUsuarios = Permission::firstOrCreate(
            ['name' => 'gestionar usuarios']
        );

        // roles
        $admin = Role::firstOrCreate(
            ['name' => 'admin']
        );
        $supervisor = Role::firstOrCreate(
            ['name' => 'supervisor']
        );
        $usuario = Role::firstOrCreate(
            ['name' => 'usuario']
        );

        // asignar permisos
        $admin->givePermissionTo([
            $crear,
            $ver,
            $editar,
            $cerrar,
            $gestionarUsuarios,
        ]);
        $supervisor->givePermissionTo([
            $crear,
            $ver,
            $editar,
            $cerrar,
        ]);
        $usuario->givePermissionTo([
            $crear,
            $ver,
        ]);

        // agregado de usuarios test
        $admintest = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'admintest',
                'password' => Hash::make('admintest1234'),
            ]
        );
        $admintest->syncRoles(['admin']);

        $supervisortest = User::firstOrCreate(
            ['email' => 'supervisor@test.com'],
            [
                'name' => 'supervisortest',
                'password' => Hash::make('supervisortest1234'),
            ]
        );
        $supervisortest->syncRoles(['supervisor']);

        $usuariotest = User::firstOrCreate(
            ['email' => 'usuario@test.com'],
            [
                'name' => 'usuariotest',
                'password' => Hash::make('usuariotest1234'),
            ]
        );
        $usuariotest->syncRoles(['usuario']);
    }
}
