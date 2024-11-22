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
        'name' => 'Nueva Zona',
    ],
]">
    <div class="bg-white shadow rounded-lg p-6">

        <form action="{{ route('admin.zonas.store') }}" method="POST">

            @csrf

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre de la zona
                </x-label>
                <x-input class="w-full" name="nombre" placeholder="Ingrese el nombre de la zona"
                    value="{{ old('nombre') }}" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Descripción de la zona
                </x-label>

                <x-textarea class="w-full" name="descripcion" placeholder="Sin descripción...">
                    {{ old('descripcion', isset($zona) ? $zona->descripcion : '') }}
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

            <div class="mb-4">
                <ul>
                    @foreach($areas as $area)
                        <li>
                            <label>
                                <x-checkbox name='areas[]' value="{{$area->id}}" :checked="in_array($area->id, old('areas', []))" />
                                {{$area->nombre}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Crear Zona
                </x-button>
            </div>
        </form>

    </div>

</x-admin-layout>
