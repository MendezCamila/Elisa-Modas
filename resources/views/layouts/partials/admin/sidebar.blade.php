@php
    $links = [
        [
            'icon'=>'fa-solid fa-gauge',
            'name'=>'Dashboard',
            'route'=>route('admin.dashboard'),
            'active'=> request()->routeIs('admin.dashboard')
        ],
        //Parte administracion de usuarios
        [
            'header' => 'Usuarios',
        ],
        [
            //Usuarios
            'name'=>'Usuarios',
            'icon'=>'fas fa-users',
            'route'=>route('admin.users.index'),
            'active'=> request()->routeIs('admin.users.*')
        ],

        [
            //Roles
            'name'=>'Roles',
            'icon'=>'fas fa-users-cog',
            'route'=>route('admin.roles.index'),
            'active'=> request()->routeIs('admin.roles.*')
        ],

        [
            //proveedores
            'name'=>'Proveedores',
            'icon'=>'fas fa-truck',
            'route'=>route('admin.suppliers.index'),
            'active'=> request()->routeIs('admin.suppliers.*')

        ],


        //Parte de administracion
        [
            'header' => 'Administración',
        ],


        [
            //Opciones
            'name'=>'Opciones',
            'icon'=>'fa-solid fa-cog',
            'route'=>route('admin.options.index'),
            'active'=> request()->routeIs('admin.options.*')
        ],

        [
            //familia o rama de productos
            'name'=>'Familias',
            'icon'=>'fa-solid fa-box-open',
            'route'=>route('admin.families.index'),
            'active'=> request()->routeIs('admin.families.*')
        ],
        [
            //Categorias de productos
            'name'=>'Categorias',
            'icon'=>'fa-solid fa-tags',
            'route'=>route('admin.categories.index'),
            'active'=> request()->routeIs('admin.categories.*')
        ],
        [
            //Subcategorias de Categorias
            'name'=>'Subcategorias',
            'icon'=>'fa-solid fa-tag',
            'route'=>route('admin.subcategories.index'),
            'active'=> request()->routeIs('admin.subcategories.*')
        ],

        [
            //Productos
            'name'=>'Productos',
            'icon'=>'fa-solid fa-box',
            'route'=>route('admin.products.index'),
            'active'=> request()->routeIs('admin.products.*')
        ],


        [
            //Portada
            'name'=>'Portadas',
            'icon'=>'fa-solid fa-images',
            'route'=>route('admin.covers.index'),
            'active'=> request()->routeIs('admin.covers.*')
        ],

        //Parte de administracion
        [
            'header' => 'Ordenes',
        ],

        [
            //Tickets de ventas
            'name'=>'Ventas',
            'icon'=>'fa-solid fa-receipt',
            'route'=> route('admin.ventas.index'),
            'active'=> request()->routeIs('admin.ventas.*')

        ],

        [
            //Preventas
            'name'=>'Preventas',
            'icon'=>'fa-solid fa-shopping-cart',
            'route'=>route('admin.pre-ventas.index'),
            'active'=> request()->routeIs('admin.pre-ventas.*')
        ],

        [
            //Reservas
            'name'=>'Reservas',
            'icon'=>'fa-solid fa-calendar-check',
            'route'=>route('admin.reservas.index'),
            'active'=> request()->routeIs('admin.reservas.*')
        ],

        [
            //Cotizaciones
            'name'=>'Cotizaciones',
            'icon'=>'fa-solid fa-file-invoice',
            'route'=>route('admin.cotizaciones.index'),
            'active'=> request()->routeIs('admin.cotizaciones.*')
        ],

        [
            //Ordenes de compras
            'name'=>'Ordenes de compras',
            'icon'=>'fa-solid fa-shopping-bag',
            'route'=>route('admin.orden-compras.index'),
            'active'=> request()->routeIs('admin.orden-compras.*')
        ],

        //Parte de auditorias
        [
            'header' => 'Auditorias',
        ],
        [
            'name'=>'Auditorias',
            'icon'=>'fa-solid fa-clipboard-list',
            'route'=>route('admin.auditorias.index'),
            'active'=> request()->routeIs('admin.auditorias.*')
        ],

    ];
@endphp

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-[100dvh] pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    :class="{
        'translate-x-0 ease-out': sidebarOpen,
        '-translate-x-full ease-in': !sidebarOpen

    }"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        @can('acceso dashboard')
            <ul class="space-y-2 font-medium">
                @foreach ($links as $link )
                    <li>
                        @isset($link['header'])
                            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">
                                {{ $link['header'] }}
                            </div>

                        @else
                            <a href="{{ $link['route']}} "
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $link['active'] ? 'bg-blue-300' :'' }} ">
                                <span class="inline-flex w-6 h-6 justify-center items-center">
                                    <i class=" {{ $link['icon'] }} text-gray-600"></i>
                                </span>
                                <span class="ms-2">
                                    {{ $link['name'] }}
                                </span>
                            </a>

                        @endisset
                    </li>
                @endforeach
            </ul>
        @endcan
    </div>
</aside>
