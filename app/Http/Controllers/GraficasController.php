<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficasController extends Controller
{

    public function show()
    {
        return view('graficas.show');
    }
}
