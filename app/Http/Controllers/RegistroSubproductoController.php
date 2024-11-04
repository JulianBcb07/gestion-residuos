<?php

namespace App\Http\Controllers;

use App\Models\GenSubproducto;
use App\Models\Subproducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroSubproductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Llamar a los subproductos registrados
        $subproductos = Subproducto::all();

        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el instituto del usuario autenticado o null si no tiene uno relacionado
            $instituto = Auth::user()->instituto ?? null;
        } else {
            // Redirigir a la página de inicio de sesión si no está autenticado
            return redirect()->route('login')->with('error', 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.');
        }

        return view('gensubproductos.index', compact('instituto', 'subproductos'));
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
    public function show(GenSubproducto $genSubproducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GenSubproducto $genSubproducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GenSubproducto $genSubproducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GenSubproducto $genSubproducto)
    {
        //
    }
}
