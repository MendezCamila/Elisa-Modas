<div>
    <x-validation-errors class="mb-4" />
    <section class="card">

        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Editar Rol</span>
            </h1>
        </header>

        <div class="px-6 py-4">
            <form wire:submit.prevent="updateRole">

                <div class="mb-4">
                    <x-label for="name" value="Nombre del Rol" />
                    <x-input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" wire:model="name" required autofocus />
                </div>

                <div class="mb-4">
                    <x-label for="permissions" value="Permisos" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                        @foreach ($permissions as $permission)
                            <label class="inline-flex items-center space-x-2">
                                <x-checkbox wire:model="selectedPermissions" value="{{ $permission->id }}" />
                                <span class="ml-2">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-button>
                        Actualizar Rol
                    </x-button>
                </div>
            </form>
        </div>

    </section>
</div>

