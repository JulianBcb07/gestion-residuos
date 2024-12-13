<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Graficas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <x-application-logo class="block h-20 w-20" />
                </div>

                @unless (Auth::user()->hasRole('Participante'))
                    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                        <div>
                            <div class="flex items-center">
                                <i class="fa-solid fa-chart-pie text-gray-400"></i>
                                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                                    <p>Graficas de la generación semanal</p>
                                </h2>
                            </div>

                            <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                Ingresa al formulario para capturar los datos generados de residuos sólidos en la semana con
                                ayuda de las
                                bitácoras de generación proporcionadas por el TECNM.
                            </p>

                            <p class="mt-4 text-sm">
                                <a href="{{ route('graficassemanal.index') }}"
                                    class="inline-flex items-center font-semibold text-indigo-700">
                                    Ir a graficas

                                    <svg viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                                        <path fill-rule="evenodd"
                                            d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </p>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <i class="fa-solid fa-chart-pie text-gray-400"></i>
                                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                                    <p>Graficas de la generación de subprodcutos</p>
                                </h2>
                            </div>

                            <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                Ingresa al formulario para capturar la cantidad de subprodcutos generados en la separación
                                de los residuos
                                sólidos con potencial a valorización.
                            </p>

                            <p class="mt-4 text-sm">
                                <a href="{{ route('graficassubproductos.index') }}"
                                    class="inline-flex items-center font-semibold text-indigo-700">
                                    Ir a graficas

                                    <svg viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                                        <path fill-rule="evenodd"
                                            d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-200 bg-opacity-25 gap-6 lg:gap-8 p-6 lg:p-8">
                        <div class="p-4 text-sm text-blue-500 rounded-lg bg-blue-50" role="alert">
                            <span class="font-medium">Alerta!</span> Para continuar necesitas que un administrador te de
                            acceso a estos
                            apartados.
                        </div>
                    </div>
                @endunless
            </div>
        </div>
    </div>
</x-app-layout>
