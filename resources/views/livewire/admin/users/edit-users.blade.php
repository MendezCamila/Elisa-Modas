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
            @foreach ($roles as $role)
                <div>
                    <label>
                        <input type="checkbox" wire:model="selectedRoles" value="{{ $role->id }}" class="mr-1">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach

            <!-- Contenedor para alinear el botón a la derecha -->
            <div class="flex justify-end mt-4">
                <x-button>
                    Asignar Rol
                </x-button>
            </div>
        </div>
    </form>
</div>



