@include('head')
<div class="bg-[--color-primary] w-full min-h-screen text-foreground">
    @include('layouts.navigation')
    <div class="grid gap-6 w-full md:w-auto">
        <div>
            <!-- Formulario para filtrar por categoría -->
            <form method="GET" action="{{ route('instancias-finales') }}"
                class="mb-4  p-5 flex flex-col md:flex-row items-center gap-4">
                <label for="categoria" class="font-medium text-2xl text-white">Filtrar por categoría:</label>
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
                    <h2 class="text-2xl p-3 text-center font-bold text-white">{{ $categoria }}</h2>
                    @foreach ($partidosPorCategoria->groupBy('nombre_copa') as $copa => $partidosPorCopa)
                        <div class="mb-2 p-1">
                            <h3 class="text-xl text-center font-semibold text-white">{{ $copa }}</h3>
                            @foreach ($partidosPorCopa->groupBy('nombre_fase') as $fase => $partidosPorFase)
                                <h4 class="text-lg text-center my-3 font-semibold text-white">{{ $fase }}</h4>
                                @foreach ($partidosPorFase as $p)
                                    <div class="grid gap-6 lg:gap-8 lg:p-2 xl:gap-12 xl:p-4">
                                        <div class="bg-card xl:rounded-lg shadow-lg bg-white">
                                            <div
                                                class="flex flex-col md:flex-row items-center justify-between py-4 px-4 lg:px-6 xl:px-8">
                                                <!-- Contenedor general -->
                                                <div
                                                    class="flex items-center justify-center w-full gap-4 lg:gap-6 xl:gap-8">
                                                    <!-- Equipo Local -->
                                                    <div
                                                        class="flex flex-col items-center gap-2 lg:gap-4 w-1/3 text-center">
                                                        <img src="{{ asset('fotos/equipos/' . $p->equipoLocal->foto) }}"
                                                            width="50" height="50"
                                                            alt="{{ $p->equipoLocal->nombre }}"
                                                            class="rounded-full border-2 border-muted-foreground"
                                                            style="aspect-ratio: 1; object-fit: cover;" />
                                                        <div class="text-sm sm:text-base lg:text-lg font-bold truncate">
                                                            {{ $p->equipoLocal->nombre }}
                                                        </div>
                                                    </div>
                                                    <!-- Separador VS -->
                                                    <div
                                                        class="text-muted-foreground text-center text-sm lg:text-base xl:text-lg font-bold">
                                                        vs
                                                    </div>
                                                    <!-- Equipo Visitante -->
                                                    <div
                                                        class="flex flex-col items-center gap-2 lg:gap-4 w-1/3 text-center">
                                                        <img src="{{ asset('fotos/equipos/' . $p->equipoVisitante->foto) }}"
                                                            width="50" height="50"
                                                            alt="{{ $p->equipoVisitante->nombre }}"
                                                            class="rounded-full border-2 border-muted-foreground"
                                                            style="aspect-ratio: 1; object-fit: cover;" />
                                                        <div class="text-sm sm:text-base lg:text-lg font-bold truncate">
                                                            {{ $p->equipoVisitante->nombre }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Goles -->
                                                <div
                                                    class="flex flex-col  text-center text-lg truncate md:text-xl lg:text-2xl font-bold mt-4 md:mt-0">
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
                                                    @if (!is_null($p->resultadoGlobal))
                                                        <span class="text-sm md:mr-2">Global:
                                                            {{ $p->resultadoGlobal }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Información adicional -->
                                            <div
                                                class="flex flex-col md:flex-row items-center justify-between md:justify-around px-4 py-2 lg:px-6 xl:px-8 text-muted-foreground">
                                                <div class="flex items-center gap-2 mb-2 md:mb-0 text-sm lg:text-base">
                                                    <img class="w-5 h-5 lg:w-6 lg:h-6 mr-1"
                                                        src="{{ asset('fotos/reloj-icono.jpeg') }}" alt="">
                                                    <span>{{ \Carbon\Carbon::parse($p->horario)->format('d-m-Y H:i') }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm lg:text-base">
                                                    <img class="w-5 h-5 lg:w-6 lg:h-6 mr-1"
                                                        src="{{ asset('fotos/cancha-icono.jpeg') }}" alt="">
                                                    <span class="whitespace-nowrap">Cancha
                                                        {{ $p->cancha }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
