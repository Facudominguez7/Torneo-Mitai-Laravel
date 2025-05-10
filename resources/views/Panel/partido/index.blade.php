@extends('Panel.admin')

@section('contenido')
    @if (isset($EdicionSeleccionada))
        <div class="flex flex-row justify-center mb-2">
            <div>
                <a href="{{ route('seleccionar-categoria', ['idEdicion' => $EdicionSeleccionada, 'tipo' => 'partido']) }}">
                    <button
                        class="bg-gray-800 hover:bg-gray-900 mt-2 mb-2 text-white py-2 px-4 rounded-full transition-all duration-300 md:py-3 md:px-6 md:rounded-lg">
                        Agregar Partido
                    </button>
                </a>
            </div>
        </div>
    @endif
    <div class="bg-white p-6">
        <h1 class="text-2xl font-bold">Partidos de Fútbol</h1>
        <div class="mt-2">
            <div x-data="{ open: false }" class="relative inline-block text-left ml-5 filtro-fecha hidden">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 text-black bg-gray-800 hover:bg-gray-900 mt-2 mb-2 text-white py-2 px-4 rounded-full transition-all duration-300">
                            Filtrar por fecha
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        @foreach ($fechas as $f)
                            <div class="cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                data-id="{{ $f->id }}" data-nombre="{{ $f->nombre }}">
                                {{ $f->nombre }}
                            </div>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>
            <div x-data="{ open: false }" class="relative inline-block text-left  filtro-grupo hidden">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 text-black bg-gray-800 hover:bg-gray-900 mt-2 mb-2 text-white py-2 px-4 rounded-full transition-all duration-300">
                            Filtrar por Grupo
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        @foreach ($grupos as $g)
                            <div class="cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                data-id="{{ $g->id }}" data-nombre="{{ $g->nombre }}">
                                {{ $g->nombre }}
                            </div>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>
            <div x-data="{ open: false }" class="relative inline-block text-left filtro-categoria">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 text-black bg-gray-800 hover:bg-gray-900 mt-2 mb-2 text-white py-2 px-4 rounded-full transition-all duration-300">
                            Seleccionar Categoria
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
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
            <div class="ml-5 inline-block items-center mt-4">
                <button id="reset-filters" class="btn btn-eliminar">
                    Eliminar Filtros
                </button>
            </div>
        </div>
        <div class="flex items-center justify-center flex-row mt-5 mb-0">
            @if (isset($nombreFecha))
                <div class="mr-5">
                    <h1 class="text-3xl font-bold">{{ $nombreFecha }}</h1>
                </div>
            @endif
            @if (isset($nombreGrupo))
                <div class="mr-5">
                    <h1 class="text-3xl font-bold">{{ $nombreGrupo }}</h1>
                </div>
            @endif
            @if (isset($nombreCategoria))
                <div class="mr-5">
                    <h1 class="text-3xl font-bold">{{ $nombreCategoria }}</h1>
                </div>
            @endif

        </div>

    </div>
    <div class="bg-white p-6">
        @foreach ($partidos as $p)
            <div class="grid gap-4 p-6 bg-gray-300">
                <div class="bg-card rounded-lg shadow-xl bg-white">
                     <div class="px-6 py-2 text-muted-foreground">
                        <div class="text-xl text-center">{{ $p->fecha->nombre }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row items-center justify-center px-6 py-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('fotos/equipos/' . $p->equipoLocal->foto) }}" width="60" height="60"
                                alt="{{ $p->equipoLocal->nombre }}" class="rounded-full"
                                style="aspect-ratio: 1/1; object-fit: cover;" />
                            <div class="text-xl font-bold">{{ $p->equipoLocal->nombre }}</div>
                            <div class="text-lg font-semibold text-muted-foreground">vs</div>
                            <div class="text-xl font-bold">{{ $p->equipoVisitante->nombre }}</div>
                            <img src="{{ asset('fotos/equipos/' . $p->equipoVisitante->foto) }}" width="60"
                                height="60" alt="{{ $p->equipoVisitante->nombre }}" class="rounded-full"
                                style="aspect-ratio: 1/1; object-fit: cover;" />
                        </div>
                    </div>
                    <div class="text-2xl text-center font-bold mt-4 md:mt-0">{{ $p->golesEquipoLocal }} -
                        {{ $p->golesEquipoVisitante }}
                    </div>
                    <div
                        class="flex flex-col md:flex-row items-center justify-around px-6 py-2 text-muted-foreground text-lg ">
                        <div class="flex items-center gap-2 mb-2 md:mb-0">
                            @if (is_null($p->horario))
                                <span>{{ \Carbon\Carbon::parse($p->horario_datetime)->format('d-m-Y H:i') }}</span>
                            @else
                                <span>{{ $p->horario }} PM</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span>Cancha {{ $p->cancha }}</span>
                        </div>
                    </div>
                    <div class="px-6 py-4 flex justify-center">
                        @if ($p->golesEquipoLocal === null && $p->golesEquipoVisitante === null)
                            <a
                                href="{{ route('cargar-resultado', ['idPartido' => $p->id, 'idEdicion' => $EdicionSeleccionada->id]) }}">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mr-5">
                                    Cargar Resultado
                                </button>
                            </a>
                        @endif
                        <a
                        href="{{ route('planilla.show', ['partidoId' => $p->id, 'idEdicion' => $EdicionSeleccionada->id, 'tipoPartido' => 'partido', 'horario' => $horarioString ?? 0]) }}">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            Planillas
                        </button>
                    </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-5">
        {{ $partidos->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var idEdicion = "{{ $EdicionSeleccionada->id }}";
            var idCategoria = new URLSearchParams(window.location.search).get('idCategoria') || '';
            var idFecha = new URLSearchParams(window.location.search).get('idFecha') || '';
            var idGrupo = new URLSearchParams(window.location.search).get('idGrupo') || '';

            var url = "{{ route('partido.index') }}";

            // Mostrar u ocultar filtros
            function toggleFiltersVisibility() {
                const fechaFilterContainer = document.querySelector('.filtro-fecha');
                const grupoFilterContainer = document.querySelector('.filtro-grupo');
                const categoriaFilterSelected = idCategoria.trim() !== '';
                const grupoFilterSelected = idGrupo.trim() !== '';

                // Mostrar el filtro de grupo solo si se ha seleccionado una categoría
                grupoFilterContainer.classList.toggle('hidden', !categoriaFilterSelected);

                // Mostrar el filtro de fecha solo si se ha seleccionado una categoría y un grupo
                fechaFilterContainer.classList.toggle('hidden', !(categoriaFilterSelected && grupoFilterSelected));
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
                        idGrupo
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
                        idGrupo
                    });
                });
            });

            // Añadir eventos a cada filtro de "Grupo"
            document.querySelectorAll('.filtro-grupo [data-id]').forEach(function(item) {
                item.addEventListener('click', function() {
                    idGrupo = this.getAttribute('data-id');
                    updateUrl({
                        idCategoria,
                        idEdicion,
                        idFecha,
                        idGrupo
                    });
                });
            });

            // Añadir evento al botón de eliminar filtros
            document.getElementById('reset-filters').addEventListener('click', function() {
                updateUrl({
                    idCategoria: '',
                    idEdicion,
                    idFecha: '',
                    idGrupo: ''
                });
            });

            // Inicializar el estado de visibilidad de los filtros
            toggleFiltersVisibility();
        });
    </script>
@endsection
