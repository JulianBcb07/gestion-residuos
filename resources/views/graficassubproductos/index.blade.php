<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Graficas de subproductos') }}
            </h2>
            <div class="flex gap-4 items-center">
                <label class="font-bold">Elija un rango de fecha: </label>
                <button id="dateRangeButton" data-dropdown-toggle="dateRangeDropdown"
                    data-dropdown-ignore-click-outside-class="datepicker" type="button"
                    class="inline-flex items-center text-blue-700 dark:text-blue-600 font-medium hover:underline">
                    Inicio - Final
                    <svg class="w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <div id="dateRangeDropdown"
                    class="z-10 hidden bg-customColor divide-y divide-gray-100 rounded-lg shadow w-80 lg:w-96 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="p-3" aria-labelledby="dateRangeButton">
                        <div date-rangepicker datepicker-autohide class="flex items-center">
                            <div class="relative">
                                <input id="startDate" name="start" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Fecha inicial">
                            </div>
                            <span class="mx-2 text-gray-100 dark:text-gray-400">a</span>
                            <div class="relative">
                                <input id="endDate" name="end" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Fecha final">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Botón para enviar los datos -->
                <button id="submitDates" class="ml-4 bg-blue-500 text-white px-4 py-1 rounded-lg"
                    onclick="fetchAllData()">
                    Actualizar graficas
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 mt-5 mb-10">
        <div class="p-6 lg:p-5 bg-gray-200 border-b border-gray-200 rounded-lg grid grid-cols-6 gap-4">

            {{-- Graficas del top 3 de generacion --}}
            <div class="max-w-8xl w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 col-span-4">
                {{-- Titulo de las graficas --}}
                <div class="flex justify-between items-start">
                    <div class="flex items-center">
                        <div class="flex justify-center items-center mt-3 ml-3 -mb-2">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">
                                Lo mas generado
                            </h5>
                        </div>
                    </div>
                </div>
                {{-- 3 columnas para representar el top --}}
                <div class="grid grid-cols-3 gap-2 mt-3">
                    @foreach ($top3Subproductos as $index => $subproducto)
                        <div class="col-span-1 @if ($index != 2 && $index != 0) border-l-2 border-r-2 -mr-4 @endif">
                            <div class="flex items-center justify-center">
                                <!-- Donut Chart -->
                                <div class="w-40" id="radial-chart-{{ $index + 1 }}"></div>
                                <div>
                                    <h2 class="text-gray-500">
                                        @if ($index == 0)
                                            Primero
                                        @elseif($index == 1)
                                            Segundo
                                        @else
                                            Tercero
                                        @endif
                                    </h2>
                                    <p class="text-3xl font-bold" id="porcentaje-{{ $index + 1 }}">0%</p>
                                    <p class="lg">
                                        {{ $subproducto['nombre'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Grafica al pastel del porcentaje de generacion de subproductos --}}
            <div class="max-w-8xl w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 col-span-2 row-span-2">
                <div class="flex justify-between items-start w-full">
                    <div class="flex-col items-center">
                        <div class="flex items-center mb-1">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">Porcentaje de
                                Generacion</h5>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="py-7" id="pie-chart"></div>

                <div
                    class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button id="dropdownDefaultButton1" data-dropdown-toggle="lastDaysdropdown1"
                            data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button" onclick="toggleDropdown()">
                            <span id="selectedOptionText">Opción Rápida</span>
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="lastDaysdropdown1"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton1">
                                <li>
                                    <a data-time-range="Todo" onclick="selectOption('Todo')"
                                        class="dropdown-option block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Todo</a>
                                </li>
                                <li>
                                    <a data-time-range="7_dias" onclick="selectOption('Últimos 7 Días')"
                                        class="dropdown-option block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Últimos
                                        7 Días</a>
                                </li>
                                <li>
                                    <a data-time-range="30_dias" onclick="selectOption('Últimos 30 días')"
                                        class="dropdown-option block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Últimos
                                        30 días</a>
                                </li>
                                <li>
                                    <a data-time-range="90_dias" onclick="selectOption('Últimos 90 días')"
                                        class="dropdown-option block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Últimos
                                        90 días</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafica de barra de la cantidad generado por los subproductos --}}
            <div class="max-w-8xl w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 col-span-4">
                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                <path
                                    d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                <path
                                    d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Grafica de
                                barras, generacion de subproductos</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Para mostrar más, eliga una
                                opción en la parte inferior.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="column-chart"></div>
                <div
                    class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button id="dropdownDefaultButton2" data-dropdown-toggle="lastDaysdropdown2"
                            data-query="consulta2" data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button" onclick="toggleDropdown2()">
                            <span id="selectedOptionText3">Opción Rápida</span>
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="lastDaysdropdown2"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton2">
                                <li>
                                    <a data-time-range="Todo" onclick="selectOption3('Todo')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer dropdown-option1">Todo</a>
                                </li>
                                <li>
                                    <a data-time-range="7_dias" onclick="selectOption3('Últimos 7 Días')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer dropdown-option1">Últimos
                                        7 Días</a>
                                </li>
                                <li>
                                    <a data-time-range="30_dias" onclick="selectOption3('Últimos 30 días')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer dropdown-option1">Últimos
                                        30 días</a>
                                </li>
                                <li>
                                    <a data-time-range="90_dias" onclick="selectOption3('Últimos 90 días')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer dropdown-option1">Últimos
                                        90 días</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafica del lineas para mostrar la tendencia de generacion --}}
            <div class="max-w-8xl w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 col-span-6">
                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                <path
                                    d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                <path
                                    d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Tendencia de
                                generacion por día</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Leads generated per week
                            </p>
                        </div>
                    </div>
                </div>

                <div id="data-labels-chart"></div>
                <div
                    class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown"
                            data-query="consulta3" data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button" onclick="toggleDropdown()">
                            <span id="selectedOptionText2">Opción Rápida</span>
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="lastDaysdropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a data-time-range="Todo" onclick="selectOption2('Todo')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer dropdown-option2">Todo</a>
                                </li>
                                <li>
                                    <a data-time-range="7_dias" onclick="selectOption2('Últimos 7 Días')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer dropdown-option2">Últimos
                                        7 Días</a>
                                </li>
                                <li>
                                    <a data-time-range="30_dias" onclick="selectOption2('Últimos 30 días')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer dropdown-option2">Últimos
                                        30 días</a>
                                </li>
                                <li>
                                    <a data-time-range="90_dias" onclick="selectOption2('Últimos 90 días')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer dropdown-option2">Últimos
                                        90 días</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafica de columnas para saber cuanto genera cada subproducto por mes --}}
            {{-- <div class="max-w-8xl w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 col-span-3">
                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                <path
                                    d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                <path
                                    d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Grafica de
                                columnas, generacion mensual</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Leads generated per week
                            </p>
                        </div>
                    </div>
                </div>

                <div id="bar-chart"></div>
                <div
                    class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown"
                            data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button">
                            Last 7 days
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="lastDaysdropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                        7 days</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                        30 days</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                        90 days</a>
                                </li>
                            </ul>
                        </div>
                        <a href="#"
                            class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                            Leads Report
                            <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>

    {{-- Se muestra si el usuario no ha guardado datos de generacion en el sistema --}}
    {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10 mb-48">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 gap-6 lg:gap-8 p-6 lg:p-8">
                    <div class="p-4 text-sm text-blue-500 rounded-lg bg-blue-100" role="alert">
                        <span class="font-medium">Alerta!</span> No tienes ningun dato guardado en el sistema
                    </div>
                </div>
            </div>
        </div> --}}

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            // convertir los datos a json
            window.subproductosData = @json($top3Subproductos);

            // Función para abrir/cerrar el dropdown / Grafica pastel
            function toggleDropdown() {
                const dropdown = document.getElementById("lastDaysdropdown1");
                dropdown.classList.toggle("hidden");
            }

            // Función para seleccionar una opción y actualizar el texto del botón
            function selectOption(option) {
                const selectedText = document.getElementById("selectedOptionText");
                selectedText.textContent = option; // Cambia el texto del botón

                // Cierra el dropdown después de seleccionar una opción
                const dropdown = document.getElementById("lastDaysdropdown1");
                dropdown.classList.add("hidden");
            }

            // Cerrar el dropdown si se hace clic fuera del área del dropdown o el botón
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById("lastDaysdropdown1");
                const button = document.getElementById("dropdownDefaultButton1");

                // Si se hace clic fuera del dropdown y el botón, cerramos el dropdown
                if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                    dropdown.classList.add("hidden");
                }
            });

            // Función para abrir/cerrar el dropdown / Grafica de Barra
            function toggleDropdown2() {
                const dropdown = document.getElementById("lastDaysdropdown2");
                dropdown.classList.toggle("hidden");
            }

            // Función para seleccionar una opción y actualizar el texto del botón
            function selectOption3(option) {
                const selectedText = document.getElementById("selectedOptionText3");
                selectedText.textContent = option; // Cambia el texto del botón

                // Cierra el dropdown después de seleccionar una opción
                const dropdown = document.getElementById("lastDaysdropdown2");
                dropdown.classList.add("hidden");
            }

            // Cerrar el dropdown si se hace clic fuera del área del dropdown o el botón
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById("lastDaysdropdown2");
                const button = document.getElementById("dropdownDefaultButton2");

                // Si se hace clic fuera del dropdown y el botón, cerramos el dropdown
                if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                    dropdown.classList.add("hidden");
                }
            });


            // Función para abrir/cerrar el dropdown / Grafica de tendencia
            function toggleDropdown() {
                const dropdown = document.getElementById("lastDaysdropdown");
                dropdown.classList.toggle("hidden");
            }

            // Función para seleccionar una opción y actualizar el texto del botón
            function selectOption2(option) {
                const selectedText = document.getElementById("selectedOptionText2");
                selectedText.textContent = option; // Cambia el texto del botón

                // Cierra el dropdown después de seleccionar una opción
                const dropdown = document.getElementById("lastDaysdropdown");
                dropdown.classList.add("hidden");
            }

            // Cerrar el dropdown si se hace clic fuera del área del dropdown o el botón
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById("lastDaysdropdown");
                const button = document.getElementById("dropdownDefaultButton");

                // Si se hace clic fuera del dropdown y el botón, cerramos el dropdown
                if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                    dropdown.classList.add("hidden");
                }
            });

            // Función para obtener los datos del gráfico desde el servidor
            function fetchAllData() {
                var startDate = document.getElementById('startDate').value;
                var endDate = document.getElementById('endDate').value;

                // Verificar que ambos campos de fecha no estén vacíos
                if (!startDate || !endDate) {
                    alert("Por favor, selecciona un rango de fechas válido.");
                    return;
                }

                // Realiza la solicitud AJAX a la ruta correcta usando fetch
                fetch(`/graficassubproductos/data?tipoGrafico=all&startDate=${startDate}&endDate=${endDate}`, {
                        method: 'GET',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Error en la solicitud');
                        }
                        return response.json();
                    })
                    .then((data) => {
                        // Emitir un evento global para actualizar gráficos
                        document.dispatchEvent(new CustomEvent('updateCharts', {
                            detail: data
                        })); // Llama a una función para renderizar el gráfico
                    })
                    .catch((error) => {
                        console.error('Error en la solicitud AJAX:', error);
                        alert('Hubo un error al obtener los datos.');
                    });
            }

            // Función para renderizar el gráfico
            function renderTrendChart(data) {
                // Aquí deberías agregar tu lógica para renderizar el gráfico
                console.log(data); // Muestra los datos recibidos para verificar
            }
        </script>
    @endpush

    @vite('resources/js/app.js')

</x-app-layout>
