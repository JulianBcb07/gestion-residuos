<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Mi Meta Anual') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Meta Actual Card -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Meta Actual</h3>
                                    <span class="inline-flex items-center justify-center p-3 bg-green-500 rounded-full">
                                        <i class="fas fa-chart-line text-xl text-white"></i>
                                    </span>
                                </div>
                                <div class="mt-4">
                                    <p class="text-4xl font-bold text-gray-900">
                                        {{ number_format($instituto->meta_anual, 1) }}</p>
                                    <p class="mt-1 text-sm text-gray-500">Toneladas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Promedio Per Cápita Card -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Promedio Per Cápita diario</h3>
                                    <span class="inline-flex items-center justify-center p-3 bg-blue-500 rounded-full">
                                        <i class="fas fa-chart-column text-xl text-white"></i>
                                    </span>
                                </div>
                                <div class="mt-4">
                                    <p class="text-4xl font-bold text-gray-900">
                                        {{ number_format($promedioPercapita, 2) }} Kg</p>
                                    <p class="mt-1 text-sm text-gray-500">Kg por persona</p>
                                </div>
                            </div>
                        </div>
                        <!-- Total de personas Card -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Total de personas</h3>
                                    <span
                                        class="inline-flex items-center justify-center p-3 bg-yellow-500 rounded-full">
                                        <i class="fas fa-people-group text-xl text-white"></i>
                                    </span>
                                </div>
                                <div class="mt-4">
                                    <p class="text-4xl font-bold text-gray-900">
                                        {{ number_format($instituto->total_personas) }}</p>
                                    <p class="mt-1 text-sm text-gray-500">Personas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        @if ($excedeMeta)
                            <div class="p-4 text-sm text-red-500 rounded-lg bg-red-100 dark:text-blue-400"
                                role="alert">
                                <span class="font-medium">Alerta!</span> ⚠️ ¡Se ha superado la meta anual!
                            </div>
                        @else
                            <div class="p-4 text-sm text-green-500 rounded-lg bg-green-100 dark:text-blue-400"
                                role="alert">
                                <span class="font-medium">Alerta!</span> ✅ Dentro del límite permitido.
                            </div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Zonas con mayor generación</h2>
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-center text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Id</th>
                                        <th scope="col" class="py-3 px-6">Fecha</th>
                                        <th scope="col" class="py-3 px-6">Zona</th>
                                        <th scope="col" class="py-3 px-6">Turno</th>
                                        <th scope="col" class="py-3 px-6">Total generado</th>
                                        {{-- <th scope="col" class="py-3 px-6">Acciones</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registroConMayorGeneracion as $registro)
                                        <tr class="bg-white border-b hover:bg-gray-50 text-center">
                                            <td class="py-4 px-6">{{ $registro->id }}</td>
                                            <td class="py-4 px-6">{{ $registro->fecha }}</td>
                                            <td class="py-4 px-6">{{ $registro->zonaArea->zona->nombre }}</td>
                                            <td class="py-4 px-6">{{ $registro->turno }}</td>
                                            <td class="py-4 px-6">{{ $registro->valor_kg }} kg</td>
                                            {{-- <td class="py-4 px-6">
                                                <a href="#" class="text-blue-600 hover:underline">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $registroConMayorGeneracion->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
