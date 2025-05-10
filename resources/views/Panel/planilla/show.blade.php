@extends('Panel.admin')

@section('detalle')
@include('components.loader')

<div class="w-full p-6 bg-white rounded-lg shadow-md">
    <!-- Botón de Volver -->
    <a href="{{ $tipoPartido === 'instanciaFinal' ? route('instancia_final', ['idEdicion' => $EdicionSeleccionada->id, 'horario' => $horarioSeleccionado]) : route('admin', ['idEdicion' => $EdicionSeleccionada->id, 'horario' => $horarioSeleccionado]) }}"
        class="inline-block mb-4 text-blue-500 hover:text-blue-700">
        <svg class="w-6 h-6 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Volver
    </a>
    <h1 class="text-2xl font-bold mb-4">Planilla de Jugadores - Partido {{ $partido->id }}</h1>

    <!-- Equipo Local -->
    <h2 class="text-xl font-semibold mb-2 text-center">{{ $partido->equipoLocal->nombre }}</h2>
    <!-- Botón para generar el PDF -->
    <div class="flex justify-end">
        <a href="{{ route('reporte.jugadores', ['equipoId' => $partido->idEquipoLocal, 'idEdicion' => $EdicionSeleccionada->id, 'partidoId' => $partido->id]) }}"
            class="inline-block mb-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-300">
            Generar PDF
        </a>
     </div>
    <form action="{{ route('planilla.agregarJugador') }}" method="POST" class="mb-4">
        @csrf
        <input type="hidden" name="partido_id" value="{{ $partido->id }}">
        <input type="hidden" name="equipo_id" value="{{ $partido->idEquipoLocal }}">
        <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
        <input type="hidden" name="horario" value="{{ $horarioSeleccionado }}">
        <input type="hidden" name="tipoPartido" value="{{ $tipoPartido }}">
        <input type="hidden" name="idCategoria" value="{{ $partido->idCategoria }}">
        <details class="mb-4">
            <summary
                class="cursor-pointer text-lg font-medium text-gray-700 bg-gray-200 p-2 rounded-md hover:bg-gray-300 transition duration-300 ease-in-out">
                Agregar Jugador a la Lista de Buena Fe
            </summary>
            <!-- Campo para el nombre del jugador -->
            <div class="mb-2">
                <label for="nombre_jugador" class="block text-sm font-medium text-gray-700">Nombre del Jugador:</label>
                <input type="text" name="nombre_jugador" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para el apellido del jugador -->
            <div class="mb-2">
                <label for="apellido_jugador" class="block text-sm font-medium text-gray-700">Apellido del
                    Jugador:</label>
                <input type="text" name="apellido_jugador" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para el DNI del jugador -->
            <div class="mb-2">
                <label for="dni_jugador" class="block text-sm font-medium text-gray-700">DNI Jugador:</label>
                <input type="text" name="dni_jugador" required pattern="\d{7,}"
                    title="El DNI debe tener 7 dígitos o más"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para el número de camiseta -->
            <div class="mb-2">
                <label for="numero_camiseta" class="block text-sm font-medium text-gray-700">Número de Camiseta:</label>
                <input type="number" name="numero_camiseta" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <!-- Campo para la fecha de nacimiento -->
            <div class="mb-2">
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de
                    Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Botón para agregar el jugador -->
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Agregar Jugador</button>
        </details>
    </form>
    <!-- Formulario para actualizar jugadores Locales -->
    <h3 class="text-lg font-semibold mb-2 text-center">Lista de Buena Fe</h3>
    <form action="{{ route('planilla.actualizarJugadores') }}" method="POST">
        @csrf
        <input type="hidden" name="partido_id" value="{{ $partido->id }}">
        <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
        <input type="hidden" name="horario" value="{{ $horarioSeleccionado }}">
        <input type="hidden" name="tipoPartido" value="{{ $tipoPartido }}">

        @if ($jugadoresLocalPlanilla->isEmpty())
        <p class="text-center">No hay jugadores en el equipo local.</p>
        @else
        <table class="min-w-full bg-white border border-gray-200 mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Nombre</th>
                    <th class="px-4 py-2 border-b">Fecha de Nacimiento</th>
                    <th class="px-4 py-2 border-b">DNI</th>
                    <th class="px-4 py-2 border-b">Número de Camiseta</th>
                    <th class="px-4 py-2 border-b">Goles</th>
                    <th class="px-4 py-2 border-b">Asistencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jugadoresLocalPlanilla as $jugador)
                <tr>
                    <td class="px-4 py-2 border-b text-center">
                        {{ $jugador->nombre }} {{ $jugador->apellido }}
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        {{ \Carbon\Carbon::parse($jugador->fecha_nacimiento)->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        {{ number_format($jugador->dni_jugador, 0, '', '.') }}
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        <input type="number" name="jugadores[{{ $jugador->dni_jugador }}][numero_camiseta]"
                            value="{{ $jugador->numero_camiseta }}"
                            class="w-16 border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        <input type="number" name="jugadores[{{ $jugador->dni_jugador }}][goles]"
                            value="{{ $jugador->goles }}" class="w-16 border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        <input type="checkbox" name="jugadores[{{ $jugador->dni_jugador }}][asistencia]"
                            {{ $jugador->asistio ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md mt-4">Actualizar Todos</button>
    </form>
    <hr class="my-4 border-t-2 border-gray-500">

    <!-- Equipo Visitante -->
    <h2 class="text-xl font-semibold mb-2 text-center">{{ $partido->equipoVisitante->nombre }}</h2>
     <!-- Botón para generar el PDF -->
     <div class="flex justify-end">
        <a href="{{ route('reporte.jugadores', ['equipoId' => $partido->idEquipoVisitante, 'idEdicion' => $EdicionSeleccionada->id, 'partidoId' => $partido->id]) }}"
            class="inline-block mb-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-300">
            Generar PDF
        </a>
     </div>
    <form action="{{ route('planilla.agregarJugador') }}" method="POST" class="mb-4">
        @csrf
        <input type="hidden" name="partido_id" value="{{ $partido->id }}">
        <input type="hidden" name="equipo_id" value="{{ $partido->idEquipoVisitante }}">
        <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
        <input type="hidden" name="horario" value="{{ $horarioSeleccionado }}">
        <input type="hidden" name="tipoPartido" value="{{ $tipoPartido }}">
        <input type="hidden" name="idCategoria" value="{{ $partido->idCategoria }}">
        <details class="mb-4">
            <summary
                class="cursor-pointer text-lg font-medium text-gray-700 bg-gray-200 p-2 rounded-md hover:bg-gray-300 transition duration-300 ease-in-out">
                Agregar Jugador a la Lista de Buena Fe
            </summary>
            <!-- Campo para el nombre del jugador -->
            <div class="mb-2">
                <label for="nombre_jugador" class="block text-sm font-medium text-gray-700">Nombre del
                    Jugador:</label>
                <input type="text" name="nombre_jugador" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para el apellido del jugador -->
            <div class="mb-2">
                <label for="apellido_jugador" class="block text-sm font-medium text-gray-700">Apellido del
                    Jugador:</label>
                <input type="text" name="apellido_jugador" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para el DNI del jugador -->
            <div class="mb-2">
                <label for="dni_jugador" class="block text-sm font-medium text-gray-700">DNI Jugador:</label>
                <input type="text" name="dni_jugador" required pattern="\d{7,}"
                    title="El DNI debe tener 7 dígitos o más"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para el número de camiseta -->
            <div class="mb-2">
                <label for="numero_camiseta" class="block text-sm font-medium text-gray-700">Número de
                    Camiseta:</label>
                <input type="number" name="numero_camiseta" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para la fecha de nacimiento -->
            <div class="mb-2">
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de
                    Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Agregar Jugador</button>
        </details>
    </form>

    <!-- Formulario para actualizar jugadores Visitantes -->
    <h3 class="text-lg font-semibold mb-2 text-center">Lista de Buena Fe</h3>
    <form action="{{ route('planilla.actualizarJugadores') }}" method="POST">
        @csrf
        <input type="hidden" name="partido_id" value="{{ $partido->id }}">
        <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
        <input type="hidden" name="horario" value="{{ $horarioSeleccionado }}">
        <input type="hidden" name="tipoPartido" value="{{ $tipoPartido }}">

        @if ($jugadoresVisitantePlanilla->isEmpty())
        <p class="text-center">No hay jugadores en el equipo local.</p>
        @else
        <table class="min-w-full bg-white border border-gray-200 mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Nombre</th>
                    <th class="px-4 py-2 border-b">Fecha de Nacimiento</th>
                    <th class="px-4 py-2 border-b">DNI</th>
                    <th class="px-4 py-2 border-b">Número de Camiseta</th>
                    <th class="px-4 py-2 border-b">Goles</th>
                    <th class="px-4 py-2 border-b">Asistencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jugadoresVisitantePlanilla as $jugador)
                <tr>
                    <td class="px-4 py-2 border-b text-center">
                        {{ $jugador->nombre }} {{ $jugador->apellido }}
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        {{ \Carbon\Carbon::parse($jugador->fecha_nacimiento)->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        {{ number_format($jugador->dni_jugador, 0, '', '.') }}
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        <input type="number" name="jugadores[{{ $jugador->dni_jugador }}][numero_camiseta]"
                            value="{{ $jugador->numero_camiseta }}"
                            class="w-16 border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        <input type="number" name="jugadores[{{ $jugador->dni_jugador }}][goles]"
                            value="{{ $jugador->goles }}" class="w-16 border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        <input type="checkbox" name="jugadores[{{ $jugador->dni_jugador }}][asistencia]"
                            {{ $jugador->asistio ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md mt-4">Actualizar Todos</button>
    </form>
</div>
@endsection