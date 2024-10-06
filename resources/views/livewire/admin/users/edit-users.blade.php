<div>
    <form wire:submit.prevent="updateRoles">
        <div class="card">
            <x-validation-errors class="mb-4" />

            <x-label for="name" class="mb-4">Nombre</x-label>
            <x-input id="name" name="name" class="w-full mb-2" value="{{ $user->name }}" readonly />

            <x-label for="last_name" class="mb-4">Apellido</x-label>
            <x-input id="last_name" name="last_name" class="w-full mb-2" value="{{ $user->last_name }}" readonly />

            <!-- Listado de roles -->
            <h2 class="mt-4 mb-2">Listado de roles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                @foreach ($roles as $role)
                    <div>
                        <label class="inline-flex items-center space-x-2">
                            <x-checkbox wire:model="selectedRoles" value="{{ $role->id }}" />
                            <span>{{ $role->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Contenedor para alinear el botón a la derecha -->
            <div class="flex justify-end mt-4">
                <x-button>
                    Asignar Rol
                </x-button>
            </div>
        </div>
    </form>
</div>



