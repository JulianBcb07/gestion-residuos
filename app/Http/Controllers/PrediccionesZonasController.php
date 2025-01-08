<?php

namespace App\Http\Controllers;

use App\Models\GenSemanal;
use App\Models\Zona;
use App\Models\ZonasAreas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrediccionesZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $zonas = Zona::all();

        return view('prediccionesZonas.index', compact('zonas'));
    }

    public function obtenerPredicciones(Request $request)
    {
        $request->validate([
            'zona_id' => 'required|exists:zonas,id'
        ]);


        // Promedio movil para obtener valores de predicción de los próximos 7 días

        $datos = GenSemanal::join('zonas_areas', 'gen_semanals.zonas_areas_id', '=', 'zonas_areas.id')
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->selectRaw('zonas.id as zona_id, zonas.nombre as zona, DATE(gen_semanals.fecha) as fecha, SUM(gen_semanals.valor_kg) as total_kg')
            ->where('zonas.id', $request->zona_id)
            ->groupBy('zonas.id', 'zonas.nombre', 'fecha')
            ->orderBy('fecha')
            ->get();


        // dd($datos);

        if ($datos->isEmpty()) {
            return response()->json(['message' => 'No hay datos para esta zona']);
        }

        // Calcular la predicción para los próximos 7 días (promedio móvil)
        $predicciones = collect();
        $promedio_kg = $datos->avg('total_kg');
        $ultimaFecha = Carbon::parse($datos->last()->fecha);

        for ($i = 1; $i <= 7; $i++) {
            $predicciones->push([
                'zona_id' => $datos->first()->zona_id,
                'zona' => $datos->first()->zona,
                'fecha' => $ultimaFecha->addDay()->toDateString(),
                'total_kg' => round($promedio_kg, 2)
            ]);
        }

        // Combinar datos históricos y predicciones
        $datos = collect($datos);
        $resultado = $datos->merge($predicciones);

        return response()->json($resultado);
    }

    // public function obtenerTodasLasPredicciones()
    // {
    //     $zonas = Zona::all();
    //     $predicciones = [];

    //     foreach ($zonas as $zona) {
    //         $datos = GenSemanal::join('zonas_areas', 'gen_semanals.zonas_areas_id', '=', 'zonas_areas.id')
    //             ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
    //             ->selectRaw('zonas.id as zona_id, zonas.nombre as zona, DATE(gen_semanals.fecha) as fecha, SUM(gen_semanals.valor_kg) as total_kg')
    //             ->where('zonas.id', $zona->id)
    //             ->groupBy('zonas.id', 'zonas.nombre', 'fecha')
    //             ->orderBy('fecha')
    //             ->get();

    //         if ($datos->isEmpty()) {
    //             continue;
    //         }

    //         // Calcular la predicción para los próximos 7 días (promedio móvil)
    //         $prediccionesZona = [];
    //         $promedio_kg = $datos->avg('total_kg');
    //         $ultimaFecha = Carbon::parse($datos->last()->fecha);

    //         for ($i = 1; $i <= 7; $i++) {
    //             $prediccionesZona[] = [
    //                 'zona_id' => $datos->first()->zona_id,
    //                 'zona' => $datos->first()->zona,
    //                 'fecha' => $ultimaFecha->addDay()->toDateString(),
    //                 'total_kg' => round($promedio_kg, 2)
    //             ];
    //         }

    //         // Combinar datos históricos y predicciones
    //         $resultado = $datos->toArray();
    //         $resultado = array_merge($resultado, $prediccionesZona);

    //         $predicciones[$zona->id] = $resultado;
    //     }

    //     return view('prediccionesZonas.index', compact('zonas', 'predicciones'));
    // }

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
    public function show($id)
    {
        //
    }
}
