@include('head')
<div class="bg-[--color-secondary] w-full min-h-screen text-foreground flex flex-col">
    @include('layouts.navigation')
    <main class="flex-grow">
        <div class="bg-[--color-primary] flex justify-center flex-col md:flex-row items-center text-white py-4 px-6">
            <h1 class="text-2xl font-semibold tracking-wide md:text-3xl">Tabla de Goleadores</h1>
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
                                <span class="whitespace-nowrap">Filtrar por Categoría</span>
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
            </div>
        </div>
        <form method="GET" action="{{ url()->current() }}">
            <div class="flex items-center justify-center w-full max-w-md mx-auto p-4">
                <div class="relative flex-1">
                    <input type="text" name="search_value" value="{{ old('search_value', request()->search_value) }}"
                        placeholder="Buscar..."
                        class="w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-12 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
            @foreach (request()->except('search_value') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>
        <div class="mx-auto w-full max-w-2xl flex justify-center items-stretch pb-2 px-2 sm:px-6 lg:px-8">
            <table class="border-collapse w-full mt-2">
                <thead>
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                            Nombre
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                            Equipo
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                            Categoria
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                            Goles
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($goleadores_t->isempty())
                        <tr
                            class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td colspan="6"
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                No existen registros
                            </td>
                        </tr>
                    @endif
                    @foreach ($goleadores_t as $g)
                        <tr
                            class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td
                                class="w-full lg:w-1/3 p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre
                                </span>
                                {{ $g->nombre }}
                            </td>
                            <td
                                class="w-full lg:w-1/3 p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Equipo
                                </span>
                                {{ $g->nombreEquipo }}
                            </td>
                            <td
                                class="w-full lg:w-1/3 p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Categoria
                                </span>
                                {{ $g->nombreCategoria }}
                            </td>
                            <td
                                class="w-full lg:w-1/3 p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Goles
                                </span>
                                {{ $g->cantidadGoles }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-center">
            {{ $goleadores_t->links() }}
        </div>
    </main>
    @include('layouts.footer')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var idEdicion = "{{ $EdicionSeleccionada->id }}";
        var idCategoria = new URLSearchParams(window.location.search).get('idCategoria') || '';
        var url = "{{ route('tabla-goleadores') }}";

        // Mostrar u ocultar filtros
        function toggleFiltersVisibility() {
            const categoriaFilterSelected = idCategoria.trim() !== '';
            // Aquí puedes agregar lógica si necesitas mostrar/ocultar algo basado en la categoría seleccionada
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
                    idEdicion
                });
            });
        });

        // Inicializar el estado de visibilidad de los filtros
        toggleFiltersVisibility();
    });
</script>
