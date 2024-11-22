<x-admin-layout :breadcrumb="[
    [
        'name' => 'Home',
        'url' => route('admin.dashboard')
    ], [
        'name' => 'Roles',
        'url' => route('admin.roles.index')
    ], [
        'name' => $role->name
    ]
]">
    <div class="bg-white shadow rounded-lg p-6">

        <form action="{{ route('admin.roles.update', $role) }}" method="POST">

            @csrf

            @method('PUT')

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre del rol
                </x-label>
                <x-input class="w-full" name="name" placeholder="Ingrese el nombre del rol"
                    value="{{ old('name', $role->name) }}" />
            </div>

            <div class="mb-4">
                <ul>
                    @foreach ($permissions as $permission)
                        
                        <li>
                            <label>
                                {{-- El valor checked busca los permisos por su id y verifica cuales permisos tiene el rol para activarlos en el checkbox  --}}
                                <x-checkbox name="permissions[]" value="{{$permission->id}}" 
                                    :checked="in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray()))"/>
                                {{$permission->name}}
                            </label>
                        </li>

                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end">

                <x-button>
                    Actualizar rol
                </x-button>

                {{-- Onclick para que al precionarlo se active la funcion y se ejecute el segundo formulario
                para eliminar --}}
                <x-danger-button class="ml-2" onclick="deleteRole()">
                    Eliminar
                </x-danger-button>
            </div>
        </form>

        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" id="formDelete">

            @csrf
            @method('DELETE')

        </form>

        @push('js')
        {{-- Obtenemos el id del segundo formulario para eliminar el rol --}}
            <script>
                function deleteRole() {
                    let form = document.getElementById('formDelete');
                    form.submit();
                }
            </script>
            {{-- Al precionar el boton eliminar hace un llamado onclick para recuperar el id formDelete 
        lo cual mandara el formulario de eliminar --}}
        @endpush
    </div>

</x-admin-layout>
