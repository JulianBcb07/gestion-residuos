<x-app-layout>
    <div class="px-4 pt-5 pb-5 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
        <div class="bg-white rounded-lg p-10">
            <h1 class="text-2xl font-semibold border-b-2 p-2 mb-4">
                Nueva evidencia
            </h1>


            <form action="{{ route('evidenciasGenerado.update', $evidenciasGenerado) }}" method="POST"
                enctype="multipart/form-data">

                {{-- token por formulario --}}
                @csrf

                @method('PUT')

                <x-validation-errors class="mb-4" />

                <div class="flex justify-between mb-4 border-b-2 pb-4">
                    <div class="w-1/2 px-2"> <!-- Agregamos px-2 para un pequeño margen entre los divs -->
                        <X-label>
                            Fecha de Evidencia:
                        </X-label>
                        {{-- Selector de fecha para capturar evidencias --}}
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-autohide" datepicker datepicker-autohide type="text" name="fecha" datepicker datepicker-format="dd/mm/yyyy"
                                value="{{ old('fecha', $evidenciasGenerado->fecha) }}"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Elegir fecha">
                        </div>
                    </div>

                    <div class="w-1/2 px-2"> <!-- Agregamos px-2 para un pequeño margen entre los divs -->
                        <X-label>
                            Instituto Asignado:
                        </X-label>
                        <div class="mt-2">
                            <x-input name="instituto" value="{{ $instituto->nombre ?? old('instituto') }}"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                    </div>
                </div>

                <h1 class="text-2xl font-semibold mb-2">
                    Ingresar comprobante
                </h1>

                <p class="text-sm font-semibold text-lime-500 mb-4">Ingrese la imagen del comprobante en la parte
                    inferior*</p>

                <div class="mb-6 relative">
                    <figure>
                        <img class="aspect-[3/1] object-cover object-center w-full"
                            src="{{ Storage::url($evidenciasGenerado->url_image) }}" alt="" id="imgPreview">
                    </figure>

                    <div class="absolute top-8 right-8">
                        <label class="bg-white px-4 py-2 rounded-lg cursor-pointer">
                            <i class="fa-solid fa-camera mr-2"></i>
                            Actualizar Imagen
                            <input type="file" accept="image/*" name="image" class="hidden"
                                onchange="previewImage(event, '#imgPreview')">
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <x-label class="mb-1">
                        Descripcion
                    </x-label>

                    <x-textarea class="w-full" name="descripcion">
                        {{ old('descripcion', $evidenciasGenerado->descripcion) }}
                    </x-textarea>
                </div>

                <div class="flex items-center mb-4">
                    <input id="default-checkbox" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox" class="ms-2 font-medium text-gray-900 dark:text-gray-300">Confirmo que
                        la informacion es correcta</label>
                </div>

                <div class="flex justify-end">
                    <x-danger-button class="mr-2" onclick="deleteEvidencia()">
                        Eliminar comprobante
                    </x-danger-button>
                    <x-button>
                        Editar comprobante
                    </x-button>
                </div>
            </form>

            <form action="{{ route('evidenciasGenerado.destroy', $evidenciasGenerado) }}" method="POST"
                id="formDelete">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    @push('js')
        <script>
            function deleteEvidencia() {
                let form = document.getElementById('formDelete');
                form.submit();
            }

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

</x-app-layout>
