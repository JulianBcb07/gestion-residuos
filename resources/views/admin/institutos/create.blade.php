<x-admin-layout :breadcrumb="[
    [
        'name' => 'Home',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'MiTecnológico',
        'url' => route('admin.institutos.index'),
    ],
    [
        'name' => 'Crear nuevo',
    ],
]">
    <div class="bg-gray-100">
        <div class="container mx-auto py-8 xl:max-w-full">
            <form action="{{ route('admin.institutos.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">
                    <div class="col-span-4 sm:col-span-3 2xl:col-span-2">
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex flex-col items-center">
                                <figure>
                                    <img class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0"
                                        src="{{ $instituto->logo ?? asset('src/images/placeholder.jpg') }}" alt="Logo del Instituto" id="imgPreview">
                                </figure>
                                <h1 class="text-xl font-bold mb-4">Icono</h1>
                                <div class="mb-4">
                                    <label class="bg-gray-100 px-4 py-2 rounded-lg cursor-pointer">
                                        <i class="fa-solid fa-camera mr-2"></i>
                                        Cargar Imagen
                                        <input type="file" accept="image/*" name="image" class="hidden"
                                            onchange="previewImage(event, '#imgPreview')">
                                    </label>
                                </div>

                                {{-- <img src="{{ asset('src/images/itsvalogo.png') }}"
                                    class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">
                                </img> --}}
                                <p class="text-gray-700">Agregar su logo aqui</p>
                                <div class="mt-6 flex flex-wrap gap-4 justify-center">
                                    {{-- <a href="#"
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Editar</a> --}}
                                    {{-- <a href="#"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Crear
                                        universidad</a> --}}
                                    <x-button>
                                        Crear universidad
                                    </x-button>
                                </div>
                            </div>
                            <hr class="my-6 border-t border-gray-300">
                            <div class="flex flex-col">
                                <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Fecha de
                                    creación</span>
                                <p>Sin fecha de creación</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-4 sm:col-span-9 2xl:col-span-10">
                        <div class="bg-white shadow rounded-lg p-6">
                            <x-validation-errors class="mb-4" />
                            <div class="mb-4">
                                <x-label class="mb-1">
                                    Nombre de la universidad
                                </x-label>
                                <x-input class="w-full" name="nombre" placeholder="Ingrese el nombre de la universidad"
                                    value="{{ old('nombre') }}" />
                            </div>
                            <div class="mb-4">
                                <x-label class="mb-1">
                                    Descripción de la universidad
                                </x-label>
                                <x-textarea class="w-full" name="descripcion" value="{{ old('descripcion') }}" placeholder="Agregar una descripción..">
                                </x-textarea>
                            </div>
                            <div class="mb-4">
                                <x-label class="mb-1">
                                    Dirección
                                </x-label>
                                <x-input class="w-full" name="direccion" placeholder="Ingrese la direccion"
                                    value="{{ old('direccion') }}" />
                            </div>
                            <div class="mb-4">
                                <x-label class="mb-1">
                                    Telefono de contacto
                                </x-label>
                                <x-input class="w-full" name="telefono" placeholder="Ingrese el telefono"
                                    value="{{ old('telefono') }}" />
                            </div>
                            <div class="mb-4">
                                <x-label class="mb-1">
                                    Correo electronico
                                </x-label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                            <path
                                                d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                                            <path
                                                d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                                        </svg>
                                    </div>
                                    <x-input type="email" class="block w-full ps-10 p-2.5 " name="correo"
                                        placeholder="name@name.com" value="{{ old('correo') }}" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <x-label class="mb-1">
                                    Sitio Web
                                </x-label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                            <path
                                                d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                                            <path
                                                d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                                        </svg>
                                    </div>
                                    <x-input class="block w-full ps-10 p-2.5 " name="sitio_web" placeholder="tecnm.com.mx"
                                        value="{{ old('sitio_web') }}" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <x-label class="mb-1">
                                    Meta Anual
                                </x-label>
                                <x-input type="number" step="0.01" class="w-full" name="meta_anual"
                                    placeholder="Ingrese la meta anual de la universidad" value="{{ old('meta_anual') }}" />
                            </div>
                            <div class="mb-4">
                                <x-label class="mb-1">
                                    Total personas
                                </x-label>
                                <x-input type="number" class="w-full" name="total_personas"
                                    placeholder="Ingrese el total de personas en la universidad" value="{{ old('total_personas') }}" />
                            </div>
                        </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            function previewImage(event, querySelector) {

                //Recuperamos el input que desencadeno la acción
                const input = event.target;

                //Recuperamos la etiqueta img donde cargaremos la imagen
                $imgPreview = document.querySelector(querySelector);

                // Verificamos si existe una imagen seleccionada
                if (!input.files.length) return

                //Recuperamos el archivo subido
                file = input.files[0];

                //Creamos la url
                objectURL = URL.createObjectURL(file);

                //Modificamos el atributo src de la etiqueta img
                $imgPreview.src = objectURL;

            }
        </script>
    @endpush

</x-admin-layout>
