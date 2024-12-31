<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <x-application-mark class="w-40 mx-auto mt-4" />
        <h1 class="text-4xl font-bold text-center my-8">Sistema de Monitoreo de Residuos Sólidos Institucionales del
            TECNM Campus Valladolid</h1>

        <section class="mb-12">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4">
                    <h2 class="text-xl font-semibold mb-2">Nuestra Objetivo</h2>
                    <p class="text-gray-700 text-lg">
                        El Sistema de Monitoreo de Residuos Sólidos Institucionales del TECNM Campus Valladolid tiene
                        como objetivo optimizar el manejo de residuos en nuestra institución educativa, mejorando los
                        procesos de captura y análisis de datos sobre la generación de residuos. A través de la
                        identificación de los principales puntos de generación, se busca implementar estrategias que
                        reduzcan las cantidades generadas y fomentar la conciencia ambiental en toda la comunidad
                        tecnológica.
                    </p>
                </div>
            </div>
        </section>

        <section class="mb-12">
            <h2 class="text-3xl font-semibold mb-6">Características Principales</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $features = [
                        [
                            'title' => 'Visualización de Datos',
                            'description' =>
                                'Gráficos interactivos que facilitan la comprensión de los patrones de generación de residuos por zonas y por subproductos.',
                            'icon' => 'chart-pie',
                        ],
                        [
                            'title' => 'Predicciones',
                            'description' =>
                                'Se utilizarón predicicones básicas para ver una posible generación futura. Es recomendable obtener más datos para predicciones más precisas.',
                            'icon' => 'chart-bar',
                        ],
                        [
                            'title' => 'Informes Personalizados',
                            'description' =>
                                'Genere informes de los datos recopilados en la aplicación en formatos PDF y EXCEL.',
                            'icon' => 'document-text',
                        ],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="px-6 py-4">
                            <div class="flex items-center mb-2">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    @if ($feature['icon'] === 'chart-bar')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    @elseif ($feature['icon'] === 'chart-pie')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    @endif
                                </svg>
                                <h3 class="text-xl font-semibold">{{ $feature['title'] }}</h3>
                            </div>
                            <p class="text-gray-700">{{ $feature['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-12">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4">
                    <div class="flex items-center mb-2">
                        <svg class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h2 class="text-xl font-semibold">Beneficios para el TecNM</h2>
                    </div>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        <li>Mejora en la eficiencia de la gestión de residuos</li>
                        <li>Mejora la Visualización de la generación de residuos en la institución</li>
                        <li>Mejora el control de datos de la generación de residuos en la institución</li>
                        <li>Reducción del impacto ambiental en la comunidad tecnológica</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="mb-12">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4">
                    <h2 class="text-xl font-semibold mb-2">Mapa de zonas de generación</h2>
                    {{-- <p class="text-gray-700 text-lg mb-4">
                        El TecNM se compromete a ser líder en prácticas sostenibles dentro del sector educativo.
                        Esta aplicación es un paso más hacia nuestro objetivo de crear campus más verdes y
                        formar profesionales conscientes del medio ambiente.
                    </p> --}}
                    <p class="text-gray-700 text-lg mb-4">
                        El TecNM Campus Valladolid presenta el mapa de las zonas de generación de residuos dentro de la
                        institución, con el propósito de identificar y gestionar eficientemente las zonas y áreas clave,
                        facilitando así el uso adecuado de la aplicación."
                    </p>
                    <div class="flex justify-center">
                        <img src="{{ asset('src/images/croquisTecNM.jpg') }}" alt="Campus sostenible del TecNM"
                            class="rounded-lg max-w-full h-auto" width="600" height="300">
                    </div>
                </div>
            </div>
        </section>


        {{-- Para solicitar el uso de la aplicacion en otras instituciones (a futuro) --}}
        {{-- <section class="text-center">
            <h2 class="text-3xl font-semibold mb-6">¿Listo para implementar en tu campus?</h2>
            <a href="#"
                class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Solicitar Implementación
                <svg class="inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>
        </section> --}}
    </div>
</x-app-layout>
