<x-admin-layout :breadcrumb="[
    [
        'name' => 'Home',
        'url' => route('admin.dashboard')
    ], [
        'name' => 'Roles'
    ]
]">

    <x-slot name="action">
        <a class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" href="{{route('admin.roles.create')}}">Nuevo</a>
    </x-slot>
    
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-800">
            <thead class="text-xs text-gray-800 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $rol)
                    <tr class="bg-white border-b">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                            {{ $rol->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $rol->name }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.roles.edit', $rol) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin-layout>