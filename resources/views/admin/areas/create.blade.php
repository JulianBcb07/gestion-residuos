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
        'name' => 'Nueva Area',
    ],
]">
    <div class="bg-white shadow rounded-lg p-6">

        <form action="{{ route('admin.areas.store') }}" method="POST">

            @csrf

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre del Area
                </x-label>
                <x-input class="w-full" name="nombre" placeholder="Ingrese el nombre del Area"
                    value="{{ old('nombre') }}" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Descripción del Area
                </x-label>

                <x-textarea class="w-full" name="descripcion" placeholder="Sin descripción...">
                    {{ old('descripcion', isset($area) ? $area->descripcion : '') }}
                </x-textarea>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Universidad perteneciente
                </x-label>

                <x-select class="w-full" name="instituto_id" readonly>
                    @foreach ($institutos as $instituto)
                        <option @selected(old('instituto_id') == $instituto->id) value="{{ $instituto->id }}">
                            {{ $instituto->nombre }}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Crear Area
                </x-button>
            </div>
        </form>

    </div>

</x-admin-layout>
