@include('head')
<div class="min-h-screen bg-[--color-primary] flex flex-col">
    @include('layouts.navigation')
    <main class="container mx-auto px-4 py-8 flex-grow">
        <?php
        $indexOro = 0;
        $indexPlata = 0;
        // Mientras haya campeones de oro o plata por mostrar
        while ($indexOro < count($campeonesOro) || $indexPlata < count($campeonesPlata)) {
            // Mostrar campeón de oro si hay disponible
            if ($indexOro < count($campeonesOro)) {
                $campeonOro = $campeonesOro[$indexOro];
                ?>
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="px-4 py-6">
                <h2 class="text-center text-2xl font-bold text-yellow-400 mb-4">
                    Campeón copa de oro {{$campeonOro->categoria->nombreCategoria}}
                </h2>
                <div class="mt-4 flex items-center justify-center">
                    <img class="h-24 w-24 rounded-full object-cover mr-4" src="{{ asset('fotos/equipos/' . $campeonOro->equipo->foto) }}"
                        alt="Logo de {{$campeonOro->equipo->nombre}}">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{$campeonOro->equipo->nombre}}
                    </h3>
                </div>
            </div>
        </div>
        <?php
                $indexOro++;
            }
    
            // Mostrar campeón de plata si hay disponible
            if ($indexPlata < count($campeonesPlata)) {
                $campeonPlata = $campeonesPlata[$indexPlata];
                ?>
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="px-4 py-6">
                <h2 class="text-center text-2xl font-bold text-gray-400 mb-4">
                    Campeón copa de plata {{$campeonPlata->categoria->nombreCategoria}}
                </h2>
                <div class="mt-4 flex items-center justify-center">
                    <img class="h-24 w-24 rounded-full object-cover mr-4" src="Imagenes/<?php echo $campeonPlata['foto_equipo']; ?>"
                        alt="Logo de {{$campeonPlata->equipo->nombre}}">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{$campeonPlata->equipo->nombre}}
                    </h3>
                </div>
            </div>
        </div>
        <?php
                $indexPlata++;
            }
        }
        ?>
    </main>
    @include('layouts.footer')
</div>
