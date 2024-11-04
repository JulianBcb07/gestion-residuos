{{-- Es una variable que se pasa atraves de las vistas de la aplicacion --}}
@props(['breadcrumb' => [],])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/b3626e12a7.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased sm:overflow-auto"
    :class="{ 'overflow-hidden' : open }"
    x-data="{open: false}">

    @include('layouts.includes.admin.nav')

    @include('layouts.includes.admin.aside')

    <div class="p-4 sm:ml-64">

        <div class="mt-20 -mb-14 flex justify-between items-center">
            @include('layouts.includes.admin.breadcrumb')

            @isset($action)
                {{$action}}
            @endisset
        </div>

        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-20">
            
            {{$slot}}

        </div>
    </div>

    {{-- Para hacer que un fondo gris se active cuando abrimos el sidebar en telefonos --}}
    <div x-cloak x-show="open" x-on:click="open = false" class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-30 sm:hidden"></div>

    @stack('modals')

    @livewireScripts

    @if (session('swal'))
    <script>
        Swal.fire(@json(session('swal')))
    </script>
    @endif

    @stack('js')    
</body>

</html>
