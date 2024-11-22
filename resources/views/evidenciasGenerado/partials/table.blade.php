        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
            <thead class="text-xs text-center text-gray-800 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">Id</th>
                    <th scope="col" class="px-4 py-3">Imagen subida</th>
                    <th scope="col" class="px-4 py-3">Descripcion</th>
                    <th scope="col" class="px-4 py-3">Fecha de creacion</th>
                    <th scope="col" class="px-4 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($evidenciasGenerado as $evidencia)
                    <tr class="border-b dark:border-gray-900">
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $evidencia->id }}
                        </th>
                        <td class="px-4 py-3">
                            <div class="flex justify-center">
                                <a href="{{ route('evidenciasGenerado.edit', $evidencia->id) }}">
                                    <img class="aspect-[4/3] object-cover object-center w-56 h-48"
                                        src="{{ Storage::url($evidencia->url_image) }}" alt="">
                                </a>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $evidencia->descripcion }}</td>
                        <td class="px-4 py-3">{{ $evidencia->fecha }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('evidenciasGenerado.edit', $evidencia->id) }}">
                                    <i class="fa-solid fa-pen-to-square "></i>
                                </a>
                                <a href="{{ route('evidenciasGenerado.show', $evidencia->id) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 space-y-4 md:space-y-0 p-5">
            {{-- esto sirve para activar los botones de paginacion --}}
            {{ $evidenciasGenerado->links() }}
        </div>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('simple-search');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value;

                fetch(`{{ route('evidenciasGenerado.search') }}?query=${query}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('table-container').innerHTML = html;
                    });
            });
        });
    </script> --}}
