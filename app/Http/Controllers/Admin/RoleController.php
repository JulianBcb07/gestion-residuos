<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recuperamos todos los roles para mostrarlos en la vista index
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Recuperar todos nuestros permisos y luego se lo pasamos a la vista con roles
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // esta regla significa que debe ser unico en la tabla roles y en el campo name
        $request->validate([
            'name' => ['required', 'unique:roles,name'],
            'permissions' => 'nullable|array',
        ]);

        // Se crea el rol
        $role = Role::create($request->all());

        // Acceder al rol y su relacion con permisos y sincronizar
        // Para la creacion se puede usar attach o sync
        $role->permissions()->attach($request->permissions);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'El Rol se ha creado correctamente!'
        ]);

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {

        $permissions = $role->permissions();

        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Ponemos una validacion requerida y unica en la tabla roles, en el campo name excluyendo el id que estamos editando ($role->id) 
        $request->validate([
            'name' => ['required', 'unique:roles,name, ' . $role->id],
            'permissions' => 'nullable|array',
        ]);

        // Actualizamos con el metodo update lo que llega del formulario ($request->all)
        $role->update($request->all());

        /* Sincronizamos el rol con los permisos para que el metodo se encargue de agregar los registros
        ** en la tabla intermedia. Para llamar a la relacion se usa $role->permissions()
        */
        $role->permissions()->sync($request->permissions);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'El Rol se ha actualizado correctamente!'
        ]);

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Para eliminar el rol
        $role->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'El Rol se ha eliminado correctamente'
        ]);

        return redirect()->route('admin.roles.index');
    }
}
