<?php

namespace App\Http\Controllers;

use App\Models\GenSemanal;
use Illuminate\Http\Request;

class PrediccionesZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('prediccionesZonas.index');
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
    public function show(GenSemanal $genSemanal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GenSemanal $genSemanal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GenSemanal $genSemanal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GenSemanal $genSemanal)
    {
        //
    }
}
