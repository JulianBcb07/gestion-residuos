<?php

namespace App\Http\Controllers;

use App\Models\GenSubproducto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraficasSubproductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $baseQuery = GenSubproducto::query();
        $top3Subproductos = $this->getTop3Subproductos($baseQuery);

        return view('graficassubproductos.index', compact('top3Subproductos'));
    }

    // Fetch Data for a specific graph via AJAX / Obtener datos de una grafica especifica via AJAX
    public function fetchGraphData(Request $request)
    {
        $tipoGrafica = $request->input('tipoGrafico');
        $periodo = $request->input('periodo', 'Todo');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $baseQuery = GenSubproducto::query();
        $this->applyDataFilters($baseQuery, $periodo, $startDate, $endDate);

        switch ($tipoGrafica) {
            case 'top3':
                $data = $this->getTop3Subproductos($baseQuery);
                break;
            case 'pieChart':
                $data = $this->getPorcentajeGenerado($baseQuery);
                break;
            case 'barChart':
                $data = $this->getGraficoBarras($baseQuery);
                break;
            case 'lineChart':
                $data = $this->getGraficoTendencias($baseQuery);
                break;
            case 'all':
                // Obtener los datos para todas las gráficas
                $data = [
                    // 'top3' => $this->getTop3Subproductos($baseQuery),
                    'pieChart' => $this->getPorcentajeGenerado($baseQuery),
                    'barChart' => $this->getGraficoBarras($baseQuery),
                    'lineChart' => $this->getGraficoTendencias($baseQuery)
                ];
                break;
            default:
                // Show an error if the data is not in the switch
                return response()->json(['error' => 'Tipo de gráfica no válido'], 400);
        }

        return response()->json($data);
    }

    // Apply date filters to a query / Aplicar los filtros de fecha a la consulta
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

    // Funciones para obtener los datos de cada grafica de generacion de subproductos

    // Get top 3 subproducts data / Obtener datos de top 3 subproductos
    private function getTop3Subproductos($query)
    {
        return $query->select('subproducto_id')
            ->with('subproducto')
            ->groupBy('subproducto_id')
            ->selectRaw('SUM(valor_kg) as total_kg')
            ->orderByRaw('SUM(valor_kg) DESC')  // Ordenar por la suma de valor_kg
            ->limit(3)
            ->get()
            ->map(function ($item) {
                return [
                    'nombre' => $item->subproducto->nombre,
                    'total_kg' => $item->total_kg
                ];
            });
    }

    // Get pie chart data / Obtener datos de la grafica pastel
    private function getPorcentajeGenerado($query)
    {
        return $query->select('subproducto_id')
            ->with('subproducto')
            ->groupBy('subproducto_id')
            ->selectRaw('SUM(valor_kg) as total_kg')
            ->orderByRaw('SUM(valor_kg) DESC')  // Ordenar correctamente por la columna calculada
            ->get()
            ->map(function ($item) {
                return [
                    'nombre' => $item->subproducto->nombre,
                    'total_kg' => $item->total_kg
                ];
            });
    }

    // Get bar chart data / Obtener datos del grafico de barras
    private function getGraficoBarras($query)
    {
        return $query->with('subproducto')
            ->select('subproducto_id')
            ->groupBy('subproducto_id')
            ->selectRaw('SUM(valor_kg) as total_kg')
            ->orderByRaw('SUM(valor_kg) DESC')
            ->get()
            ->map(function ($item) {
                return [
                    'nombre' => $item->subproducto->nombre,
                    'total_kg' => $item->total_kg
                ];
            });
    }


    // Get line chart data / Obtener datos del grafico de lineas o tendencia
    private function getGraficoTendencias($query)
    {
        return $query->select('fecha', 'subproducto_id', DB::raw('SUM(valor_kg) as total_kg')) // Aplica SUM a valor_kg
            ->with('subproducto')
            ->groupBy('fecha', 'subproducto_id') // Agrupa por 'fecha' y 'subproducto_id'
            ->orderBy('fecha', 'Asc')
            ->get()
            ->map(function ($item) {
                return [
                    'fecha' => Carbon::parse($item->fecha)->format('Y-m-d'),
                    'nombre' => $item->subproducto->nombre,
                    'valor_kg' => $item->total_kg // Utiliza el valor sumado
                ];
            });
    }
}
