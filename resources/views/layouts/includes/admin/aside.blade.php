    @php
        $links = [
            [
                'name' => 'Inicio',
                'url' => route('admin.dashboard'),
                'active' => request()->routeIs('admin.dashboard'),
                'icon' => 'fa-solid fa-gauge-high',
                'can' => ['Acceso a Administración']
            ], [
                'name' => 'Zonas de la universidad',
                'url' => route('admin.zonas.index'),
                'active' => request()->routeIs('admin.zonas.*'),
                'icon' => 'fa-solid fa-flag',
            ], [
                'name' => 'Areas de la universidad',
                'url' => route('admin.areas.index'),
                'active' => request()->routeIs('admin.areas.*'),
                'icon' => 'fa-solid fa-monument',
            ], [
                'name' => 'Subproductos',
                'url' => route('admin.subproductos.index'),
                'active' => request()->routeIs('admin.subproductos.*'),
                'icon' => 'fa-solid fa-bottle-water',
                'can' => ['Acceso a Subproductos']
            ], [
                'name' => 'Roles',
                'url' => route('admin.roles.index'),
                'active' => request()->routeIs('admin.roles.*'),
                'icon' => 'fa-solid fa-user-tag',
                'can' => ['Gestion de Roles']
            ], [
                'name' => 'Permisos',
                'url' => route('admin.permissions.index'),
                'active' => request()->routeIs('admin.permissions.*'),
                'icon' => 'fa-solid fa-key',
                'can' => ['Gestion de Permisos']
            ], [
                'name' => 'Usuarios',
                'url' => route('admin.users.index'),
                'active' => request()->routeIs('admin.users.*'),
                'icon' => 'fa-solid fa-users',
                'can' => ['Gestion de Usuarios']
            ], [
                'name' => 'Mi tecnológico',
                'url' => route('admin.institutos.index'),
                'active' => request()->routeIs('admin.institutos.*'),
                'icon' => 'fa-solid fa-school',
                'can' => ['Gestion de Usuarios']
            ],
            
        ];
    @endphp

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
        :class="{'-translate-x-full' : !open, 'transform-none' : open,}"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">
                @foreach ($links as $link)
                    {{-- canany comprueba todos los elementos del array y si existe algun permiso adicional, se muestra el enlace --}}
                    @canany($link['can'] ?? [null])
                        <li>
                            <a href="{{ $link['url'] }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $link['active'] ? 'bg-gray-100' : ''}}">
                                <i class="{{$link['icon']}} text-gray-500"></i>
                                <span class="ms-3">{{ $link['name'] }}</span>
                            </a>
                        </li>
                    @endcanany
                @endforeach
            </ul>
        </div>
    </aside>
