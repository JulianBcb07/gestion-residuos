<x-admin-layout :breadcrumb="[
    [
        'name' => 'Home',
        'url' => route('admin.dashboard')
    ], [
        'name' => 'Zonas'
    ]
]">

    <x-slot name="action">
        <a class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" href="{{route('admin.zonas.create')}}">Nuevo</a>
    </x-slot>
    
    @if($zonas->count())

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-800">
            <thead class="text-xs text-gray-800 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombe
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zonas as $zona)
                    <tr class="bg-white border-b">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                            {{ $zona->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $zona->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.zonas.edit', $zona) }}">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else 

        <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:text-blue-400" role="alert">
            <span class="font-medium">Alerta!</span> Aún no hay zonas registradas en el sistema.
        </div>

    @endif

</x-admin-layout>