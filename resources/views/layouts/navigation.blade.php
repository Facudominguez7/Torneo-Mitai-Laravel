<nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        @if (isset($EdicionSeleccionada))
            <a href="{{ route('home', ['idEdicion' => $EdicionSeleccionada]) }}"
                class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('fotos/Logo_Mitai_SinFondo.png') }}" class="h-10 w-10" alt="MITAI Logo">
                <span
                    class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">{{ $EdicionSeleccionada->nombre }}</span>
            @else
                <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('fotos/Logo_Mitai_SinFondo.png') }}" class="h-10 w-10" alt="MITAI Logo">
                    <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">Torneos
                        Mita'í</span>
        @endif
        </a>
        <button data-collapse-toggle="navbar-dropdown" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Categorias</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full lg:block lg:w-auto" id="navbar-dropdown">
            <ul
                class="flex flex-col font-medium p-4 lg:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 lg:space-x-8 rtl:space-x-reverse lg:flex-row lg:mt-0 lg:border-0 lg:bg-white dark:bg-gray-800 lg:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <div class="flex flex-row items-center">
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownEdiciones"
                            class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 lg:w-auto dark:text-white lg:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 lg:dark:hover:bg-transparent">Ediciones
                            <svg class="w-2.5 h-2.5 ms-2.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownCategorias"
                            class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 lg:w-auto dark:text-white lg:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 lg:dark:hover:bg-transparent">Categorias
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                    </div>
                    <!-- Dropdown menu -->
                    <div id="dropdownCategorias"
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                            @if (isset($EdicionSeleccionada))
                                @if (is_null($EdicionSeleccionada))
                                    <li>
                                        <a href="{{ url('/') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Debe
                                            seleccionar una Edicion
                                        </a>
                                    </li>
                                @elseif (isset($categorias) && $categorias->isEmpty())
                                    <li>
                                        <a href="{{ url('/') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Por
                                            el momento no se agregaron categorías</a>
                                    </li>
                                @elseif (isset($categorias))
                                    @foreach ($categorias as $categoria)
                                        <li>
                                            <a href="{{ url('/?idEdicion=' . $categoria->idEdicion . '&idCategoria=' . $categoria->id) }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                {{ $categoria->nombreCategoria }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            @endif
                        </ul>
                    </div>
                    <div id="dropdownEdiciones"
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                            @if (isset($ediciones))
                                @if ($ediciones->isEmpty())
                                    <li>
                                        <a href="{{ url('/') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Por el momento no se agregaron ediciones para este torneo
                                        </a>
                                    </li>
                                @else
                                    @foreach ($ediciones as $edicion)
                                        <li>
                                            <a href="{{ url('/?idEdicion=' . $edicion->id) }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                {{ $edicion->nombre }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            @endif
                        </ul>
                    </div>
                </li>
                @auth
                    @if (Auth::user()->rol == 'admin')
                        <li>
                            <a href="{{ route('admin') }}"
                                class="py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-white lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">
                                Panel de Administración
                            </a>
                        </li>
                    @endif
                @endauth
                <!-- Settings Dropdown -->
                @if (Auth::check())
                    <div x-data="{ open: false }" class="sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-white lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">
                                    <div class="flex items-center">
                                        @if (isset(Auth::user()->google_avatar))
                                            <img class="w-8 h-8 rounded-xl" src="{{ Auth::user()->google_avatar }}"
                                                alt="Avatar de {{ Auth::user()->name }}">
                                        @else
                                            <div>{{ Auth::user()->name }}</div>
                                        @endif
                                        <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @if (isset($EdicionSeleccionada))
                                    <x-dropdown-link :href="route('profile.edit', ['idEdicion' => $EdicionSeleccionada])">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                @else
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                @endif

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
                @else
                    <a href="{{ route('login') }}"
                        class="py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-white lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">
                        Iniciar sesión
                    </a>
                @endif
            </ul>
        </div>
    </div>
</nav>
