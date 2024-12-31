@include('head')
<div class="bg-[--color-secondary] w-full min-h-screen text-foreground">
    @include('layouts.navigation')

    <!-- Encabezado -->
    <div class="bg-[--color-primary] flex justify-center flex-col md:flex-row items-center text-white py-4 px-6">
        <h1 class="text-2xl font-semibold tracking-wide md:text-3xl">Fixture {{ $nombreCategoria }}</h1>
        <h1 class="text-2xl mt-1 md:mt-0 md:ml-10 font-semibold tracking-wide md:text-3xl">{{ $nombreFecha }}</h1>
    </div>

    <div class="flex flex-wrap justify-center bg-[--color-primary] text-white py-4 px-6 gap-4">
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
    @if (!is_null($grupos) && $partidos->isNotEmpty())
        @foreach ($grupos as $g)
            <div class="flex flex-col md:flex-row md:justify-evenly items-center bg-[--color-primary] p-3">
                <h2 class="text-2xl text-white font-semibold mb-4">{{ $g->nombre }}</h2>
                <a href="{{ route('tabla-posiciones', ['idCategoria' => $idCategoria, 'idGrupo' => $g->id, 'idEdicion' => $EdicionSeleccionada->id]) }}"
                    class="bg-[--color-secondary] text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-colors duration-300">
                    Tabla de posiciones
                </a>
            </div>
            <h3 class="text-xl text-white font-semibold mb-4">{{ $nombreFecha }}</h3>
            @foreach ($partidos->where('idGrupo', $g->id) as $p)
                <div class="grid gap-6 lg:gap-8 lg:p-2 xl:gap-12 xl:p-4">
                    <div class="bg-card xl:rounded-lg shadow-lg bg-white">
                        <div class="flex items-center justify-center mt-2">
                            <h1 class="text-lg xl:text-2xl font-bold">{{$p->fecha->nombre}}</h1>
                        </div>
                        <div class="flex flex-col md:flex-row items-center justify-between py-4 px-4 lg:px-6 xl:px-8">
                            <!-- Contenedor general -->
                            <div class="flex items-center justify-center w-full gap-4 lg:gap-6 xl:gap-8">
                                <!-- Equipo Local -->
                                <div class="flex flex-col items-center gap-2 lg:gap-4 w-1/3 text-center">
                                    <img src="{{ asset('fotos/equipos/' . $p->foto_local) }}" width="50"
                                        height="50" alt="{{ $p->nombre_local }}"
                                        class="rounded-full border-2 border-muted-foreground"
                                        style="aspect-ratio: 1; object-fit: cover;" />
                                    <div class="text-sm sm:text-base lg:text-lg font-bold truncate">
                                        {{ $p->nombre_local }}
                                    </div>
                                </div>
                                <!-- Separador VS -->
                                <div
                                    class="text-muted-foreground text-center text-sm lg:text-base xl:text-lg font-bold">
                                    vs
                                </div>
                                <!-- Equipo Visitante -->
                                <div class="flex flex-col items-center gap-2 lg:gap-4 w-1/3 text-center">
                                    <img src="{{ asset('fotos/equipos/' . $p->foto_visitante) }}" width="50"
                                        height="50" alt="{{ $p->nombre_visitante }}"
                                        class="rounded-full border-2 border-muted-foreground"
                                        style="aspect-ratio: 1; object-fit: cover;" />
                                    <div class="text-sm sm:text-base lg:text-lg font-bold truncate">
                                        {{ $p->nombre_visitante }}
                                    </div>
                                </div>
                            </div>
                            <!-- Goles -->
                            <div
                                class="flex flex-col text-center text-lg truncate md:text-xl lg:text-2xl font-bold mt-4 md:mt-0">
                                {{ $p->golesEquipoLocal }} - {{ $p->golesEquipoVisitante }}
                            </div>
                        </div>
                        <!-- Información adicional -->
                        <div
                            class="flex flex-col md:flex-row items-center justify-between md:justify-around px-4 py-2 lg:px-6 xl:px-8 text-muted-foreground">
                            <div class="flex items-center gap-2 mb-2 md:mb-0 text-sm lg:text-base">
                                <img class="w-5 h-5 lg:w-6 lg:h-6 mr-1" src="{{ asset('fotos/reloj-icono.jpeg') }}"
                                    alt="">
                                <span>{{ \Carbon\Carbon::parse($p->horario_datetime)->format('d-m-Y H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm lg:text-base">
                                <img class="w-5 h-5 lg:w-6 lg:h-6 mr-1" src="{{ asset('fotos/cancha-icono.jpeg') }}"
                                    alt="">
                                <span class="whitespace-nowrap">Cancha {{ $p->cancha }}</span>
                            </div>
                        </div>
                        <hr class="border-t-2 border-gray-300 my-4 xl:hidden">
                    </div>
                </div>
            @endforeach
        @endforeach
    @else
        <div class="flex items-center justify-center h-1/2">
            <div class="text-center text-white text-2xl font-semibold">
                @if (is_null($grupos))
                    Haz clic en la parte superior para elegir una categoría.
                @else
                    No hay fixture programado.
                @endif
            </div>
        </div>
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

            // Remove idFecha from URL if idCategoria is changed
            if (params.idCategoria !== idCategoria) {
                newUrl.searchParams.delete('idFecha');
            }

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
                    idFecha: '' // Clear idFecha when a new category is selected
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
