@include('head')
<div class="min-h-screen bg-[--color-primary] flex flex-col">
    @include('layouts.navigation')
    <main class="container mx-auto px-4 py-8 flex-grow">
        @if (count($vallas) > 0)
            @foreach ($vallas as $valla)
                @php
                    // Obtener la categoría y otras informaciones relevantes
                    $categoria_nombre = $valla['categoria_nombre'];
                    $nombre_jugador = $valla['nombre_jugador'];
                    $nombre_equipo = $valla['nombre_equipo'];
                    $foto_equipo = $valla['foto_equipo'];
                @endphp

                <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-8">
                    <div class="px-4 py-6">
                        <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">
                            Arquero de la {{ $categoria_nombre }}
                        </h2>
                        <div class="mt-4 flex items-center justify-center">
                            <img class="h-24 w-24 rounded-full object-cover mr-4"
                                src="{{ asset('fotos/equipos/' . $foto_equipo) }}" alt="{{ $nombre_equipo }}">
                            <div>
                                @if (!isset($nombre_jugador))
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $nombre_jugador }}
                                    </h3>
                                @else
                                    <h3 class="text-lg font-medium text-gray-900">
                                        Sin Nombre de Arquero registrado
                                    </h3>
                                @endif
                                <p class="text-lg font-medium text-gray-900">
                                    {{ $nombre_equipo }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-3xl lg:text-4xl font-bold text-white text-center justify-center">Sin Registros</p>
        @endif
    </main>
    @include('layouts.footer')
</div>
