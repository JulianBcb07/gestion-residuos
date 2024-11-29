<?php

namespace App\Http\Controllers;

use App\Models\GenSemanal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraficasSemanalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $baseQuery = GenSemanal::query();
        $top3Generado = $this->getTop3Generado($baseQuery);

        // dd($top3Generado);

        return view('graficassemanal.index', compact('top3Generado'));
    }

    private function applyDataFilters($query, $periodo, $startDate, $endDate)
    {
        if ($startDate && $endDate) {
            $query->whereBetween('fecha', [
                Carbon::parse($startDate)->format('Y-m-d'),
                Carbon::parse($endDate)->format('Y-m-d')
            ]);
        } else {
            switch ($periodo) {
                case '7_dias':
                    $query->whereBetween('fecha', [now()->subDays(7), now()]);
                    break;
                case '30_dias':
                    $query->whereBetween('fecha', [now()->subDays(30), now()]);
                    break;
                case '90_dias':
                    $query->whereBetween('fecha', [now()->subDays(90), now()]);
                    break;
                default:
                    // Sin filtro de fecha
                    break;
            }
        }
    }

    // Obtener datos de una grafica especifica usando AJAX
    public function fetchGraphData(Request $request)
    {
        $tipoGrafica = $request->input('tipoGrafico');
        $periodo = $request->input('periodo', 'Todo');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $baseQuery = GenSemanal::query();
        $this->applyDataFilters($baseQuery, $periodo, $startDate, $endDate);

        switch ($tipoGrafica) {
            case 'top3':
                $data = $this->getTop3Generado($baseQuery);
                break;
            case 'pieChart':
                $data = $this->getPorcentajeResiduos($baseQuery);
                break;
            case 'barChart':
                $data = $this->getGraficoTotalResiduos($baseQuery);
                break;
            case 'lineChart':
                $data = $this->getGraficoTendenciaResiduos($baseQuery);
                break;
            case 'all':
                // Obtener los datos para todas las gráficas
                $data = [
                    'top3' => $this->getTop3Generado($baseQuery->clone()),
                    'pieChart' => $this->getPorcentajeResiduos($baseQuery->clone()),
                    'barChart' => $this->getGraficoTotalResiduos($baseQuery->clone()),
                    'lineChart' => $this->getGraficoTendenciaResiduos($baseQuery->clone())
                ];
                break;
            default:
                // Show an error if the data is not in the switch
                return response()->json(['error' => 'Tipo de gráfica no válido'], 400);
        }

        return response()->json($data);
    }

    // Funciones para obtener los datos de cada grafica de generacion de residuos

    // Obtener datos de top 3 zonas con mayor generacion
    private function getTop3Generado($query)
    {
        return $query->select(
            'zonas.id as zona_id',
            'zonas.nombre as zona',
            DB::raw('SUM(gen_semanals.valor_kg) as total_kg')
        )
            ->join('zonas_areas', 'gen_semanals.zonas_areas_id', '=', 'zonas_areas.id')
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->join('areas', 'zonas_areas.area_id', '=', 'areas.id')
            ->groupBy('zonas.id', 'zonas.nombre')
            ->orderBy('total_kg', 'DESC')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                return [
                    'nombre' => $item->zona,
                    'total_kg' =>  $item->total_kg
                ];
            });
    }

    // Obtener datos de la grafica pastel de porcentaje de generacion por zonas
    private function getPorcentajeResiduos($query)
    {
        return $query->select(
            'zonas.id as zona_id',
            'zonas.nombre as zona',
            DB::raw('SUM(gen_semanals.valor_kg) as total_kg')
        )
            ->join('zonas_areas', 'gen_semanals.zonas_areas_id', '=', 'zonas_areas.id')
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->groupBy('zonas.id', 'zonas.nombre')
            ->orderBy('total_kg', 'DESC')
            ->get()
            ->map(
                function ($item) {
                    return [
                        'nombre' => $item->zona,
                        'total_kg' =>  $item->total_kg
                    ];
                }
            );
    }

    private function getGraficoTotalResiduos($query)
    {
        return $query->select(
            'zonas.id as zona_id',
            'zonas.nombre as zona',
            DB::raw('SUM(gen_semanals.valor_kg) as total_kg')
        )
            ->join('zonas_areas', 'gen_semanals.zonas_areas_id', '=', 'zonas_areas.id')
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->groupBy('zonas.id', 'zonas.nombre')
            ->orderBy('total_kg', 'DESC')
            ->get()
            ->map(
                function ($item) {
                    return [
                        'nombre' => $item->zona,
                        'total_kg' =>  $item->total_kg
                    ];
                }
            );
    }

    private function getGraficoTendenciaResiduos($query)
    {
        return $query->select(
            'gen_semanals.fecha',
            'zonas.id as zona_id',
            'zonas.nombre as zona',
            DB::raw('SUM(gen_semanals.valor_kg) as total_kg')
        )
            ->join('zonas_areas', 'gen_semanals.zonas_areas_id', '=', 'zonas_areas.id')
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->groupBy('gen_semanals.fecha', 'zonas.id')
            ->orderBy('gen_semanals.fecha', 'ASC')
            ->get()
            ->map(
                function ($item) {
                    return [
                        'fecha' => Carbon::parse($item->fecha)->format('Y-m-d'),
                        'nombre' => $item->zona,
                        'total_kg' =>  $item->total_kg
                    ];
                }
            );
    }
}
