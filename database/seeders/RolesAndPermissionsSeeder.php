<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // crear los permisos
        Permission::create(['name' => 'Acceso a Administración']);
        Permission::create(['name' => 'Acceso a Zonas']);
        Permission::create(['name' => 'Acceso a Areas']);
        Permission::create(['name' => 'Acceso a Subproductos']);
        Permission::create(['name' => 'Gestion de Roles']);
        Permission::create(['name' => 'Gestion de Permisos']);
        Permission::create(['name' => 'Gestion de Usuarios']);
        Permission::create(['name' => 'Gestion de MiTecnológico']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // Crear roles y asignar los permisos que se han creado

        // Se crea el rol SuperUsuario
        $role = Role::create(['name' => 'SuperUsuario']);
        $role->givePermissionTo(Permission::all());

        // Se asignan con un array muchos permisos al rol nombrado
        $role = Role::create(['name' => 'AdminTecnológico'])
            ->givePermissionTo(['Acceso a Administración', 'Acceso a Zonas', 'Acceso a Areas', 'Gestion de Usuarios', 'Gestion de MiTecnológico']);

        $role = Role::create(['name' => 'Capturista'])
            ->givePermissionTo(['Acceso a Administración', 'Acceso a Zonas', 'Acceso a Areas']);

        // Pueden haber permisos por separado
        $role = Role::create(['name' => 'Participante']);
        $role->givePermissionTo('');
    }
}
