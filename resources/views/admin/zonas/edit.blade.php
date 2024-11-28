<x-admin-layout :breadcrumb="[
    [
        'name' => 'Home',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Zonas',
        'url' => route('admin.zonas.index'),
    ],
    [
        'name' => $zona->nombre,
    ],
]">
    <div class="bg-white shadow rounded-lg p-6">

        <form action="{{ route('admin.zonas.update', $zona) }}" method="POST">

            @csrf

            @method('PUT')

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre de la zona
                </x-label>
                <x-input class="w-full" name="nombre" placeholder="Ingrese el nombre de la zona"
                    value="{{ old('nombre', $zona->nombre) }}" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Descripción de la zona
                </x-label>

                <x-textarea class="w-full" name="descripcion" placeholder="Sin descripción...">
                    {{ old('descripcion', $zona->descripcion) }}
                </x-textarea>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Universidad perteneciente
                </x-label>

                <x-select class="w-full" name="instituto_id" readonly>
                    @foreach ($institutos as $instituto)
                        <option @selected(old('instituto_id', $zona->instituto_id)==$instituto->id) value="{{ $instituto->id }}">
                            {{ $instituto->nombre }}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <ul>
                    @foreach($areas as $area)
                        <li>
                            <label>
                                <x-checkbox name='areas[]' value="{{$area->id}}" 
                                    :checked="in_array($area->id, old('areas', $zona->areas->pluck('id')->toArray()))" />
                                {{$area->nombre}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Actualizar Zona
                </x-button>

                {{-- Onclick para que al precionarlo se active la funcion y se ejecute el segundo formulario
                para eliminar --}}
                <x-danger-button class="ml-2" onclick="deleteZona()">
                    Eliminar
                </x-danger-button>
            </div>
        </form>

        <form action="{{ route('admin.zonas.destroy', $zona) }}" method="POST" id="formDelete">

            @csrf
            @method('DELETE')

        </form>

        @push('js')
            <Script>
                function deleteZona() {
                    let form = document.getElementById('formDelete');
                    form.submit();
                }
            </Script>
        @endpush

    </div>

</x-admin-layout>
