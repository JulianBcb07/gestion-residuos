<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Graficas') }}
        </h2>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 mt-10 mb-48">
        <div class="p-6 lg:p-8 bg-black border-b border-gray-200 rounded-md"></div>
        
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


</x-app-layout>
