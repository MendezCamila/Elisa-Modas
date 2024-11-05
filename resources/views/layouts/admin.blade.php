@props(['breadcrumbs'=>[]])

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

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/3e00f6586e.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS de Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- JS de Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    

    <!-- Styles -->
    @livewireStyles

    <!-- Enlace al archivo CSS de características -->
    <link rel="stylesheet" href="{{ asset('css/feature.css') }}">


</head>

<body class="font-sans antialiased"
    x-data="{
        sidebarOpen: false
    }"
    :class ="{
        'overflow-y-hidden': sidebarOpen
    }" >
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 sm:hidden" style="display: none;" x-show="sidebarOpen"
        x-on:click= "sidebarOpen =false">

    </div>
    @include('layouts.partials.admin.navigation')
    @include('layouts.partials.admin.sidebar')

    {{-- Migas de pan --}}
    <div class="p-4 sm:ml-64">
        <div class="mt-14">

                <div class="flex justify-between items-center">
                    @include('layouts.partials.admin.breadcrumb')

                    @isset($action)
                        <div>
                            {{ $action }}
                        </div>
                    @endisset
                </div>

                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 ">
                    {{ $slot }}
                </div>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    @stack('js')

    @if (session('swal'))
        <script>
            Swal.fire({!! json_encode(session('swal'))  !!});
        </script>

    @endif

    <script>
        Livewire.on('swal', data =>{
            Swal.fire(data[0]);
        });
    </script>

</body>

</html>
