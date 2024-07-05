<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    <div class="card">
        <form action="{{ route('admin.families.store') }}" method="POST">
            @csrf
            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label class="mb-2">
                    Nombre
                </x-label>
                <x-input class="w-full"
                    placeholder="Ingrese el nombre de la familia"
                    name="name"
                    value="{{ old('name') }}"/>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>

            </div>
        </form>
    </div>



</x-admin-layout>
