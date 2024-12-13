<x-app-layout>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <div class="px-4 pt-5 pb-5 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="grid grid-cols-4 gap-4 p-4">
                    {{-- Ejemplo de una tabla show --}}
                    <div class="bg-white overflow-hidden shadow rounded-lg border col-span-1">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Datos Generados
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Resumen de los datos generados en la universidad.
                            </p>
                        </div>
                        <div class="border-t border-gray-200 px-3 py-5 sm:p-0">
                            <dl class="sm:divide-y sm:divide-gray-200">
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Fecha inicio:
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        {{ $inicio->format('d/m/Y') }}
                                    </dd>
                                    <dt class="text-sm font-medium text-gray-500">
                                        Fecha final:
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        {{ $final->format('d/m/Y') }}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Total generado de subproductos
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        @php
                                            $totalGenerado = $datosAgrupados->flatten()->sum('total_kg');
                                        @endphp
                                        {{ number_format($totalGenerado, 2) }} kg
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Subproducto con mayor generación
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        @php
                                            $subproductoMayor = $datosAgrupados
                                                ->flatten()
                                                ->sortByDesc('total_kg')
                                                ->first();
                                        @endphp
                                        {{ $subproductoMayor ? $subproductoMayor->subproducto_nombre : 'No disponible' }}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:gap-4 sm:px-4">
                                    <dt class="text-sm font-medium text-gray-500 mb-2">
                                        Instituto
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0">
                                        {{ $instituto->nombre }}
                                    </dd>
                                </div>
                                <div class="p-4">
                                    <dt class=" text-sm font-medium text-gray-500 mb-4">
                                        Descargar archivo
                                    </dt>
                                    <div class="flex justify-center gap-4">
                                        <a href="{{ route('gensubproductos.pdf', ['instituto_id' => $instituto->nombre, 'inicio' => $inicio->format('Y-m-d'), 'final' => $final->format('Y-m-d')]) }}"
                                            target="_blank"
                                            class="bg-red-500 hover:bg-red-600 text-white p-3 rounded shadow">
                                            <i class="fa-solid fa-file-pdf"></i> En PDF
                                        </a>
                                        <a href="{{ route('gensubproductos.excel', ['instituto_id' => $instituto->nombre, 'inicio' => $inicio->format('Y-m-d'), 'final' => $final->format('Y-m-d')]) }}"
                                            class="bg-green-500 hover:bg-green-600 text-white p-3 rounded shadow">
                                            <i class="fa-solid fa-file-excel"></i> En Excel
                                        </a>
                                    </div>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg border col-span-3">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Datos Generados desglosados
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Todos los datos generados de Subproductos
                            </p>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-0 max-h-[500px] overflow-y-auto">
                            {{-- Aqui dentro de este contenedor debes poner el scrollbar vertical para que la pagina no se alargue demasiado si hay muchos datos --}}
                            <div class="p-4">
                                @foreach ($datosAgrupados as $subproducto => $datos)
                                    <div class="overflow-hidden rounded-lg border shadow mb-5">
                                        <table class="w-full text-sm leading-5">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="py-3 px-4 text-center text-base font-semibold text-gray-600"
                                                        colspan="8">{{ $subproducto }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Fila de Fechas -->
                                                @php
                                                    $fechaChunks = array_chunk($datos->pluck('fecha')->toArray(), 6);
                                                    $cantidadChunks = array_chunk(
                                                        $datos->pluck('total_kg')->toArray(),
                                                        6,
                                                    );
                                                @endphp
                                                @foreach ($fechaChunks as $index => $fechaChunk)
                                                    <tr class="border-t border-gray-300">
                                                        <td class="py-3 px-4 text-left font-bold">Fecha:</td>
                                                        @foreach ($fechaChunk as $fecha)
                                                            <td class="py-3 px-4 text-left">
                                                                {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                                                            </td>
                                                        @endforeach
                                                        <!-- Rellenar celdas vacías si la fila tiene menos de 6 columnas -->
                                                        @foreach (array_pad($fechaChunk, 6, '') as $fecha)
                                                            @if ($fecha === '')
                                                                <td class="py-3 px-4 text-left"></td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="py-3 px-4 text-left font-bold">Cantidad Generada:
                                                        </td>
                                                        @foreach ($cantidadChunks[$index] as $cantidad)
                                                            <td class="py-3 px-4 text-left">{{ $cantidad }}</td>
                                                        @endforeach
                                                        <!-- Rellenar celdas vacías si la fila tiene menos de 6 columnas -->
                                                        @foreach (array_pad($cantidadChunks[$index], 6, '') as $cantidad)
                                                            @if ($cantidad === '')
                                                                <td class="py-3 px-4 text-left"></td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
