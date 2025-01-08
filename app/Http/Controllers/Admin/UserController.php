<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institutos;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Llamamos a todos los roles que tenemos en el modelo rol y luego lo pasamos a la vista edit
        $roles = Role::all();
        $institutos = Institutos::all();

        return view('admin.users.edit', compact('user', 'roles', 'institutos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Acciones requeridas
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:8|confirmed',
            'instituto_id' => 'required|exists:institutos,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->instituto_id = $request->instituto_id;

        if ($user->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Para asignar los roles, accedemos a la relacion y se sincroniza para guardar los roles al usuario
        $user->roles()->sync($request->roles);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'El usuario se ha actualizado correctamente!'
        ]);

        // dd($user);

        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
