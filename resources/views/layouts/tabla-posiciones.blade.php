@include('head')
<div class="min-h-screen bg-[--color-primary] flex flex-col">
    @include('layouts.navigation')
    <main class="flex-grow">
        <section
            class="mx-auto w-full h-full max-w-full flex flex-col items-center md:px-6 lg:px-8 pt-8">
            <h1 class="text-2xl font-bold text-center text-white mb-6">Tabla de Posiciones - {{ $nombreCategoria }}</h1>
            <div class="w-full mx-auto md:p-4">
                <div class="overflow-x-scroll md:overflow-x-auto">
                    <table class="min-w-[500px] md:min-w-full bg-white border border-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-gray-100">
                                <th
                                    class="text-center text-sm font-medium text-gray-600 bg-white hidden md:table-cell w-1/12 md:w-auto">
                                    Puesto</th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-gray-100 w-2/12 md:w-auto">
                                    <span class="md:hidden">Equipo</span>
                                    <span class="hidden md:inline">Logo</span>
                                </th>
                                <th
                                    class="text-center text-sm font-medium text-gray-600 bg-white hidden md:table-cell w-2/12 md:w-auto">
                                    Nombre</th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-gray-200 w-1/12 md:w-auto">
                                    Pts</th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-white w-1/12 md:w-auto">J
                                </th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-gray-200 w-1/12 md:w-auto">G
                                </th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-white w-1/12 md:w-auto">E
                                </th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-gray-200 w-1/12 md:w-auto">P
                                </th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-white w-1/12 md:w-auto">GF
                                </th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-gray-200 w-1/12 md:w-auto">
                                    GC</th>
                                <th class="text-center text-sm font-medium text-gray-600 bg-white w-1/12 md:w-auto">DF
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $posicion = 1; @endphp
                            @foreach ($tablaPosiciones as $filaTabla)
                                <tr class="border-t border-gray-400">
                                    <td
                                        class="px-1 py-2 text-center text-sm text-gray-700 bg-white hidden md:table-cell w-1/12">
                                        {{ $posicion }}°
                                    </td>
                                    <td
                                        class="flex items-center py-3 text-sm text-gray-700 md:justify-center bg-gray-100 gap-2 w-full flex-nowrap">
                                        <div class="pl-2 md:hidden">
                                            {{ $posicion }}°
                                        </div>
                                        <img class="w-8 h-8 flex-shrink-0"
                                            src="{{ asset('fotos/equipos/' . $filaTabla->fotoEquipo) }}"
                                            alt="logo {{ $filaTabla->nombreEquipo }}"
                                            class="w-1/5">
                                        <span
                                            class="inline md:hidden whitespace-normal break-words max-w-[95px] flex-shrink-0 pr-8">
                                            {{ $filaTabla->nombreEquipo }}
                                        </span>
                                    </td>
                                    <td
                                        class="py-1 text-center text-sm text-gray-700 hidden md:table-cell bg-white w-2/12 md:w-auto">
                                        {{ $filaTabla->nombreEquipo }}</td>
                                    <td class=" text-center text-sm text-gray-700 bg-gray-200 w-1/12 md:w-auto">
                                        {{ $filaTabla->puntos }}</td>
                                    <td class="px-1 text-center text-sm text-gray-700 bg-white w-1/12 md:w-auto">
                                        {{ $filaTabla->jugado }}</td>
                                    <td class="px-1 text-center text-sm text-gray-700 bg-gray-200 w-1/12 md:w-auto">
                                        {{ $filaTabla->ganado }}</td>
                                    <td class="px-1 text-center text-sm text-gray-700 bg-white w-1/12 md:w-auto">
                                        {{ $filaTabla->empatado }}</td>
                                    <td class="px-1 text-center text-sm text-gray-700 bg-gray-200 w-1/12 md:w-auto">
                                        {{ $filaTabla->perdido }}</td>
                                    <td class="px-1 text-center text-sm text-gray-700 bg-white w-1/12 md:w-auto">
                                        {{ $filaTabla->golesFavor }}</td>
                                    <td class="px-1 text-center text-sm text-gray-700 bg-gray-200 w-1/12 md:w-auto">
                                        {{ $filaTabla->golesContra }}</td>
                                    <td class="px-1 text-center text-sm text-gray-700 bg-white w-1/12 md:w-auto">
                                        {{ $filaTabla->diferenciaGoles }}</td>
                                </tr>
                                @php $posicion++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    @include('layouts.footer')
</div>
