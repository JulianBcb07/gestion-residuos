<x-app-layout>
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Evidencias de valorización') }}
        </h2>
    </x-slot>
        <div class="px-4 pt-8 pb-5 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                {{-- Los apartados de acciones a la tabla --}}
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-5">
                    {{-- Buscador --}}
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center" method="GET" action="">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" name="query"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search" value="{{ old('query', request('query')) }}">
                            </div>
                        </form>
                    </div>
                    {{-- Botones de accion --}}
                    <div x-data="{ tiempo: '{{ request('tiempo', 'semanal') }}' }"
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <a class="flex items-center justify-center bg-blue-700 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none"
                            href="{{ route('evidenciasGenerado.create') }}">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Nuevo Registro
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto p-5" id="table-container">
                    @include('evidenciasGenerado.partials.table', [
                        'evidenciasGenerado' => $evidenciasGenerado,
                    ])
                </div>
            </div>
        </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('simple-search');

                searchInput.addEventListener('input', function() {
                    const query = searchInput.value;

                    fetch(`{{ route('evidenciasGenerado.search') }}?query=${query}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(html => {
                            document.getElementById('table-container').innerHTML = html;
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                });
            });
        </script>
    @endpush





</x-app-layout>
