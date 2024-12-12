<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Institutos;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Llamamos a todos los datos que hay en la tabla zonas
        $areas = Area::all();

        return view('admin.areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $institutos = Institutos::all();

        return view('admin.areas.create', compact('institutos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'unique:areas,nombre'],
            'descripcion' => 'nullable',
            'instituto_id' => 'required|exists:institutos,id',
        ]);

        $area = Area::create($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'Se ha creado una nueva Area',
        ]);

        return redirect()->route('admin.areas.edit', $area);
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        return view('admin.areas.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        $institutos = Institutos::all();

        return view('admin.areas.edit', compact('area', 'institutos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        // Ponemos una validacion requerida y unica en la tabla roles, en el campo name excluyendo el id que estamos editando ($role->id) 
        $request->validate([
            'nombre' => ['required', 'unique:areas,nombre'],
            'descripcion' => 'nullable',
            'instituto_id' => 'required|exists:institutos,id',
        ]);


        $area->update($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'El Area se ha actualizado correctamente',
        ]);

        return redirect()->route('admin.areas.edit', $area);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'El Area se ha eliminado correctamente',
        ]);

        return redirect()->route('admin.areas.index');
    }
}
