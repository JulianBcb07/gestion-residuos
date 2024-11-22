<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Institutos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // llamar a los datos dependiendo del instituto
        $instituto = auth()->user()->instituto_id;
        $evidenciasGenerado = Image::where('imageable_id', $instituto)
            ->where('imageable_type', Institutos::class)->paginate(5);
        // dd($evidencia);

        return view('evidenciasGenerado.index', compact('evidenciasGenerado'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener los datos del instituto que tiene el usuario relacionado
        $instituto = auth()->user()->instituto;

        // Verificamos si el usuario autenticado ya cuenta con un instituto asociado
        if (!auth()->user()->instituto_id) {
            return redirect()->back()->withErrors(['msg' => 'Para guardar una evidencia necesita tener una universidad asociada.']);
        }

        return view('evidenciasGenerado.create', compact('instituto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos 
        $request->validate([
            'fecha' => 'required|date_format:d/m/Y',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'descripcion' => 'required|string|max:255',
        ]);

        $data = $request->all();
        // Convertir la fecha al formato correcto 
        $data['fecha'] = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');

        // Para subir una imagen
        if ($request->file('image')) {
            $file_name = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $data['url_image'] = $request->file('image')->storeAs('evidencias', $file_name, 'public');
        }

        // Agregar datos polimórficos
        $instituto = auth()->user()->instituto;
        $data['imageable_type'] = Institutos::class;
        $data['imageable_id'] = $instituto->id; // en imageable id ponemos el id del instituto que tiene relacionado el usuario para que asi se filtre por instituto

        // Crear la evidencia del instituto en la base de datos
        $evidenciasGenerado = Image::create($data);


        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'El comprobante se ha registrado con exito',
        ]);

        return redirect()->route('evidenciasGenerado.edit', $evidenciasGenerado);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $evidenciasGenerado)
    {


        return view('evidenciasGenerado.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $evidenciasGenerado)
    {

        $instituto = auth()->user()->instituto;

        // Verificamos si el usuario autenticado y con el rol admin ya tiene una universidad creada
        if (!auth()->user()->instituto_id) {
            return redirect()->back()->withErrors(['msg' => 'Para guardar una evidencia necesita tener una universidad asociada.']);
        }

        // Convertir la fecha al formato d/m/Y antes de pasarla a la vista 
        $evidenciasGenerado->fecha = Carbon::parse($evidenciasGenerado->fecha)->format('d/m/Y');

        return view('evidenciasGenerado.edit', compact('evidenciasGenerado', 'instituto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $evidenciasGenerado)
    {
        $request->validate([
            'fecha' => 'required|date_format:d/m/Y',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'descripcion' => 'required|string|max:255',
        ]);

        $data = $request->all();
        // Convertir la fecha al formato correcto 
        $data['fecha'] = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');

        // Para subir una imagen
        if ($request->file('image')) {
            if ($evidenciasGenerado->url_image) {
                Storage::delete($evidenciasGenerado->url_image);
            }

            $file_name = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $data['url_image'] = $request->file('image')->storeAs('evidencias', $file_name, 'public');
        } else {
            $data['url_image'] = $evidenciasGenerado->url_image;
        }

        $evidenciasGenerado->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'Los datos se han actualizado correctamente!',
        ]);

        return redirect()->route('evidenciasGenerado.edit', $evidenciasGenerado);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $evidenciasGenerado)
    {

        // Eliminar la imagen del almacenamiento
        if ($evidenciasGenerado->url_image) {
            Storage::disk('public')->delete($evidenciasGenerado->url_image);
        }
        $evidenciasGenerado->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'El comprobante ha sido eliminado!',
        ]);

        return redirect()->route('evidenciasGenerado.index');
    }

    public function search(Request $request)
    {
        $instituto = auth()->user()->instituto_id;
        $query = $request->input('query');

        $evidenciasGenerado = Image::where('imageable_id', $instituto)
            ->where('imageable_type', Institutos::class)
            ->where(function ($q) use ($query) {
                $q->where('descripcion', 'LIKE', "%{$query}%")
                    ->orWhere('fecha', 'LIKE', "%{$query}%");
            })
            ->orderByRaw("CASE 
            WHEN descripcion LIKE '{$query}%' THEN 1
            WHEN descripcion LIKE '%{$query}%' THEN 2
            WHEN fecha LIKE '{$query}%' THEN 3
            WHEN fecha LIKE '%{$query}%' THEN 4
            ELSE 5
        END")
            ->paginate(5)
            ->appends(['query' => $query]);

        if ($request->ajax()) {
            // Retornar solo la tabla como respuesta parcial
            return view('evidenciasGenerado.partials.table', compact('evidenciasGenerado'))->render();
        }

        // Retornar vista completa si no es AJAX
        return view('evidenciasGenerado.index', compact('evidenciasGenerado'));
    }
}
