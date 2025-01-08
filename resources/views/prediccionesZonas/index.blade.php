<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Predicciones de Generación de Residuos</h1>

            <!-- Resumen de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Residuos 2024</h3>
                    <p class="text-3xl font-bold text-blue-600">256 kg</p>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Crecimiento Anual</h3>
                    <p class="text-3xl font-bold text-green-600">+0.3%</p>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Zona con más Generación</h3>
                    <p class="text-3xl font-bold text-purple-600">Zona 3</p>
                </div>
            </div>

            <!-- Filtros  (implementar a futuro) -->
            {{-- <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Filtros</h2>
                <div class="flex flex-wrap gap-4">
                    <select class="form-select rounded-md shadow-sm mt-1 block w-full" id="zone-filter">
                        <option>Todas las Zonas</option>
                        <option>Zona 1</option>
                        <option>Zona 2</option>
                        <option>Zona 3</option>
                    </select>
                    <select class="form-select rounded-md shadow-sm mt-1 block w-full" id="time-filter">
                        <option>Semanal</option>
                        <option>Mensual</option>
                        <option>Anual</option>
                    </select>
                </div>
            </div> --}}

            <!-- Gráficos -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-6 pb-0 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Gráfico de Predicciones</h2>
                        <x-select id="zonaSelect" class="mb-4">
                            @foreach ($zonas as $zona)
                                <option @selected(request('zona_id') == $zona->id) value="{{ $zona->id }}">
                                    {{ $zona->nombre }}
                                </option>
                            @endforeach
                        </x-select>
                </div>
                <div class="px-6">
                    <div id="semanal-chart" class="w-full h-96 mb-8"></div>
                </div>
            </div>

{{-- <!-- Tabla de Datos -->
<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Datos de Predicciones</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zona</th>
                        @for ($i = 1; $i <= 7; $i++)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha {{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($zonas as $zona)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $zona->nombre }}</td>
                            @if (isset($predicciones[$zona->id]))
                                @foreach ($predicciones[$zona->id] as $prediccion)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $prediccion['total_kg'] }}kg</td>
                                @endforeach
                            @else
                                @for ($i = 1; $i <= 7; $i++)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">N/A</td>
                                @endfor
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> --}}

        </div>
    </div>

    @vite('resources/js/app.js')
</x-app-layout>
