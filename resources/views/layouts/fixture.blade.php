@include('head')
<div class="bg-white w-full min-h-screen text-foreground">
    @include('layouts.navigation')

    <!-- Encabezado -->
    <div class="bg-[--color-primary] flex justify-center flex-col md:flex-row items-center text-white py-4 px-6">
        <h1 class="text-2xl font-semibold tracking-wide md:text-3xl">Fixture {{ $nombreCategoria }}</h1>
        <h1 class="text-2xl mt-1 md:mt-0 md:ml-10 font-semibold tracking-wide md:text-3xl">{{ $nombreFecha }}</h1>
    </div>

    <div class="flex flex-wrap justify-center bg-[--color-secondary] text-white py-4 px-6 gap-4">
        <!-- Contenedor de Filtros -->
        <div class="flex flex-col md:flex-row gap-4 w-full justify-center">
            <!-- Filtro de Categoría -->
            <div x-data="{ open: false }" class="relative inline-block text-left w-full md:w-48 filtro-categoria">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center justify-between gap-2 bg-white text-gray-700 font-medium border border-gray-300 focus:outline-none hover:border-gray-400 px-4 py-2 rounded-md shadow-sm w-full transition ease-in-out duration-300">
                            <span class="whitespace-nowrap">Seleccionar Categoria</span>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }"
                                class="w-4 h-4 transform transition-transform duration-300" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06 0L10 10.939l3.71-3.72a.75.75 0 011.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 010-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        @foreach ($categorias as $c)
                            <div class="cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                data-id="{{ $c->id }}" data-nombre="{{ $c->nombreCategoria }}">
                                {{ $c->nombreCategoria }}
                            </div>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Filtro de Fecha -->
            <div x-data="{ open: false }" class="relative inline-block text-left w-full md:w-48 filtro-fecha hidden">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center justify-between gap-2 bg-white text-gray-700 font-medium border border-gray-300 focus:outline-none hover:border-gray-400 px-4 py-2 rounded-md shadow-sm w-full transition ease-in-out duration-300">
                            <span class="whitespace-nowrap">Filtrar por Fecha</span>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }"
                                class="w-4 h-4 transform transition-transform duration-300" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06 0L10 10.939l3.71-3.72a.75.75 0 011.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 010-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="overflow-x-auto max-h-60">
                            @if (!is_null($fechas))
                                @foreach ($fechas as $f)
                                    <div class="cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        data-id="{{ $f->id }}" data-nombre="{{ $f->nombre }}">
                                        {{ $f->nombre }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Grupo -->
    @if (!is_null($grupos))
        @foreach ($grupos as $g)
            <div class="flex flex-row justify-center items-center">
                <div class="text-center p-3">
                    <h2 class="text-2xl font-semibold mb-4">{{ $g->nombre }}</h2>
                    <div class="flex justify-center">
                        <a href=""
                            class="bg-[--color-primary] text-white px-4 py-2 rounded-md hover:bg-[--color-secondary] transition-colors duration-300">Ir
                            a la tabla de posiciones</a>
                    </div>
                </div>
            </div>
            @foreach ($partidos->where('idGrupo', $g->id) as $p)
                <div class="grid gap-6 p-1 md:p-6 bg-gray-50 w-full md:w-auto">
                    <div class="bg-white rounded-lg shadow-lg overflow-x-auto md:overflow-x-visible">
                        <div class="flex flex-col md:flex-row items-center justify-between md:px-6 py-4 border-b">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('fotos/equipos/' . $p->foto_local) }}" width="40" height="40"
                                    alt="" class="rounded-full object-cover" />
                                <div class="font-medium text-lg">{{ $p->nombre_local }}</div>
                                <div class="text-gray-500">vs</div>
                                <img src="{{ asset('fotos/equipos/' . $p->foto_visitante) }}" width="40"
                                    height="40" alt="" class="rounded-full object-cover" />
                                <div class="font-medium text-lg">{{ $p->nombre_visitante }}</div>
                            </div>
                            <div class="text-2xl font-bold mt-4 md:mt-0 text-center text-[--color-primary]">
                                {{ $p->golesEquipoLocal }} - {{ $p->golesEquipoVisitante }}</div>
                        </div>
                        <div class="flex flex-col md:flex-row items-center justify-between px-6 py-2 text-gray-600">
                            <div class="flex items-center gap-2 mb-2 md:mb-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V7a1 1 0 011-1z" />
                                </svg>
                                <span class="whitespace-nowrap">{{ $p->horario }} PM</span>
                            </div>
                            <div class="flex items-center gap-2 mb-2 md:mb-0">
                                <img class="w-4 h-4 mr-1" src="{{ asset('fotos/calendario-icono.jpeg') }}"
                                    alt="">
                                <span class="whitespace-nowrap">{{ $p->dia }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <img class="w-4 h-4 mr-1" src="{{ asset('fotos/cancha-icono.jpeg') }}" alt="">
                                <span class="whitespace-nowrap">Cancha {{ $p->cancha }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    @else
    @foreach ($partidos->where('idGrupo', $g->id) as $p)
                <div class="grid gap-6 p-1 md:p-6 bg-gray-50 w-full md:w-auto">
                    <div class="bg-white rounded-lg shadow-lg overflow-x-auto md:overflow-x-visible">
                        <div class="flex flex-col md:flex-row items-center justify-between md:px-6 py-4 border-b">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('fotos/equipos/' . $p->foto_local) }}" width="40" height="40"
                                    alt="" class="rounded-full object-cover" />
                                <div class="font-medium text-lg">{{ $p->nombre_local }}</div>
                                <div class="text-gray-500">vs</div>
                                <img src="{{ asset('fotos/equipos/' . $p->foto_visitante) }}" width="40"
                                    height="40" alt="" class="rounded-full object-cover" />
                                <div class="font-medium text-lg">{{ $p->nombre_visitante }}</div>
                            </div>
                            <div class="text-2xl font-bold mt-4 md:mt-0 text-center text-[--color-primary]">
                                {{ $p->golesEquipoLocal }} - {{ $p->golesEquipoVisitante }}</div>
                        </div>
                        <div class="flex flex-col md:flex-row items-center justify-between px-6 py-2 text-gray-600">
                            <div class="flex items-center gap-2 mb-2 md:mb-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V7a1 1 0 011-1z" />
                                </svg>
                                <span class="whitespace-nowrap">{{ $p->horario }} PM</span>
                            </div>
                            <div class="flex items-center gap-2 mb-2 md:mb-0">
                                <img class="w-4 h-4 mr-1" src="{{ asset('fotos/calendario-icono.jpeg') }}"
                                    alt="">
                                <span class="whitespace-nowrap">{{ $p->dia }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <img class="w-4 h-4 mr-1" src="{{ asset('fotos/cancha-icono.jpeg') }}" alt="">
                                <span class="whitespace-nowrap">Cancha {{ $p->cancha }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var idEdicion = "{{ $EdicionSeleccionada->id }}";
        var idCategoria = new URLSearchParams(window.location.search).get('idCategoria') || '';
        var idFecha = new URLSearchParams(window.location.search).get('idFecha') || '';
        var url = "{{ route('fixture') }}";

        // Mostrar u ocultar filtros
        function toggleFiltersVisibility() {
            const fechaFilterContainer = document.querySelector('.filtro-fecha');

            const categoriaFilterSelected = idCategoria.trim() !== '';


            // Mostrar el filtro de fecha solo si se ha seleccionado una categoría y un grupo
            fechaFilterContainer.classList.toggle('hidden', !(categoriaFilterSelected));
        }

        // Actualizar la URL con los filtros seleccionados
        function updateUrl(params) {
            var newUrl = new URL(url);
            Object.keys(params).forEach(function(key) {
                if (params[key]) {
                    newUrl.searchParams.set(key, params[key]);
                } else {
                    newUrl.searchParams.delete(key);
                }
            });
            window.location.href = newUrl;
        }

        // Añadir eventos a cada filtro de "Categoria"
        document.querySelectorAll('.filtro-categoria [data-id]').forEach(function(item) {
            item.addEventListener('click', function() {
                idCategoria = this.getAttribute('data-id');
                document.querySelectorAll('.filtro-categoria [data-id]').forEach(function(i) {
                    i.classList.remove('active');
                });
                this.classList.add('active');
                toggleFiltersVisibility();
                updateUrl({
                    idCategoria,
                    idEdicion,
                    idFecha,
                });
            });
        });

        // Añadir eventos a cada filtro de "Fecha"
        document.querySelectorAll('.filtro-fecha [data-id]').forEach(function(item) {
            item.addEventListener('click', function() {
                idFecha = this.getAttribute('data-id');
                updateUrl({
                    idCategoria,
                    idEdicion,
                    idFecha,
                });
            });
        });

        // Inicializar el estado de visibilidad de los filtros
        toggleFiltersVisibility();
    });
</script>
