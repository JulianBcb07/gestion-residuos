<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institutos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstitutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instituto = auth()->user()->instituto;

        return view('admin.institutos.index', compact('instituto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.institutos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificamos si el usuario autenticado y con el rol admin ya tiene una universidad creada
        if (auth()->user()->instituto_id) {
            return redirect()->back()->withErrors(['msg' => 'Ya tienes un instituto asignado y no puedes crear otra universidad.']);
        }

        // Validamos y creamo el instituto
        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'image' => 'nullable|image',
            'telefono' => 'nullable',
            'email' => 'nullable',
            'sitio_web' => 'nullable',
            'meta_anual' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/', // Permite 2 decimales depues del punto
                'numeric', // Asegura que el valor sea un número
                'max:100' // Limita el número entero a un máximo de 1000
            ],
            'total_personas' => 'nullable|integer',
        ]);

        $data = $request->all();

        // Para subir una imagen
        if ($request->file('image')) {
            $file_name = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $data['logo'] = $request->file('image')->storeAs('university-icons', $file_name);
        }
        //posts/image.jpg

        // $img = Image::make('storage/' . $data['image_path']);
        // $img->resize(1200);
        // $img->save();

        // Crear el instituto en la base de datos
        $instituto = Institutos::create($data);

        // Le asignamos el ID del instituto recien creado al usuario autenticado.
        $user = auth()->user();
        $user->instituto_id = $instituto->id;
        $user->save();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'La universidad se ha creado con exito',
        ]);

        return redirect()->route('admin.institutos.edit', $instituto);
    }

    /**
     * Display the specified resource.
     */
    public function show(Institutos $instituto)
    {
        // Llamar a los datos del Instituto para mostrar como tipo perfil
        return view('admin.institutos.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institutos $instituto)
    {
        return view('admin.institutos.edit', compact('instituto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institutos $instituto)
    {
        // Ponemos la validacion necesario para la tabla excluyendo el id que estamos editando
        $request->validate([
            'nombre' => 'required',
            'unique:institutos,nombre, ' . $instituto->id,
            'direccion' => 'required',
            'image' => 'nullable|image',
            'telefono' => 'nullable',
            'email' => 'nullable',
            'sitio_web' => 'nullable',
            'meta_anual' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/', // Permite 2 decimales depues del punto
                'numeric', // Asegura que el valor sea un número
                'max:100' // Limita el número entero a un máximo de 1000
            ],
            'total_personas' => 'nullable|integer',
        ]);

        $data = $request->all();

        // Para subir una imagen
        if ($request->file('image')) {

            if ($instituto->image_path) {
                Storage::delete($instituto->image_path);
            }

            $file_name = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            // $data['image_path'] = Storage::putFileAs('posts', $request->image, $file_name);
            $data['logo'] = $request->file('image')->storeAs('university-icons', $file_name);
        }

        $instituto->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Hecho!',
            'text' => 'Los datos de su universidad se han actualizado correctamente!',
        ]);

        return redirect()->route('admin.institutos.edit', $instituto);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institutos $instituto) // Cambio aquí
    {
        //
    }
}
