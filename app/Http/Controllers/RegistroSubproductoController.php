<?php

namespace App\Http\Controllers;

use App\Exports\RegistroSubproductosExport;
use App\Models\GenSemanal;
use App\Models\GenSubproducto;
use App\Models\Subproducto;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RegistroSubproductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tiempo = $request->input('tiempo', 'semanal');

        switch ($tiempo) {
            case 'semanal':
                // Recuperar los registros agrupados por semana y sumar los valores
                $registroPeriodo = GenSubproducto::selectRaw(
                    'YEAR(fecha) as year, 
                    WEEK(fecha) as semana, 
                    MIN(fecha) as fecha_inicio, 
                    MAX(fecha) as fecha_final, 
                    SUM(valor_kg) as total_kg,
                    instituto_id'
                )
                    ->groupBy('year', 'semana', 'instituto_id')
                    ->orderBy('year', 'asc') // Agregando la dirección explícita
                    ->orderBy('semana', 'asc') // Agregando la dirección explícita
                    ->get();
                break;

            case 'mensual':
                $registroPeriodo = GenSubproducto::selectRaw(
                    'YEAR(fecha) as year, 
                    MONTH(fecha) as mes, 
                    DATE_FORMAT(MIN(fecha), "%Y-%m-01") as fecha_inicio, 
                    LAST_DAY(MAX(fecha)) as fecha_final, 
                    SUM(valor_kg) as total_kg, 
                    instituto_id'
                )
                    ->groupBy('year', 'mes', 'instituto_id')
                    ->orderBy('year', 'asc')
                    ->orderBy(
                        'mes',
                        'asc'
                    )
                    ->get();

                break;

            case 'anual':
                $registroPeriodo = GenSubproducto::selectRaw(
                    'YEAR(fecha) as year, 
                    DATE_FORMAT(MIN(fecha), "%Y-01-01") as fecha_inicio, 
                    DATE_FORMAT(MAX(fecha), "%Y-12-31") as fecha_final, 
                    SUM(valor_kg) as total_kg, 
                    instituto_id'
                )
                    ->groupBy('year', 'instituto_id')
                    ->orderBy('year', 'asc')
                    ->get();
                break;

            default:
                abort(400, 'Período no válido');
        }



        // dd($registrosPorSemana);

        return view('gensubproductos.index', compact('registroPeriodo')); // Asegúrate de tener esta vista.
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
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

        return view('gensubproductos.create', compact('instituto', 'subproductos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'instituto_id' => 'required|exists:institutos,id',
            'inicio' => 'required|date|before_or_equal:final',
            'final' => 'required|date|after_or_equal:inicio',
            'subproducto' => 'required|array',
            'subproducto.*.nombre' => 'required|string',
            'subproducto.*.valor_kg.*' => 'nullable|numeric|regex:/^\d+(\.\d{1,3})?$/|max:100',
        ]);

        // Creamos variables para almacenar los datos que llegan del formulario
        $instituto_id = $request->input('instituto_id');
        $inicio = Carbon::createFromFormat('m/d/Y', $request->input('inicio'));
        $final = Carbon::createFromFormat('m/d/Y', $request->input('final'));
        $subproductos = $request->input('subproducto');

        // Mantengo en la sesion la fecha de inico y la fecha final
        session(['inicio' => $inicio, 'final' => $final]);

        // Verificar que el rango de fechas no exceda los 7 días
        if ($inicio->diffInDays($final) > 6) {
            return redirect()->back()->withInput()->withErrors(['final' => 'El rango de fechas no puede exceder los 7 días.']);
        }

        $inicioSemana = $inicio->dayOfWeek;

        // Validar que ninguna fecha exceda el rango seleccionado
        foreach ($subproductos as $subproducto_id => $subproducto) {
            foreach ($subproducto['valor_kg'] as $dia => $valor_kg) {
                if (!is_null($valor_kg)) {
                    // Calcular la fecha correspondiente al día
                    $dia_numero = (int) str_replace('dia_', '', $dia);
                    $fecha = $inicio->copy()->addDays(($dia_numero - 1 + (7 - $inicioSemana)) % 7);

                    if ($fecha->greaterThan($final)) {
                        return redirect()->back()->withInput()->withErrors(['No puedes capturar datos fuera del rango de fecha seleccionado.']);
                    }
                }
            }
        }

        // Si todas las validaciones pasan, guardo los datos en la ase de datos
        foreach ($subproductos as $subproducto_id => $subproducto) {
            foreach ($subproducto['valor_kg'] as $dia => $valor_kg) {
                if (!is_null($valor_kg)) {
                    // Calcular la fecha correspondiente al día
                    $dia_numero = (int) str_replace('dia_', '', $dia);
                    $fecha = $inicio->copy()->addDays(($dia_numero - 1 + (7 - $inicioSemana)) % 7);

                    // Crear el registro en la base de datos
                    GenSubproducto::create([
                        'fecha' => $fecha,
                        'valor_kg' => $valor_kg,
                        'instituto_id' => $instituto_id,
                        'subproducto_id' => $subproducto_id,
                    ]);
                }
            }
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'Los datos se han guardado con éxito',
        ]);

        return redirect()->route('gensubproductos.editAll', [
            'instituto_id' => $instituto_id,
            'inicio' => $inicio->format('Y-m-d'),
            'final' => $final->format('Y-m-d'),
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, $instituto_id, $inicio, $final)
    {

        $inicio = Carbon::parse($inicio);
        $final = Carbon::parse($final);

        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el instituto del usuario autenticado o null si no tiene uno relacionado
            $instituto = Auth::user()->instituto ?? null;
        } else {
            // Redirigir a la página de inicio de sesión si no está autenticado
            return redirect()->route('login')->with('error', 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.');
        }

        // Consulta de datos generados
        $datosGenerados = GenSubproducto::select(
            'subproductos.id as subproducto_id',
            'subproductos.nombre as subproducto_nombre',
            'gen_subproductos.fecha',
            DB::raw('SUM(gen_subproductos.valor_kg) as total_kg')
        )
            ->join('subproductos', 'gen_subproductos.subproducto_id', '=', 'subproductos.id')
            ->whereBetween('gen_subproductos.fecha', [$inicio, $final])
            ->groupBy('subproductos.id', 'subproductos.nombre', 'gen_subproductos.fecha')
            ->orderBy('subproductos.id')
            ->orderBy('gen_subproductos.fecha')
            ->get();

        // Agrupar por subproducto
        $datosAgrupados = $datosGenerados->groupBy('subproducto_nombre');

        // dd($datosAgrupados);

        return view('gensubproductos.show', compact('datosAgrupados', 'inicio', 'final', 'instituto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $instituto_id, $inicio, $final)
    {

        // Convertir las fechas a instancias de Carbon
        $inicio = Carbon::parse($inicio);
        $final = Carbon::parse($final)->endOfDay();

        // Mantener el valor original de $inicio intacto para la base de datos
        $inicioOriginal = $inicio->copy();
        $inicioSemana = $inicio->dayOfWeek;
        $inicio = $inicio->subDays($inicioSemana);

        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el instituto del usuario autenticado o null si no tiene uno relacionado
            $instituto = Auth::user()->instituto ?? null;
        } else {
            // Redirigir a la página de inicio de sesión si no está autenticado
            return redirect()->route('login')->with('error', 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.');
        }

        // Obtener los subproductos disponibles
        $subproductos = Subproducto::all();

        /**  Obtenemos los 7 dias (1 semana en relacion a la primera fecha que el usuario haya seleccionado) 
         * esto nos sirve para iterar en el formulario respetando el rango de 7 dias
         */
        $RangoFechas = collect(range(0, 6))->map(function ($offset) use ($inicio) {
            return \Carbon\Carbon::parse($inicio)->addDays($offset)->format('Y-m-d');
        });

        // dd($RangoFechas);

        $datosGenerados = GenSubproducto::select('valor_kg', 'subproducto_id', 'fecha')
            ->where('instituto_id', $instituto->id)
            ->whereBetween('fecha', [$inicio, $final])
            ->get()
            ->groupBy('subproducto_id')
            ->mapWithKeys(function ($items, $subproducto_id) use ($RangoFechas) {
                $valoresPorFecha = $RangoFechas->mapWithKeys(function ($fecha) {
                    return [$fecha => ''];
                });

                // Reemplazar los valores del rango de fecha (0 por defecto) por los que se encuentran en valor_kg
                foreach ($items as $item) {
                    $fechaSinHora = \Carbon\Carbon::parse($item->fecha)->format('Y-m-d');
                    if ($valoresPorFecha->has($fechaSinHora)) {
                        $valoresPorFecha[$fechaSinHora] = $item->valor_kg;
                    }
                }
                return [$subproducto_id => $valoresPorFecha];
            })->toArray();

        // dd($datosGenerados);

        // Pasar las variables a la vista
        return view('gensubproductos.edit', [
            'instituto' => $instituto,
            'inicio' => $inicioOriginal->format('m-d-Y'),
            'final' => $final->format('m-d-Y'),    // Formato correcto para las fechas
            'subproductos' => $subproductos,
            'datosGenerados' => $datosGenerados,
            'RangoFechas' => $RangoFechas, // Llamamos al rango de fechas para hacer la iteracion en el formulario
        ]);
    }




    /**
     * Update the specified resource in storage.
     */
    public function updateMultiple(Request $request)
    {
        // Validar los datos del formulario recibidos
        $request->validate([
            'instituto_id' => 'required|exists:institutos,id',
            'inicio' => 'required|date|before_or_equal:final',
            'final' => 'required|date|after_or_equal:inicio',
            'subproducto' => 'required|array',
            'subproducto.*.valor_kg.*' => 'nullable|numeric|regex:/^\d+(\.\d{1,3})?$/|max:100',
        ]);

        $instituto_id = $request->input('instituto_id');
        $inicio = Carbon::createFromFormat('m/d/Y', $request->input('inicio'));
        $final = Carbon::createFromFormat('m/d/Y', $request->input('final'));

        $inicio->copy();
        $inicioSemana = $inicio->dayOfWeek;
        $inicio = $inicio->subDays($inicioSemana);

        // Verificar si la fecha inicio no sea posterior a la fecha final, si no mandar un error de validacion
        if ($inicio->gt($final)) {
            return back()->withErrors(['date_error' => 'La fecha de inicio no puede ser posterior a la fecha final.']);
        }

        // Verificar que el rango de fechas no exceda los 7 días
        if ($inicio->diffInDays($final) > 6) {
            return redirect()->back()->withInput()->withErrors(['final' => 'El rango de fechas no puede exceder los 7 días.']);
        }

        // Iterar sobre el rango de fechas y mapearlas con los días de la semana
        $dias = [];
        $currentDate = $inicio->copy();
        while ($currentDate->lte($final)) {
            $dias[] = $currentDate->copy(); // Guardar la fecha actual
            $currentDate->addDay(); // Avanzar al siguiente día
        }

        // Validar que ninguna fecha exceda el rango seleccionado
        foreach ($request->input('subproducto') as $subproducto_id => $subproducto) {
            foreach ($subproducto['valor_kg'] as $dia => $valor_kg) {
                if (!is_null($valor_kg)) {
                    // Calcular la fecha correspondiente al día
                    $dia_numero = (int) str_replace('dia_', '', $dia);
                    $fecha = $inicio->copy()->addDays(($dia_numero - 1 + (7 - $inicioSemana)) % 7);
                    if ($fecha->greaterThan($final)) {
                        return redirect()->back()->withInput()->withErrors(['No puedes capturar datos fuera del rango de fecha seleccionado.']);
                    }
                }
            }
        }

        // Iterar sobre cada subproducto y actualizar sus registros
        foreach ($request->input('subproducto') as $subproducto_id => $subproducto) {
            $nombre = $subproducto['nombre'];
            $valoresKg = $subproducto['valor_kg'];

            // Iterar sobre los días de la semana y actualizar los registros correspondientes
            foreach ($dias as $index => $fecha) {
                // Obtener el día correspondiente de los valores enviados
                $diaKey = 'dia_' . ($index + 1);
                $valorKg = $valoresKg[$diaKey] ?? null;

                $fechaCalculada = $fecha;

                // Buscamos los registros existentes
                $registroExistente = GenSubproducto::where('instituto_id', $instituto_id)
                    ->where('subproducto_id', $subproducto_id)
                    ->whereDate('fecha', $fechaCalculada->toDateString())
                    ->first();

                if ($registroExistente) {
                    if (is_null($valorKg) || $valorKg === '') {
                        // Eliminar el registro si el valor es null o vacío
                        $registroExistente->delete();
                    } else {
                        // Actualizar el registro existente
                        $registroExistente->update([
                            'valor_kg' => $valorKg,
                        ]);
                    }
                } else {
                    if (!is_null($valorKg) && $valorKg !== '') {
                        // Crear un nuevo registro si el valor no es null o vacío
                        GenSubproducto::create([
                            'fecha' => $fecha->toDateString(),
                            'valor_kg' => $valorKg,
                            'instituto_id' => $instituto_id,
                            'subproducto_id' => $subproducto_id,
                        ]);
                    }
                }
            }
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'Los datos se han actualizado con éxito',
        ]);

        return redirect()->route('gensubproductos.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $registros = DB::table('zonas_areas')
            ->join('gen_semanals', 'zonas_areas.id', '=', 'gen_semanals.zonas_areas_id')
            ->join('zonas', 'zonas_areas.zona_id', '=', 'zonas.id')
            ->join('areas', 'zonas_areas.area_id', '=', 'areas.id')
            ->select(
                'zonas.id as zona_id',
                'zonas.nombre as zona',
                'areas.id as area_id',
                'areas.nombre as areaAsignada',
                'gen_semanals.fecha',
                'gen_semanals.turno',
                'gen_semanals.valor_kg'
            )
            ->where(function ($q) use ($query) {
                $q->where('zonas.nombre', 'LIKE', "%{$query}%")
                    ->orWhere('areas.nombre', 'LIKE', "%{$query}%")
                    ->orWhere('gen_semanals.fecha', 'LIKE', "%{$query}%")
                    ->orWhere('gen_semanals.turno', 'LIKE', "%{$query}%");
            })
            ->orderBy('gen_semanals.fecha', 'ASC')
            ->paginate(10) // Esto asegura que sea un Paginator
            ->appends(['query' => $query]); // Mantén el parámetro `query` en la paginación

        if ($request->ajax()) {
            // Devuelve solo la parte de la tabla si es una solicitud AJAX
            return view('gensemanal.partials.table', compact('registros'))->render();
        }

        // Devuelve la vista completa si no es AJAX
        return view('gensemanal.index', compact('registros'));
    }

    public function GenerarPDF(Request $request, $instituto_id, $inicio, $final)
    {

        $inicio = Carbon::parse($inicio);
        $final = Carbon::parse($final);

        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el instituto del usuario autenticado o null si no tiene uno relacionado
            $instituto = Auth::user()->instituto ?? null;
        } else {
            // Redirigir a la página de inicio de sesión si no está autenticado
            return redirect()->route('login')->with('error', 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.');
        }

        // Consulta de datos generados
        $datosGenerados = GenSubproducto::select(
            'subproductos.id as subproducto_id',
            'subproductos.nombre as subproducto_nombre',
            'gen_subproductos.fecha',
            DB::raw('SUM(gen_subproductos.valor_kg) as total_kg')
        )
            ->join('subproductos', 'gen_subproductos.subproducto_id', '=', 'subproductos.id')
            ->whereBetween('gen_subproductos.fecha', [$inicio, $final])
            ->groupBy('subproductos.id', 'subproductos.nombre', 'gen_subproductos.fecha')
            ->orderBy('subproductos.id')
            ->orderBy('gen_subproductos.fecha')
            ->get();

        // Agrupar por subproducto
        $datosAgrupados = $datosGenerados->groupBy('subproducto_nombre');

        // $imagePath = public_path('src/images/itsvalogo.png');
        // $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

        $pdf = Pdf::loadView('gensubproductos.pdf', compact('datosAgrupados', 'inicio', 'final', 'instituto'));
        return $pdf->stream('reporte_subproductos.pdf');
    }


    public function GenerarExcel(Request $request, $instituto_id, $inicio, $final)
    {

        $inicio = Carbon::parse($inicio);
        $final = Carbon::parse($final);

        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el instituto del usuario autenticado o null si no tiene uno relacionado
            $instituto = Auth::user()->instituto ?? null;
        } else {
            // Redirigir a la página de inicio de sesión si no está autenticado
            return redirect()->route('login')->with('error', 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.');
        }

        // Consulta de datos generados
        $datosGenerados = GenSubproducto::select(
            'subproductos.id as subproducto_id',
            'subproductos.nombre as subproducto_nombre',
            'gen_subproductos.fecha',
            DB::raw('SUM(gen_subproductos.valor_kg) as total_kg')
        )
            ->join('subproductos', 'gen_subproductos.subproducto_id', '=', 'subproductos.id')
            ->whereBetween('gen_subproductos.fecha', [$inicio, $final])
            ->groupBy('subproductos.id', 'subproductos.nombre', 'gen_subproductos.fecha')
            ->orderBy('subproductos.id')
            ->orderBy('gen_subproductos.fecha')
            ->get();

        // dd($datosGenerados);

        // $imagePath = public_path('src/images/itsvalogo.png');
        // $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

        return Excel::download(new RegistroSubproductosExport($datosGenerados, $inicio, $final), 'registro-subproductos.xlsx');
    }
}
