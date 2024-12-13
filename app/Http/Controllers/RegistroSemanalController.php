<?php

namespace App\Http\Controllers;

use App\Exports\RegistroSemanalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\GenSemanal;
use App\Models\Zona;
use App\Models\ZonasAreas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistroSemanalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $registros = GenSemanal::select('gen_semanals.id', 'fecha', 'zonas.nombre as zona', 'areas.nombre as areaAsignada', 'turno', 'valor_kg')
            ->join('zonas_areas', 'zonas_areas_id', '=', 'zonas_areas.id')
            ->join('zonas', 'zona_id', '=', 'zonas.id')
            ->join('areas', 'area_id', '=', 'areas.id')
            ->get();

        // dd($registros);

        return view('gensemanal.index', compact('registros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // si el usuario pasa mucho tiempo inactivo y expira la sesion, para evitar errores lo manda al login
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['msg' => 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.']);
        }

        // Obtener los datos del instituto que el usuario tiene relacionado por autenticacion
        $instituto = auth()->user()->instituto;

        // Verificamos si el usuario autenticado ya cuenta con un instituto asociado
        if (!auth()->user()->instituto_id) {
            return redirect()->back()->withErrors(['msg' => 'Para guardar una evidencia necesita tener una universidad asociada.']);
        }

        $zona_areas = ZonasAreas::select('zona_id', 'zonas.nombre as zona_nombre', 'area_id', 'areas.nombre as area_nombre')
            ->join('zonas', 'zonas.id', '=', 'zonas_areas.zona_id')
            ->join('areas', 'areas.id', '=', 'zonas_areas.area_id')
            ->orderBy('zonas.id')
            ->get()
            ->groupBy('zona_id');

        // dd($zona_areas);

        return view('gensemanal.create', compact('instituto', 'zona_areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validar los datos recibidos del formulario
        $validated = $request->validate([
            'fecha' => 'required|date_format:d/m/Y',
            'turno' => 'required|string|max:255',
            'valor_kg' => 'required|array',
        ]);

        $fecha = Carbon::createFromFormat(
            'd/m/Y',
            $validated['fecha']
        )->format('Y-m-d');
        $turno = $validated['turno'];

        // Verificar si ya existe un registro para la misma fecha y turno
        $registroExistente = GenSemanal::where('fecha', $fecha)
            ->where('turno', $turno)
            ->exists();

        if ($registroExistente) {
            return redirect()->back()->withErrors([
                'msg' => "Ya existe un registro en la fecha {$validated['fecha']} para el turno {$turno}.",
            ]);
        }

        // Verificar si ya existen registros en ambos turnos
        $turnosRegistrados = GenSemanal::where('fecha', $fecha)
            ->distinct()
            ->pluck('turno');

        if ($turnosRegistrados->count() >= 2) {
            return redirect()->back()->withErrors([
                'msg' => "Ya se han registrado datos para ambos turnos en la fecha {$validated['fecha']}. No se pueden agregar más registros.",
            ]);
        }

        // Iterar sobre los datos de generación semanal
        foreach ($validated['valor_kg'] as $zonaId => $areas) {
            foreach ($areas as $areaId => $kg) {
                // Evitar guardar valores vacíos o no válidos
                if (!is_numeric($kg) || $kg <= 0) {
                    continue;
                }

                // Buscar el registro en la tabla zonas_areas para obtener el zonas_areas_id
                $zonaArea = ZonasAreas::where('zona_id', $zonaId)
                    ->where('area_id', $areaId)
                    ->first();

                if ($zonaArea) {
                    // Crear el registro en la base de datos
                    GenSemanal::create([
                        'zonas_areas_id' => $zonaArea->id,  // ID de la relación zona-Área
                        'fecha' => Carbon::createFromFormat('d/m/Y', $validated['fecha'])->format('Y-m-d'),    // Fecha de recolección
                        'turno' => $validated['turno'],     // Turno asociado
                        'valor_kg' => $kg,                  // Kilogramos generados
                    ]);
                }
            }
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'Los datos se han guardado con éxito',
        ]);

        return redirect()->route('gensemanal.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $fecha, $turno)
    {

        // si el usuario pasa mucho tiempo inactivo y expira la sesion, para evitar errores lo manda al login
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['msg' => 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.']);
        }

        // Obtener los datos del instituto que el usuario tiene relacionado por autenticacion
        $instituto = auth()->user()->instituto;

        // Verificamos si el usuario autenticado ya cuenta con un instituto asociado
        if (!auth()->user()->instituto_id) {
            return redirect()->back()->withErrors(['msg' => 'Para guardar una evidencia necesita tener una universidad asociada.']);
        }

        $registros = ZonasAreas::select(
            'zonas.id as zona_id',
            'zonas.nombre as zona',
            'areas.id as area_id',
            'areas.nombre as areaAsignada',
            'gen_semanals.fecha',
            'gen_semanals.turno',
            'gen_semanals.valor_kg'
        )
            ->join('gen_semanals', function ($join) use ($fecha, $turno) {
                $join->on('zonas_areas.id', '=', 'gen_semanals.zonas_areas_id')
                    ->where('gen_semanals.fecha', '=', $fecha)
                    ->where('gen_semanals.turno', '=', $turno);
            })
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->join('areas', 'zonas_areas.area_id', '=', 'areas.id')
            ->get()
            ->groupBy('zona_id');


        $registroValido = $registros->flatMap(fn($areas) => $areas)->first();
        $fecha = $registroValido?->fecha ? Carbon::parse($registroValido->fecha)->format('d/m/Y') : Carbon::parse($fecha)->format('d/m/Y');
        $turno = $registroValido?->turno ?? $turno;

        // Convertir la fecha al formato m-d-Y para la URL 
        $fechaUrl = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');

        // dd($registros, $fecha, $turno);

        return view('gensemanal.show', compact('instituto', 'registros', 'fecha', 'turno', 'fechaUrl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $fecha, $turno)
    {
        // si el usuario pasa mucho tiempo inactivo y expira la sesion, para evitar errores lo manda al login
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['msg' => 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.']);
        }

        // Obtener los datos del instituto que el usuario tiene relacionado por autenticacion
        $instituto = auth()->user()->instituto;

        // Verificamos si el usuario autenticado ya cuenta con un instituto asociado
        if (!auth()->user()->instituto_id) {
            return redirect()->back()->withErrors(['msg' => 'Para guardar una evidencia necesita tener una universidad asociada.']);
        }

        // Mostrar registros de una fecha especifica tomando en cuenta que existen mas zonas y areas para que el usuario pueda agregar datos si asi lo requiere
        $registros = ZonasAreas::select(
            'zonas.id as zona_id',
            'zonas.nombre as zona',
            'areas.id as area_id',
            'areas.nombre as areaAsignada',
            'gen_semanals.fecha',
            'gen_semanals.turno',
            'gen_semanals.valor_kg'
        )
            ->leftJoin('gen_semanals', function ($join) use ($fecha, $turno) {
                $join->on('zonas_areas.id', '=', 'gen_semanals.zonas_areas_id')
                    ->where('gen_semanals.fecha', '=', $fecha)
                    ->where('gen_semanals.turno', '=', $turno);
            })
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->join('areas', 'zonas_areas.area_id', '=', 'areas.id')
            ->get()
            ->groupBy('zona_id');

        $registroValido = $registros->flatMap(fn($areas) => $areas)->first();
        $fecha = $registroValido?->fecha ? Carbon::parse($registroValido->fecha)->format('d/m/Y') : Carbon::parse($fecha)->format('d/m/Y');
        $turno = $registroValido?->turno ?? $turno;


        return view('gensemanal.edit', compact('instituto', 'registros', 'fecha', 'turno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAll(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'fecha' => 'required|date_format:d/m/Y',
            'turno' => 'required|string|max:255',
            'valor_kg' => 'required|array',
        ]);

        $turnoNuevo = $validated['turno'];
        $turnoAnterior = $request->has('turno_anterior') ? $request->input('turno_anterior') : $turnoNuevo;
        $fechaNueva = Carbon::createFromFormat('d/m/Y', $validated['fecha'])->format('Y-m-d');
        $fechaAnterior = $request->has('fecha_anterior')
            ? Carbon::createFromFormat('d/m/Y', $request->input('fecha_anterior'))->format('Y-m-d')
            : $fechaNueva;


        // Procesar los valores enviados desde el formulario
        foreach ($validated['valor_kg'] as $zonaId => $areas) {
            foreach ($areas as $areaId => $kg) {
                // Buscar la relación entre zona y área
                $zonaArea = ZonasAreas::where('zona_id', $zonaId)
                    ->where('area_id', $areaId)
                    ->first();

                if ($zonaArea) {
                    // Buscar el registro existente con la fecha anterior
                    $registroExistente = GenSemanal::where('zonas_areas_id', $zonaArea->id)
                        ->where('fecha', $fechaAnterior)
                        ->where('turno', $turnoAnterior)
                        ->first();

                    if (is_numeric($kg) && $kg > 0) {
                        // Actualizar si existe el registro
                        if ($registroExistente) {
                            $registroExistente->update([
                                'fecha' => $fechaNueva,
                                'turno' => $turnoNuevo,
                                'valor_kg' => $kg,
                            ]);
                        } else {
                            // Crear un nuevo registro si no existe con la nueva fecha
                            GenSemanal::create([
                                'zonas_areas_id' => $zonaArea->id,
                                'fecha' => $fechaNueva,
                                'turno' => $turnoNuevo,
                                'valor_kg' => $kg,
                            ]);
                        }
                    } elseif ($registroExistente) {
                        // Si el valor no es válido y existe un registro, se elimina
                        $registroExistente->delete();
                    }
                }
            }
        }

        // Notificar éxito al usuario
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Hecho!',
            'text' => 'Los datos se han actualizado con éxito.',
        ]);

        return redirect()->route('gensemanal.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GenSemanal $genSemanal)
    {
        //
    }

    public function GenerarPDF(Request $request, $fecha, $turno)
    {

        // si el usuario pasa mucho tiempo inactivo y expira la sesion, para evitar errores lo manda al login
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['msg' => 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.']);
        }

        // Obtener los datos del instituto que el usuario tiene relacionado por autenticacion
        $instituto = auth()->user()->instituto;

        // Verificamos si el usuario autenticado ya cuenta con un instituto asociado
        if (!auth()->user()->instituto_id) {
            return redirect()->back()->withErrors(['msg' => 'Para guardar una evidencia necesita tener una universidad asociada.']);
        }

        $registros = ZonasAreas::select(
            'zonas.id as zona_id',
            'zonas.nombre as zona',
            'areas.id as area_id',
            'areas.nombre as areaAsignada',
            'gen_semanals.fecha',
            'gen_semanals.turno',
            'gen_semanals.valor_kg'
        )
            ->join('gen_semanals', function ($join) use ($fecha, $turno) {
                $join->on('zonas_areas.id', '=', 'gen_semanals.zonas_areas_id')
                    ->where('gen_semanals.fecha', '=', $fecha)
                    ->where('gen_semanals.turno', '=', $turno);
            })
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->join('areas', 'zonas_areas.area_id', '=', 'areas.id')
            ->get()
            ->groupBy('zona_id');


        $registroValido = $registros->flatMap(fn($areas) => $areas)->first();
        $fecha = $registroValido?->fecha ? Carbon::parse($registroValido->fecha)->format('d/m/Y') : Carbon::parse($fecha)->format('d/m/Y');
        $turno = $registroValido?->turno ?? $turno;

        $pdf = Pdf::loadView('gensemanal.pdf', compact('registros', 'fecha', 'turno', 'instituto'));
        return $pdf->stream('reporte_gensemanal.pdf');
    }

    public function GenerarExcel(Request $request, $fecha, $turno)
    {

        // si el usuario pasa mucho tiempo inactivo y expira la sesion, para evitar errores lo manda al login
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['msg' => 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.']);
        }

        // Obtener los datos del instituto que el usuario tiene relacionado por autenticacion
        $instituto = auth()->user()->instituto;

        // Verificamos si el usuario autenticado ya cuenta con un instituto asociado
        if (!auth()->user()->instituto_id) {
            return redirect()->back()->withErrors(['msg' => 'Para guardar una evidencia necesita tener una universidad asociada.']);
        }

        $registros = ZonasAreas::select(
            'zonas.id as zona_id',
            'zonas.nombre as zona',
            'areas.id as area_id',
            'areas.nombre as areaAsignada',
            'gen_semanals.fecha',
            'gen_semanals.turno',
            'gen_semanals.valor_kg'
        )
            ->join('gen_semanals', function ($join) use ($fecha, $turno) {
                $join->on('zonas_areas.id', '=', 'gen_semanals.zonas_areas_id')
                    ->where('gen_semanals.fecha', '=', $fecha)
                    ->where('gen_semanals.turno', '=', $turno);
            })
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->join('areas', 'zonas_areas.area_id', '=', 'areas.id')
            ->orderBy('zonas.id') // Ordenar por zona primero
            ->get();

        // dd($registros);

        $registroValido = $registros->flatMap(fn($areas) => $areas)->first();
        $fecha = $registroValido?->fecha ? Carbon::parse($registroValido->fecha)->format('d/m/Y') : Carbon::parse($fecha)->format('d/m/Y');
        $turno = $registroValido?->turno ?? $turno;

        return Excel::download(new RegistroSemanalExport($registros, $fecha), 'registro-semanal.xlsx');
    }
}
