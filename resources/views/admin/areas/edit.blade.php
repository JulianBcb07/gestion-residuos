<x-admin-layout :breadcrumb="[
    [
        'name' => 'Home',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Areas',
        'url' => route('admin.areas.index'),
    ],
    [
        'name' => $area->nombre,
    ],
]">
    <div class="bg-white shadow rounded-lg p-6">

        <form action="{{ route('admin.areas.update', $area) }}" method="POST">

            @csrf

            @method('PUT')

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre del Area
                </x-label>
                <x-input class="w-full" name="nombre" placeholder="Ingrese el nombre de la zona"
                    value="{{ old('nombre', $area->nombre) }}" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Descripción del Area
                </x-label>

                <x-textarea class="w-full" name="descripcion" placeholder="Sin descripción...">
                    {{ old('descripcion', $area->descripcion) }}
                </x-textarea>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Universidad perteneciente
                </x-label>

                <x-select class="w-full" name="instituto_id" readonly>
                    @foreach ($institutos as $instituto)
                        <option @selected(old('instituto_id', $area->instituto_id)==$instituto->id) value="{{ $instituto->id }}">
                            {{ $instituto->nombre }}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Actualizar Area
                </x-button>

                {{-- Onclick para que al precionarlo se active la funcion y se ejecute el segundo formulario
                para eliminar --}}
                <x-danger-button class="ml-2" onclick="deleteArea()">
                    Eliminar
                </x-danger-button>
            </div>
        </form>

        <form action="{{ route('admin.areas.destroy', $area) }}" method="POST" id="formDelete">

            @csrf
            @method('DELETE')

        </form>

        @push('js')
            <Script>
                function deleteArea() {
                    let form = document.getElementById('formDelete');
                    form.submit();
                }
            </Script>
        @endpush

    </div>

</x-admin-layout>
