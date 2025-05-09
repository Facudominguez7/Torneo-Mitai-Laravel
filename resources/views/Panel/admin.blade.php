@include('head')
@include('components.loader')

<body class="bg-[--color-primary]  font-[Poppins]">
    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
        aria-controls="sidebar-multi-level-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>
    <aside id="sidebar-multi-level-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Panel de Administración</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
                        aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 192 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 224 32 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 512c-17.7 0-32-14.3-32-32s14.3-32 32-32l32 0 0-192-32 0c-17.7 0-32-14.3-32-32z" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Ediciones</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        @foreach ($ediciones as $edicion)
                        <li>
                            <a href="{{ route('admin', ['idEdicion' => $edicion->id]) }}"
                                class="block px-4 py-2 hover:bg-gray-100">
                                {{ $edicion->nombre }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="{{ route('edicion.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Ediciones</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tabla_goleador.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Tabla de Goleadores</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('equipo.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Equipos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('grupos.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Grupos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categoria.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Categorias</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('fecha.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Fechas</span>
                    </a>
                </li>
                <hr>
                <li>
                    <a href="{{ route('instancia_final.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Instancias Finales</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('copa.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Copas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('fase.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Fases</span>
                    </a>
                </li>
                <hr>
                <li>
                    <a href="{{ route('campeon.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Campeones</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('subcampeon.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> SubCampeones</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('goleador.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Goleadores del Torneo</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('valla.index', isset($EdicionSeleccionada) ? ['idEdicion' => $EdicionSeleccionada] : []) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"> Vallas Menos Vencidas</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <div class="flex flex-col h-screen">
        @if (isset($EdicionSeleccionada))
        <div class="flex justify-end">
            <section class="bg-emerald-300 p-2">
                <div
                    class="flex max-w-xs items-center border-r-8 border-[--color-secondary] bg-white p-4 text-emerald-900 shadow-lg">
                    <div class="min-w-0">
                        <h2 class="overflow-hidden text-ellipsis whitespace-nowrap">
                            {{ $EdicionSeleccionada->nombre }}
                        </h2>
                    </div>
                </div>
            </section>
        </div>
        @if (Route::is('admin'))
        <div class="flex flex-row justify-center mb-2">
            <div class="mr-2">
                <a
                    href="{{ route('seleccionar-categoria', ['idEdicion' => $EdicionSeleccionada, 'tipo' => 'equipogrupo']) }}">
                    <button
                        class="bg-gray-800 hover:bg-gray-900 mt-2 mb-2 text-white py-2 px-4 rounded-full transition-all duration-300 md:py-3 md:px-6 md:rounded-lg">
                        Agregar Equipo a Grupo
                    </button>
                </a>
            </div>
            <div class="mr-2">
                <a href="{{ route('partido.index', ['idEdicion' => $EdicionSeleccionada]) }}">
                    <button
                        class="bg-gray-800 hover:bg-gray-900 mt-2 mb-2 text-white py-2 px-4 rounded-full transition-all duration-300 md:py-3 md:px-6 md:rounded-lg">
                        Partidos
                    </button>
                </a>
            </div>
        </div>
        <!-- Filtro de horario -->
        <div class="flex justify-center w-auto">
            <div class="relative inline-block text-left w-full md:w-64 filtro-fecha">
                <p class="text-center text-gray-800 font-semibold bg-gray-200 py-2 rounded-lg shadow-md mb-2">
                    Filtro por Horario
                </p>
                <form action="{{ route('admin', ['idEdicion' => $EdicionSeleccionada]) }}" method="GET"
                    class="flex items-center gap-4">
                    <div class="relative w-full">
                        <select id="horario" name="horario"
                            class="appearance-none bg-white text-gray-800 font-medium border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none hover:border-gray-400 px-4 py-2 rounded-lg shadow-md w-auto transition ease-in-out duration-200">
                            <option value="">Mostrar Todos</option>
                            @foreach ($horariosDisponibles as $horario)
                            <option value="{{ $horario }}" {{ request('horario') == $horario ? 'selected' : '' }}>
                                {{ $horario }} hs
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @foreach (request()->except(['horario', '_token']) as $key => $value)
                    <!-- Excluir horario y token -->
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button type="submit"
                        class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-200">
                        Filtrar
                    </button>
                </form>
            </div>
        </div>
        <div class="flex justify-center mb-4">
            @if(request('horario'))
            <p class="text-center text-gray-700 font-semibold  bg-gray-200 py-2 px-4 rounded-lg shadow-md">
            Mostrando partidos de las {{ request('horario') }} hs
            </p>
            @endif
        </div>
        @foreach ($partidos as $categoria => $partidosPorCategoria)
        <div class="mr-5">
            <h1 class="text-4xl text-white font-bold text-center">{{ $categoria }}</h1>
        </div>
        @php
        $partidosPorFecha = $partidosPorCategoria->groupBy('nombre_fecha');
        @endphp
        @foreach ($partidosPorFecha as $fecha => $partidos)
        <h3 class="text-3xl text-white font-semibold my-2 text-center">{{ $fecha }}
        </h3>
        @foreach ($partidos as $p)
        <div class="flex justify-center mb-5">
            <div class="grid gap-6 p-1 bg-gray-50 w-full md:w-1/2">
                <div class=" }rounded-lg shadow-lg overflow-x-auto md:overflow-x-visible">
                    <div
                        class="flex flex-col md:flex-row items-center justify-between md:px-6 py-4 border-b">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('fotos/equipos/' . $p->foto_local) }}"
                                width="40" height="40" alt=""
                                class="object-cover" />
                            <div class="font-medium text-lg">{{ $p->nombre_local }}</div>
                            <div class="text-gray-500">vs</div>
                            <div class="font-medium text-lg">{{ $p->nombre_visitante }}</div>
                            <img src="{{ asset('fotos/equipos/' . $p->foto_visitante) }}"
                                width="40" height="40" alt=""
                                class="object-cover" />
                        </div>
                        <div
                            class="text-2xl font-bold mt-4 md:mt-0 text-center text-[--color-primary]">
                            {{ $p->golesEquipoLocal }} - {{ $p->golesEquipoVisitante }}
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row items-center justify-between px-6 py-2 text-muted-foreground">
                        <div class="flex items-center gap-2 mb-2 md:mb-0">
                            <span class="text-xl">{{ \Carbon\Carbon::parse($p->horario_datetime)->format('d-m-Y H:i') }}</span>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <span>Cancha {{ $p->cancha }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center my-2">
                    <a
                        href="{{ route('planilla.show', ['partidoId' => $p->id, 'idEdicion' => $EdicionSeleccionada->id, 'tipoPartido' => 'partido', 'horario' => $horarioString ?? 0 ]) }}">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Planillas
                        </button>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
        @endforeach
        @endif
        @endif
        <div class="flex-grow flex items-center justify-center lg:pl-36 mt-0">
            <section class="w-1/2 md:w-3/4">
                @if (session('status'))
                <div class="flex justify-center">
                    <div id="status-message" class="flex items-center rounded-xl bg-white p-4 shadow-lg w-1/2">
                        <div class="flex h-10 w-10 items-center justify-center bg-blue-300 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path d="M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48zm0 368c-88.2 0-160-71.8-160-160S167.8 96 256 96s160 71.8 160 160-71.8 160-160 160zm0-256c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm0 96c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32s32-14.3 32-32v-64c0-17.7-14.3-32-32-32z" />
                            </svg>
                        </div>
                        <div class="ml-6">
                            <div class="flex justify-center">
                                <p class="text-lg text-black font-semibold">{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('status-message').remove();
                    }, 60000);
                </script>
                @endif
                @if (Str::endsWith(request()->route()->getName(), '.show'))
                @yield('detalle')
                @else
                @yield('contenido')
                @endif
            </section>
        </div>
    </div>
</body>

</html>