<?php

namespace App\Http\Controllers;

use App\Models\GenSemanal;
use App\Models\Institutos;
use Illuminate\Http\Request;

class MetaAnualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // llamar a los datos dependiendo del instituto
        $instituto = auth()->user()->instituto_id;

        // Obtenemos los datos del instituto
        $instituto = Institutos::where('id', $instituto)
            ->select('id', 'nombre', 'meta_anual', 'total_personas')
            ->first();
        // dd($meta);
        // Calcular el total de residuos generados en las zonas
        $totalResiduos = GenSemanal::whereHas('zonaArea.zona.instituto', function ($query) use ($instituto) {
            $query->where('id', $instituto->id);
        })->sum('valor_kg');

        $promedioPercapita = $instituto->total_personas > 0 ? $totalResiduos / $instituto->total_personas : 0;

        // Promedio per capita anual considernado los 309 dias laborales
        // $promedioPercapitaAnual = $promedioPercapita * 309;

        // Porcentaje de cumplimiento de la meta anual
        $excedeMeta = $promedioPercapita > $instituto->meta_anual;

        // dd($totalResiduos);
        // dd($promedioPercapita);
        // dd($promedioPercapitaAnual);

        // Obtener los registros de cada zona con mayor generacion de forma decendente en kg (que les sirva a los usuario para identificar las zonas con mayor generacion)
        $registroConMayorGeneracion = GenSemanal::whereHas('zonaArea.zona.instituto', function ($query) use ($instituto) {
            $query->where('id', $instituto->id);
        })->orderBy('valor_kg', 'desc')->paginate(5);

        return view('metaAnual.index', compact('instituto', 'totalResiduos', 'promedioPercapita', 'excedeMeta', 'registroConMayorGeneracion'));
    }
}
