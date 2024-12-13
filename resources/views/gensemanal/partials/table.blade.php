<table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
    <thead class="text-xs text-center text-gray-800 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-4 py-3">Id</th>
            <th scope="col" class="px-4 py-3">Fecha</th>
            <th scope="col" class="px-4 py-3">Zona</th>
            <th scope="col" class="px-4 py-3">Area asignada</th>
            <th scope="col" class="px-4 py-3">Turno</th>
            <th scope="col" class="px-4 py-3">Total generado</th>
            <th scope="col" class="px-4 py-3">
                Acciones
            </th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($registros as $registro)
            <tr class="border-b dark:border-gray-900">
                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $registro->zona_id }}
                </th>
                <td class="px-4 py-3">{{ $registro->fecha }}</td>
                <td class="px-4 py-3">{{ $registro->zona }}</td>
                <td class="px-4 py-3">{{ $registro->areaAsignada }}</td>
                <td class="px-4 py-3">{{ $registro->turno }}</td>
                <td class="px-4 py-3">{{ $registro->valor_kg }}</td>
                <td class="px-4 py-3 flex items-center justify-center gap-2">
                    <a
                        href="{{ route('gensemanal.editAll', ['fecha' => $registro->fecha, 'turno' => $registro->turno]) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <a href="{{ route('gensemanal.showAll', ['fecha' => $registro->fecha, 'turno' => $registro->turno])}}">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


