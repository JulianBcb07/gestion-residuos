<x-app-layout>
    <!-- component -->
    <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
        <div class="px-4 pt-5 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
            <div>
                <h2 class="font-semibold text-xl text-gray-600">Generación Semanal de Subproductos en el
                    {{ $instituto->nombre }}</h2>
                <p class="text-lg text-gray-500 mb-6">Es importante contar con la bitacora de subproductos para poder
                    capturar lo
                    que se generó durante la semana.</p>

                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                    <div>
                        <div class="text-gray-600 mb-4">
                            <p class="font-medium text-lg">Detalles de generación</p>
                            <p>Seleccione la semana de recolección.</p>
                        </div>

                        <div id="date-range-picker" date-rangepicker class="flex items-center mb-4 space-x-4"">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input id="datepicker-range-start" name="start" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                    placeholder="Select date start">
                            </div>
                            <span class="mx-4 text-gray-500">A</span>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input id="datepicker-range-end" name="end" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                    placeholder="Select date end">
                            </div>
                            <div class="relative">
                                <span>No Semana: </span>
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <div class="grid gap-2 gap-y-2 text-sm grid-cols-1 md:grid-cols-9">
                                <div class="md:col-span-2 bg-yellow-400 text-center text-lg p-1 mb-1">
                                    <span>Subproductos</span>
                                </div>
                                @for ($i = 1; $i <= 7; $i++)
                                    <div class="md:col-span-1 bg-blue-600 text-center text-lg text-gray-100 p-1 mb-1">
                                        <span>Día {{ $i }}</span>
                                    </div>
                                @endfor

                                @foreach ($subproductos as $subproducto)
                                    <div class="md:col-span-2 mb-1">
                                        <x-label>
                                            <x-input class="w-full" readonly name="subproducto[{{ $subproducto->id }}][nombre]"
                                                placeholder="Nombre del Subproducto"
                                                value="{{ $subproducto->nombre }}" />
                                        </x-label>
                                    </div>
                                    @for ($i = 1; $i <= 7; $i++)
                                        <div class="md:col-span-1 mb-1">
                                            <x-label>
                                                <x-input class="w-full"
                                                    name="subproducto[{{ $subproducto->id }}][dia_{{ $i }}]"
                                                    placeholder="Valor_kg" value="" />
                                            </x-label>
                                        </div>
                                    @endfor
                                @endforeach
                                <div class="md:col-span-2 bg-green-400 text-center text-lg p-1 mb-1">
                                    <span>Total</span>
                                </div>
                                @for ($dia = 1; $dia <= 7; $dia++)
                                    <div class="md:col-span-1 bg-gray-200 text-center text-lg p-1">
                                        <span id="total-dia-{{ $dia }}">0</span> kg
                                    </div>
                                @endfor
                            </div>
                            <div class="text-right mt-4">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
