<x-admin-layout :breadcrumb="[
    [
        'name' => 'Home',
        'url' => route('admin.dashboard'),
    ],
    [
        'name' => 'Areas',
        'url' => route('admin.subproductos.index'),
    ],
    [
        'name' => 'Nuevo Subproducto',
    ],
]">

</x-admin-layout>
