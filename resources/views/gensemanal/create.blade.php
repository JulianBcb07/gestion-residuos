<x-app-layout>
    <div
        class="px-4 pt-8 pb-5 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8flex items-center justify-center">
        <div
            class="bg-white px-4 py-5  mx-auto rounded-lg sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 shadow">
            <div class="border-b-2 mb-4">
                <h2 class="font-semibold text-xl text-gray-600">Generación Semanal de residuos solidos en el
                    {{ $instituto->nombre }}
                </h2>
                <p class="text-lg text-gray-500 mb-4">Es importante contar con la bitacora de generación semanal para
                    poder
                    capturar lo que se generó durante la semana.</p>
            </div>
            <div>
                <form action="{{ route('gensemanal.store') }}" method="POST">

                    @csrf
                    <x-validation-errors class="mb-4" />

                    {{-- Datos generales (Primer apartado) --}}
                    <div class="text-gray-600 mb-2">
                        <p class="text-lg font-bold">Datos generales</p>
                        <p class="mb-3">Seleccione la semana de recolección.</p>
                    </div>
                    <div class="flex justify-between content-center border-b-2 py-4 mb-4">
                        <div class="w-1/2 px-2 mb-4">
                            <x-label class="mb-2">
                                Fecha de Registro
                            </x-label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input id="datepicker-autohide" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" name='fecha'
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Seleccionar fecha" value="{{ old('fecha') }}">
                            </div>
                        </div>
                        <div class="w-1/2 px-2 mb-4"> <!-- Agregamos px-2 para un pequeño margen entre los divs -->
                            <x-label class="mb-2">
                                Turno de la generacion
                            </x-label>
                            <div class="relative">
                                <x-select class="w-full" name="turno">
                                    <option disabled>
                                        -- Seleccione un turno --
                                    </option>
                                    <option value="Matutino">
                                        Matutino
                                    </option>
                                    <option value="Vespertino">
                                        Vespertino
                                    </option>
                                </x-select>
                            </div>
                        </div>
                        <div class="w-full px-2 mb-4"> <!-- Agregamos px-2 para un pequeño margen entre los divs -->
                            <x-label class="mb-2">
                                Instituto Asignado
                            </x-label>
                            <div class="relative">
                                <x-input name="instituto" value="{{ $instituto->nombre ?? old('instituto') }}" readonly
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                            </div>
                        </div>
                    </div>


                    {{-- Inicio bitacora de generacion semanal (Cada zona con sus areas) --}}
                    <p class="text-lg font-bold">Bitacora de generacion semanal</p>
                    <p class="mb-3">Todos los valores de esta seccion son numericos y se interpreta como kg*.</p>
                    @foreach ($zona_areas as $zonaId => $areas)
                        <div class="text-gray-600 mb-2">
                            <p class="text-lg font-bold mb-4">
                                {{-- $zonaId --}} {{ $areas->first()->zona_nombre }}
                            </p>
                        </div>
                        <div class="grid grid-cols-4 mb-4 border-b-2 pb-4">
                            @foreach ($areas as $area)
                                <div class="mb-4 col-span-1">
                                    <x-label class="mb-2">
                                        {{ $area->area_nombre }}
                                    </x-label>
                                    <x-input placeholder="0kg" name="valor_kg[{{ $zonaId }}][{{ $area->area_id }}]" value="{{ old('valor_kg.' . $zonaId . '.' . $area->area_id)}}"/>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="flex justify-between items-baseline pt-4">
                        <div class="flex items-center mb-4">
                            <input id="default-checkbox" type="checkbox" value="" required
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-checkbox" class="ms-2 text-gray-900 dark:text-gray-300">Confirmo
                                que la informacion es correcta</label>
                        </div>
                        <x-button>
                            Crear nuevo registro
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
