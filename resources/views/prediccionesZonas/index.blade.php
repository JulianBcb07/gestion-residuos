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
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Gráfico de Predicciones</h2>
                    <div id="semanal-chart" class="w-full h-96 mb-8"></div>
                </div>
            </div>

            <!-- Tabla de Datos -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Datos de Predicciones</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zona</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2024</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2025</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2026</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2027</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2028</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Zona 1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">34kg</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">36kg</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">38kg</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">40kg</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">42kg</td>
                                </tr>
                                <!-- Añade más filas según sea necesario -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
</x-app-layout>