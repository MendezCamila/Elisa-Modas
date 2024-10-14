<div>
    <x-validation-errors class="mb-4" />

    <section class="card">
        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Editar Proveedor</span>
            </h1>
        </header>

        <div class="px-6 py-4">
            <form wire:submit.prevent="updateSupplier">

                <div class="mb-4">
                    <x-label for="name" value="Nombre" />
                    <x-input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" wire:model="name" required autofocus />
                </div>

                <div class="mb-4">
                    <x-label for="last_name" value="Apellido" />
                    <x-input id="last_name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" wire:model="last_name" required />
                </div>

                <div class="mb-4">
                    <x-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="email" wire:model="email" required />
                </div>

                <div class="mb-4">
                    <x-label for="phone" value="Teléfono" />
                    <x-input id="phone" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" wire:model="phone" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-button>
                        Actualizar Proveedor
                    </x-button>
                </div>
            </form>
        </div>
    </section>
</div>
