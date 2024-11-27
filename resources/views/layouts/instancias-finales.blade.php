@include('head')
<div class="bg-[--color-secondary] w-full min-h-screen text-foreground">
    @include('layouts.navigation')
    <div class="grid gap-6 p-1 md:p-6 md:bg-[--color-secondary] w-full md:w-auto">
        <div class="bg-white md:p-6">
            <!-- Formulario para filtrar por categoría -->
            <form method="GET" action="{{ route('instancias-finales') }}"
                class="mb-4 flex flex-col md:flex-row items-center gap-4">
                <label for="categoria" class="font-medium text-2xl">Filtrar por categoría:</label>
                <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
                <div class="flex flex-row">
                    <div class="relative">
                        <select name="categoria" id="categoria"
                            class="p-2 border rounded w-auto appearance-none bg-white text-gray-700">
                            <option value="">Todas las categorías</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ $selectedCategoria == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombreCategoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="ml-5 py-2 px-4 bg-blue-500 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Filtrar</button>
                </div>
            </form>

            @php
                $currentCategory = null;
            @endphp
            @foreach ($partidos->groupBy('nombre_categoria') as $categoria => $partidosPorCategoria)
                <div class="mb-4">
                    <h2 class="text-2xl p-3 text-center font-bold">{{ $categoria }}</h2>
                    @foreach ($partidosPorCategoria->groupBy('nombre_copa') as $copa => $partidosPorCopa)
                        <div class="mb-2 ml-4">
                            <h3 class="text-xl text-center font-semibold">{{ $copa }}</h3>
                            @foreach ($partidosPorCopa->groupBy('nombre_fase') as $fase => $partidosPorFase)
                                <div class="mb-2">
                                    <h4 class="text-lg text-center font-semibold">{{ $fase }}</h4>
                                    @foreach ($partidosPorFase as $p)
                                        <div class="grid gap-4 p-6">
                                            <div class="bg-card rounded-lg shadow-sm">
                                                <div
                                                    class="flex flex-col md:flex-row items-center justify-between py-4">
                                                    <div
                                                        class="flex flex-row items-center justify-between w-full gap-4">
                                                        <!-- Equipo Local -->
                                                        <div
                                                            class="flex flex-col items-center md:flex-row md:items-center gap-2 w-1/3 sm:w-auto">
                                                            <img src="{{ asset('fotos/equipos/' . $p->equipoLocal->foto) }}"
                                                                width="40" height="40"
                                                                alt="{{ $p->equipoLocal->nombre }}" class="rounded-full"
                                                                style="aspect-ratio: 1; object-fit: cover;" />
                                                            <div class="text-xs sm:text-base font-bold text-center truncate">
                                                                {{ $p->equipoLocal->nombre }}
                                                            </div>
                                                        </div>
                                                        <!-- Separador VS -->
                                                        <div
                                                            class="flex items-center justify-center text-muted-foreground text-center w-1/6 sm:w-auto">
                                                            vs
                                                        </div>
                                                        <!-- Equipo Visitante -->
                                                        <div
                                                            class="flex flex-col items-center md:flex-row md:items-center gap-2 w-1/3 sm:w-1/2">
                                                            <img src="{{ asset('fotos/equipos/' . $p->equipoVisitante->foto) }}"
                                                                width="40" height="40"
                                                                alt="{{ $p->equipoVisitante->nombre }}"
                                                                class="rounded-full"
                                                                style="aspect-ratio: 1; object-fit: cover;" />
                                                            <div class="text-xs sm:text-base font-bold text-center truncate">
                                                                {{ $p->equipoVisitante->nombre }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="flex flex-col text-center text-2xl font-bold mt-4 md:mt-0 sm:w-1/12">
                                                        <span>{{ $p->golesEquipoLocal }} -
                                                            {{ $p->golesEquipoVisitante }}</span>
                                                        @if (
                                                            $p->golesEquipoLocal !== null &&
                                                                $p->golesEquipoVisitante !== null &&
                                                                $p->golesEquipoLocal === $p->golesEquipoVisitante &&
                                                                $p->penalesEquipoLocal !== null &&
                                                                $p->penalesEquipoVisitante !== null)
                                                            <span>({{ $p->penalesEquipoLocal }} -
                                                                {{ $p->penalesEquipoVisitante }})</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col md:flex-row items-center justify-between px-6 py-2 text-muted-foreground">
                                                    <div class="flex items-center gap-2 mb-2 md:mb-0">
                                                        <img class="w-4 h-4 mr-1"
                                                            src="{{ asset('fotos/reloj-icono.jpeg') }}" alt="">
                                                        <span>{{ \Carbon\Carbon::parse($p->horario)->format('d-m-Y H:i') }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <img class="w-4 h-4 mr-1"
                                                            src="{{ asset('fotos/cancha-icono.jpeg') }}"
                                                            alt="">
                                                        <span class="whitespace-nowrap">Cancha
                                                            {{ $p->cancha }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
