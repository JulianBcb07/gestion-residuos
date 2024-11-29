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
                                        Fecha
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        26/11/2024
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Total generado de las zonas
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        34.55 kg
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Zona con mayor generación
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        Zona 2. A, H, C y D
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:gap-4 sm:px-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Instituto
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0">
                                        Instituto Tecnologico Superior<br>
                                        de Valladolid
                                    </dd>
                                </div>
                                <div class="p-4">
                                    <dt class=" text-sm font-medium text-gray-500 mb-4">
                                        Descargar archivo
                                    </dt>
                                    <div class="flex justify-center gap-4">
                                        <a href="#"
                                            class="bg-red-500 hover:bg-red-600 text-white p-3 rounded shadow">
                                            <i class="fa-solid fa-file-pdf"></i> En PDF
                                        </a>
                                        <a href="#"
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
                                Datos Generados desglozado
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Todos los datos generados de cada zona y area.
                            </p>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                            <div class="p-4">
                                <div class="overflow-hidden rounded-lg border shadow mb-5">
                                    <table class="w-full text-sm leading-5 ">
                                        <thead class="bg-gray-100 ">
                                            <tr>
                                                <th class="py-3 px-4 text-center text-base font-semibold text-gray-600"
                                                    colspan="8">Zona 1. Tal dlfsa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-b border-gray-300">
                                                <td class="py-3 px-4 text-left font-bold">Fecha</td>
                                                <td class="py-3 px-4 text-center">Domingo</td>
                                                <td class="py-3 px-4 text-center">Lunes</td>
                                                <td class="py-3 px-4 text-center">Martes</td>
                                                <td class="py-3 px-4 text-center">Miercoles</td>
                                                <td class="py-3 px-4 text-center">Jueves</td>
                                                <td class="py-3 px-4 text-center">Viernes</td>
                                                <td class="py-3 px-4 text-center">Sabado</td>
                                            </tr>
                                            <tr>
                                                <td class="py-3 px-4 text-left font-bold">Cantidad generada</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="overflow-hidden rounded-lg border shadow mb-5">
                                    <table class="w-full text-sm leading-5 ">
                                        <thead class="bg-gray-100 ">
                                            <tr>
                                                <th class="py-3 px-4 text-center text-base font-semibold text-gray-600"
                                                    colspan="8">Zona 2. sadjasld</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-b border-gray-300">
                                                <td class="py-3 px-4 text-left font-bold">Fecha</td>
                                                <td class="py-3 px-4 text-center">Domingo</td>
                                                <td class="py-3 px-4 text-center">Lunes</td>
                                                <td class="py-3 px-4 text-center">Martes</td>
                                                <td class="py-3 px-4 text-center">Miercoles</td>
                                                <td class="py-3 px-4 text-center">Jueves</td>
                                                <td class="py-3 px-4 text-center">Viernes</td>
                                                <td class="py-3 px-4 text-center">Sabado</td>
                                            </tr>
                                            <tr>
                                                <td class="py-3 px-4 text-left font-bold">Cantidad generada</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="overflow-hidden rounded-lg border shadow mb-5">
                                    <table class="w-full text-sm leading-5 ">
                                        <thead class="bg-gray-100 ">
                                            <tr>
                                                <th class="py-3 px-4 text-center text-base font-semibold text-gray-600"
                                                    colspan="8">Zona 3. jsdajd</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-b border-gray-300">
                                                <td class="py-3 px-4 text-left font-bold">Fecha</td>
                                                <td class="py-3 px-4 text-center">Domingo</td>
                                                <td class="py-3 px-4 text-center">Lunes</td>
                                                <td class="py-3 px-4 text-center">Martes</td>
                                                <td class="py-3 px-4 text-center">Miercoles</td>
                                                <td class="py-3 px-4 text-center">Jueves</td>
                                                <td class="py-3 px-4 text-center">Viernes</td>
                                                <td class="py-3 px-4 text-center">Sabado</td>
                                            </tr>
                                            <tr>
                                                <td class="py-3 px-4 text-left font-bold">Cantidad generada</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                                <td class="py-3 px-4 text-center">240</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Otro ejemplo para mostrar los datos --}}

                </div>
            </div>
        </div>
    </section>
</x-app-layout>
