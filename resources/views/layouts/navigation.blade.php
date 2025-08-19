<nav class="bg-surface border-b border-gray-100">
    <!-- =================================================================== -->
    <!-- =================== MENÚ PARA ESCRITORIO (Desktop) ================= -->
    <!-- =================================================================== -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="hidden sm:flex items-center justify-between h-16">
            <!-- Izquierda: Logo y Enlaces -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-bee-logo class="block h-9 w-auto fill-current text-primary" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('apiaries.index')" :active="request()->routeIs('apiaries.index')">
                        {{ __('Apiarios') }}
                    </x-nav-link>
                    <x-nav-link :href="route('hives.index')" :active="request()->routeIs('hives.index')">
                        {{ __('Colmenas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.index')">
                        {{ __('Calendario') }}
                    </x-nav-link>
                    <x-nav-link :href="route('knowledge.index')" :active="request()->routeIs('knowledge.index')">
                        {{ __('Conocimiento') }}
                    </x-nav-link>
                    <x-nav-link :href="route('hive_supers.index')" :active="request()->routeIs('hive_supers.index')">
                        {{ __('Inventario') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Centro: Barra de Búsqueda (NUEVO) -->
            <div class="flex-grow flex justify-center px-6">
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Buscar..." class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-full bg-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-primary-dark focus:border-transparent">
                </div>
            </div>

            <!-- Derecha: Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Theme switcher -->
                <button @click="toggle()" class="mr-4 p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <svg x-show="!isDark" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-12.66l-.707.707M4.34 19.66l-.707.707M21 12h-1M4 12H3m16.66 8.66l-.707-.707M4.34 4.34l-.707-.707" />
                    </svg>
                    <svg x-show="isDark" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-text-light bg-surface hover:text-text-dark focus:outline-none transition ease-in-out duration-150">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="h-8 w-8 rounded-full object-cover mr-2">
                            @endif
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>


    <!-- =============================================================== -->
    <!-- =================== MENÚ PARA MÓVIL (Mobile) ================== -->
    <!-- =============================================================== -->
    
    <!-- BARRA SUPERIOR MÓVIL (Solo se muestra en pantallas pequeñas) -->
    <div class="sm:hidden flex items-center justify-between h-16 px-4">
        <!-- Theme switcher -->
        <button @click="toggle()" class="mr-2 p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            <svg x-show="!isDark" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-12.66l-.707.707M4.34 19.66l-.707.707M21 12h-1M4 12H3m16.66 8.66l-.707-.707M4.34 4.34l-.707-.707" />
            </svg>
            <svg x-show="isDark" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
        <!-- Barra de Búsqueda -->
        <div class="flex-grow mx-2 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" placeholder="Buscar..." class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-full bg-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-primary-dark focus:border-transparent">
        </div>

        <!-- Avatar de Usuario -->
        <div class="relative">
            <a href="{{ route('profile.edit') }}" class="flex items-center">
                @if (Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="h-9 w-9 rounded-lg object-cover">
                @else
                    <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-200 text-blue-800 font-bold">
                        @php
                            $name = Auth::user()->name;
                            $initials = strtoupper(substr($name, 0, 1) . (strpos($name, ' ') ? substr(strstr($name, ' '), 1, 1) : ''));
                        @endphp
                        {{ $initials }}
                    </div>
                @endif
            </a>
            <span class="absolute -bottom-0.5 -right-0.5 block h-3 w-3 rounded-full bg-green-500 ring-2 ring-white"></span>
        </div>
    </div>
</nav>

<!-- BARRA DE NAVEGACIÓN INFERIOR (Solo se muestra en pantallas pequeñas) -->
<div class="sm:hidden fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200">
    <div class="grid h-full grid-cols-5 mx-auto">
        @php
            // Define los colores para los estados activo e inactivo. Puedes cambiarlos por los de tu tema.
            // Por ejemplo: 'text-primary' para el color activo.
            $activeClasses = 'text-blue-600';
            $inactiveClasses = 'text-gray-500 hover:bg-gray-50';
        @endphp

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="relative inline-flex flex-col items-center justify-center font-medium {{ request()->routeIs('dashboard') ? $activeClasses : $inactiveClasses }}">
            <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12.75 9 9 9-9-9-9-9 9Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 21V3" /></svg>
            <span class="text-xs">Dashboard</span>
            @if(request()->routeIs('dashboard'))
            <div class="absolute bottom-0 h-1 w-8 bg-blue-600 rounded-t-full"></div>
            @endif
        </a>

        <!-- Apiarios (usando icono de "clientes") -->
        <a href="{{ route('apiaries.index') }}" class="relative inline-flex flex-col items-center justify-center font-medium {{ request()->routeIs('apiaries.*') ? $activeClasses : $inactiveClasses }}">
            <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m-7.5-2.226A3 3 0 0 1 12 13.5a3 3 0 0 1 3-3.75m-6 0a3 3 0 0 0-3 3.75m7.5-3.75a3 3 0 0 0-3 3.75M3 13.5a3 3 0 0 1 3-3.75m0 0a3 3 0 0 1 3 3.75" /></svg>
            <span class="text-xs">Apiarios</span>
            @if(request()->routeIs('apiaries.*'))
            <div class="absolute bottom-0 h-1 w-8 bg-blue-600 rounded-t-full"></div>
            @endif
        </a>
        
        <!-- Colmenas (usando icono de "chat") -->
        <a href="{{ route('hives.index') }}" class="relative inline-flex flex-col items-center justify-center font-medium {{ request()->routeIs('hives.*') ? $activeClasses : $inactiveClasses }}">
            <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193l-3.72.35c-.343.032-.69.048-1.042.048h-1.042a2.121 2.121 0 0 1-2.121-2.121v-4.286c0-1.136.847-2.1 1.98-2.193l3.72-.35c.343-.032.69-.048 1.042-.048a2.121 2.121 0 0 1 2.121 2.121ZM6.308 15.932a2.121 2.121 0 0 1-2.121-2.121V9.526c0-1.136.847-2.1 1.98-2.193l3.72-.35c.343-.032.69-.048 1.042-.048h1.042a2.121 2.121 0 0 1 2.121 2.121v4.286c0 1.136-.847-2.1-1.98-2.193l-3.72.35c-.343.032-.69.048-1.042.048H8.428a2.121 2.121 0 0 1-2.121-2.12Z" /></svg>
            <span class="text-xs">Colmenas</span>
            @if(request()->routeIs('hives.*'))
            <div class="absolute bottom-0 h-1 w-8 bg-blue-600 rounded-t-full"></div>
            @endif
        </a>

        <!-- Calendario -->
        <a href="{{ route('calendar.index') }}" class="relative inline-flex flex-col items-center justify-center font-medium {{ request()->routeIs('calendar.*') ? $activeClasses : $inactiveClasses }}">
            <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0h18" /></svg>
            <span class="text-xs">Calendario</span>
            @if(request()->routeIs('calendar.*'))
            <div class="absolute bottom-0 h-1 w-8 bg-blue-600 rounded-t-full"></div>
            @endif
        </a>

        <!-- Inventario -->
        <a href="{{ route('hive_supers.index') }}" class="relative inline-flex flex-col items-center justify-center font-medium {{ request()->routeIs('hive_supers.index') ? $activeClasses : $inactiveClasses }}">
            <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4" />
            </svg>
            <span class="text-xs">Inventario</span>
            @if(request()->routeIs('hive_supers.index'))
            <div class="absolute bottom-0 h-1 w-8 bg-blue-600 rounded-t-full"></div>
            @endif
        </a>
    </div>
</div>