<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mi Meta Anual') }}
            </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 mb-10">
        <div class="p-6 lg:p-5 bg-gray-200 border-b border-gray-200 rounded-lg">
            <!-- component -->
            <div class="flex items-center justify-center">
                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                    <!-- 1 card -->
                    <div class="relative bg-white py-6 px-6 rounded-3xl w-80 my-4 shadow-xl">
                        <div
                            class=" text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-green-500 left-4 -top-6">
                            <!-- svg  -->
                            <i class="fa-solid fa-chart-line text-3xl"></i>
                        </div>
                        <div class="mt-8">
                            <p class="text-xl font-semibold my-2">Meta Actual</p>
                            <div class="flex items-center space-x-2 text-gray-500 text-sm">
                                <i class="fa-solid fa-arrow-right text-3xl"></i>
                                <p class="text-5xl">3.5</p>
                            </div>
                            <div class="border-t-2"></div>
                        </div>
                    </div>

                    <!-- 3 card -->
                    <div class="relative bg-white py-6 px-6 rounded-3xl w-80 my-4 shadow-xl">
                        <div
                            class=" text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-blue-500 left-4 -top-6">
                            <i class="fa-solid fa-chart-column text-3xl"></i>
                        </div>
                        <div class="mt-8">
                            <p class="text-xl font-semibold my-2">Promedio Per Cápita</p>
                            <div class="flex items-center space-x-2 text-gray-500 text-sm">
                                <i class="fa-solid fa-arrow-right text-3xl"></i>
                                <p class="text-5xl">0.1256</p>
                            </div>
                            <div class="border-t-2 "></div>
                        </div>
                    </div>

                    <!-- 4 card -->
                    <div class="relative bg-white py-6 px-6 rounded-3xl w-80 my-4 shadow-xl">
                        <div
                            class=" text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-yellow-500 left-4 -top-6">
                            <i class="fa-solid fa-people-group text-3xl"></i>
                        </div>
                        <div class="mt-8">
                            <p class="text-xl font-semibold my-2">Total de personas</p>
                            <div class="flex items-center space-x-2 text-gray-500 text-sm">
                                <i class="fa-solid fa-arrow-right text-3xl"></i>
                                <p class="text-5xl">1460</p>
                            </div>
                            <div class="border-t-2 "></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-2">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <h1 class="font-bold">Generacion Superior al promedio</h1>
                </div>
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
                    <thead
                        class="text-xs text-center text-gray-800 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Id</th>
                            <th scope="col" class="px-4 py-3">Fecha</th>
                            <th scope="col" class="px-4 py-3">Zona</th>
                            <th scope="col" class="px-4 py-3">Turno</th>
                            <th scope="col" class="px-4 py-3">Total generado</th>
                            <th scope="col" class="px-4 py-3">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <th class="px-4 py-3">1</th>
                            <td class="px-4 py-3">26/11/2024</td>
                            <td class="px-4 py-3">Zona 1. A, B, C</td>
                            <td class="px-4 py-3">Matutino</td>
                            <td class="px-4 py-3">45.4 kg</td>
                            <td class="px-4 py-3">
                                <a href="">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3">1</th>
                            <td class="px-4 py-3">28/11/2024</td>
                            <td class="px-4 py-3">Zona 3. C, D, F</td>
                            <td class="px-4 py-3">Matutino</td>
                            <td class="px-4 py-3">54.9 kg</td>
                            <td class="px-4 py-3">
                                <a href="">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3">1</th>
                            <td class="px-4 py-3">28/11/2024</td>
                            <td class="px-4 py-3">Zona 1. A, B, C</td>
                            <td class="px-4 py-3">Matutino</td>
                            <td class="px-4 py-3">32.4 kg</td>
                            <td class="px-4 py-3">
                                <a href="">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
