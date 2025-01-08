{{-- La directiva php que cree permite crear mas secciones en la pagina principal --}}
{{-- Informacion para crear un enlace: 
    name -> nombre de la seccion
    url -> la ruta de esa seccion
    active -> determina en que url o seccion estamos y lo pone como activo  --}}
@php
    $linkspublicos = [
        [
            'name' => 'Inicio',
            'url' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
        ],
    ];

    // Links para usuarios autenticados
    $linkslogin = [
        [
            'name' => 'Graficas',
            'url' => route('graficas'),
            'active' => request()->routeIs('graficas'),
            'can' => ['Acceso a Graficas'],
        ],
        [
            'name' => 'Predicciones',
            'url' => route('prediccionesZonas.index'),
            'active' => request()->routeIs('prediccionesZonas.index'),
            'can' => ['Acceso a Predicciones'],
        ],
        [
            'name' => 'Evidencias de valorización',
            'url' => route('evidenciasGenerado.index'),
            'active' => request()->routeIs('evidenciasGenerado.index'),
            'can' => ['Acceso a Evidencias de Generación'],
        ],
        [
            'name' => 'Meta Anual',
            'url' => route('metaAnual.index'),
            'active' => request()->routeIs('metaAnual.index'),
            'can' => ['Acceso a Meta Anual'],
        ],
        [
            'name' => 'Acerca de',
            'url' => route('acerca-de'),
            'active' => request()->routeIs('acerca-de'),
        ],
    ];
@endphp

<nav x-data="{ open: false }" class="bg-customColor border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block w-12 h-12" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- en esta parte usamos un ciclo foreach para iterar en cada link y determinar cual es el seleccionado --}}
                    @foreach ($linkspublicos as $link)
                        <x-nav-link :href="$link['url']" :active="$link['active']">
                            {{ $link['name'] }}
                        </x-nav-link>
                    @endforeach

                    @auth
                        @foreach ($linkslogin as $link)
                            @canany($link['can'] ?? [null])
                                <x-nav-link :href="$link['url']" :active="$link['active']">
                                    {{ $link['name'] }}
                                </x-nav-link>
                            @endcanany
                        @endforeach
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    {{-- con el @auth nos aseguramos que solo nos muestre el contenido siempre y cuando
                hayamos iniciado sesion, de lo contrario no se muestra --}}

                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                @can('Acceso a Administración')
                                    <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                        {{ __('Administrador') }}
                                    </x-dropdown-link>
                                @endcan

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    {{-- si no estamos logeados indicamos que entonces nos muestre este 
                nav para iniciar sesion o registrarse --}}

                    <nav class="-mx-3 flex flex-1 justify-end">
                        <a href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-gray-100 ring-1 ring-transparent text-md font-medium transition hover:text-gray-300 focus:outline-none focus-visible:ring-[#FF2D20]">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-gray-100 ring-1 ring-transparent text-md font-medium transition hover:text-gray-300 focus:outline-none focus-visible:ring-[#FF2D20]">
                                Register
                            </a>
                        @endif
                    </nav>

                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($linkspublicos as $link)
                <x-responsive-nav-link :href="$link['url']" :active="$link['active']">
                    {{ $link['name'] }}
                </x-responsive-nav-link>
            @endforeach

            @auth
                @foreach ($linkslogin as $link)
                    <x-responsive-nav-link :href="$link['url']" :active="$link['active']">
                        {{ $link['name'] }}
                    </x-responsive-nav-link>
                @endforeach
            @endauth

            @guest {{-- la directiva guest muestra contenido siempre y cuando no se haya iniciado sesion.
                en este caso se usa para que cuando se inicie sesion, las opciones de login se oculten --}}
                <x-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                    {{ __('Registro') }}
                </x-responsive-nav-link>
            @endguest
        </div>

        @auth
            {{-- con el @auth nos aseguramos que solo nos muestre el contenido siempre y cuando
        hayamos iniciado sesion, de lo contrario no se muestra --}}
            {{-- Esto para que no genere error en la plantilla principal se pone en los settings options --}}

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

{{-- Algunas configuraciones de Jetstream te permiten hacer cambios rapidos.
Si no quieres que se vea solo el nombre, puede poner que se vaea la imagen del usuarios
Accedemos a config/jetstream y en features lo podemos activar --}}
