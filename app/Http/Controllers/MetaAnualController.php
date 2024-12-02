<?php

namespace App\Http\Controllers;

use App\Models\GenSemanal;
use Illuminate\Http\Request;

class MetaAnualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('metaAnual.index');
    }
}
