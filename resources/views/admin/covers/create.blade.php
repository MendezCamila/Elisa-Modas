<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Portadas',
        'route' => route('admin.covers.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    <form action="{{ route('admin.covers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <figure class="relative mb-4">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white cursor-pointer text-gray-600">
                    <i class="fas fa-camera mr-2"></i>
                    Añadir imagen
                    <input type="file" class="hidden" accept="image/*" name="image" onchange="previewImage(event, '#imgPreview')">
                </label>
            </div>
            <img src="{{ asset('img/sinPortada.jpg') }}" alt="Portada" class="w-full aspect-[3/1] object-cover object-center" id="imgPreview">
        </figure>

        <x-validation-errors class="mb-4" />

        <div class="mb-4">
            <x-label class="mb-1">Título</x-label>
            <x-input
                name="title"
                class="w-full"
                value="{{ old('title') }}"
                placeholder="Ingrese el título de la portada"
            />
            @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <x-label class="mb-1">Fecha de inicio</x-label>
            <x-input
                type="date"
                name="start_at"
                class="w-full"
                value="{{ old('start_at', now()->format('Y-m-d')) }}"
            />
        </div>

        <div class="mb-4">
            <x-label class="mb-1">Fecha fin (opcional)</x-label>
            <x-input
                type="date"
                name="end_at"
                class="w-full"
                value="{{ old('end_at') }}"
            />
        </div>

        <div class="mb-4 flex space-x-2">
            <label>
                <x-input type="radio" name="is_active" value="1" class="mr-2" checked />
                Activo
            </label>
            <label>
                <x-input type="radio" name="is_active" value="0" class="mr-2" />
                Inactivo
            </label>
        </div>

        <div class="flex justify-end">
            <x-button>Crear portada</x-button>
        </div>
    </form>

    @push('js')
        <script>
            function previewImage(event, querySelector) {
                // Recuperamos el input que desencadenó la acción
                const input = event.target;

                // Recuperamos la etiqueta img donde cargaremos la imagen
                const $imgPreview = document.querySelector(querySelector);

                // Verificamos si existe una imagen seleccionada
                if (!input.files.length) return;

                // Recuperamos el archivo subido
                const file = input.files[0];

                // Creamos la URL
                const objectURL = URL.createObjectURL(file);

                // Modificamos el atributo src de la etiqueta img
                $imgPreview.src = objectURL;
            }
        </script>
    @endpush

</x-admin-layout>
