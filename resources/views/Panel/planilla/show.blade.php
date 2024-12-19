@extends('Panel.admin')

@section('detalle')
    <div class="w-full max-w-4xl p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Planilla de Jugadores - Partido {{ $partido->id }}</h1>

        <!-- Equipo Local -->
        <h2 class="text-xl font-semibold mb-2 text-center">{{ $partido->equipoLocal->nombre }}</h2>
        <form action="{{ route('planilla.agregarJugador') }}" method="POST" class="mb-4">
            @csrf
            <input type="hidden" name="partido_id" value="{{ $partido->id }}">
            <input type="hidden" name="equipo_id" value="{{ $partido->idEquipoLocal }}">
            <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">

            <!-- Campo para el nombre del jugador -->
            <div class="mb-2">
                <label for="nombre_jugador" class="block text-sm font-medium text-gray-700">Nombre del Jugador:</label>
                <input type="text" name="nombre_jugador" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para el apellido del jugador -->
            <div class="mb-2">
                <label for="apellido_jugador" class="block text-sm font-medium text-gray-700">Apellido del Jugador:</label>
                <input type="text" name="apellido_jugador" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Campo para el DNI del jugador -->
            <div class="mb-2">
                <label for="dni_jugador" class="block text-sm font-medium text-gray-700">DNI Jugador:</label>
                <input type="text" name="dni_jugador" required pattern="\d{8}" title="El DNI debe tener 8 dígitos"
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
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Botón para agregar el jugador -->
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Agregar Jugador</button>
        </form>
        <h3 class="text-lg font-semibold mb-2 text-center">Lista de Buena Fe</h3>
        @if ($jugadoresLocalPlanilla->isEmpty())
            <p class="text-center">No hay jugadores en el equipo local.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200 mb-6">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">Nombre</th>
                        <th class="px-4 py-2 border-b">Fecha de Nacimiento</th>
                        <th class="px-4 py-2 border-b">DNI</th>
                        <th class="px-4 py-2 border-b">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jugadoresLocalPlanilla as $jugador)
                        <tr>
                            <td class="px-4 py-2 border-b text-center">{{ $jugador->nombre }} {{ $jugador->apellido }}</td>
                            <td class="px-4 py-2 border-b text-center">{{ \Carbon\Carbon::parse($jugador->fecha_nacimiento)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 border-b text-center">{{ $jugador->dni_jugador}}</td>
                            <td class="px-4 py-2 border-b">
                                <form action="{{ route('planilla.actualizarJugador') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="partido_id" value="{{ $partido->id }}">
                                    <input type="hidden" name="equipo_id" value="{{ $partido->idEquipoLocal }}">
                                    <input type="hidden" name="dni_jugador" value="{{ $jugador->dni_jugador }}">
                                    <input type="hidden" name="nombre" value="{{ $jugador->nombre }}">
                                    <input type="hidden" name="apellido" value="{{ $jugador->apellido }}">
                                    <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
                                    <input type="hidden" name="idCategoria" value="{{ $partido->idCategoria }}">
                                    <div class="flex items-center space-x-2">
                                        <label for="numero_camiseta" class="text-sm">Número de Camiseta:</label>
                                        <input type="number" name="numero_camiseta"
                                            value="{{ $jugador->numero_camiseta }}"
                                            class="w-16 border-gray-300 rounded-md shadow-sm">
                                        <label for="goles" class="text-sm">Goles:</label>
                                        <input type="number" name="goles" value="{{ $jugador->goles }}"
                                            class="w-16 border-gray-300 rounded-md shadow-sm">
                                        <label for="asistencia" class="text-sm">Asistencia:</label>
                                        <input type="checkbox" name="asistencia" {{ $jugador->asistio ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        <button type="submit"
                                            class="px-2 py-1 bg-green-500 text-white rounded-md">Actualizar</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <hr class="my-4 border-t-2 border-gray-500">

        <!-- Equipo Visitante -->
        <h2 class="text-xl font-semibold mb-2 text-center">{{ $partido->equipoVisitante->nombre }}</h2>
        <form action="{{ route('planilla.agregarJugador') }}" method="POST" class="mb-4">
            @csrf
            <input type="hidden" name="partido_id" value="{{ $partido->id }}">
            <input type="hidden" name="equipo_id" value="{{ $partido->idEquipoVisitante }}">
            <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">

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
                <input type="text" name="dni_jugador" required pattern="\d{8}" title="El DNI debe tener 8 dígitos"
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
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Agregar Jugador</button>
        </form>

        <h3 class="text-lg font-semibold mb-2 text-center">Lista de Buena Fe</h3>
        @if ($jugadoresVisitantePlanilla->isEmpty())
            <p class="text-center">No hay jugadores en el equipo visitante.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">Nombre</th>
                        <th class="px-4 py-2 border-b">Fecha de Nacimiento</th>
                        <th class="px-4 py-2 border-b">DNI</th>
                        <th class="px-4 py-2 border-b">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jugadoresVisitantePlanilla as $jugador)
                        <tr>
                            <td class="px-4 py-2 border-b text-center">{{ $jugador->nombre }} {{ $jugador->apellido }}
                            </td>
                            <td class="px-4 py-2 border-b text-center">{{ \Carbon\Carbon::parse($jugador->fecha_nacimiento)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 border-b text-center">{{ $jugador->dni_jugador}}</td>
                            <td class="px-4 py-2 border-b">
                                <form action="{{ route('planilla.actualizarJugador') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="partido_id" value="{{ $partido->id }}">
                                    <input type="hidden" name="equipo_id" value="{{ $partido->idEquipoVisitante }}">
                                    <input type="hidden" name="dni_jugador" value="{{ $jugador->dni_jugador }}">
                                    <input type="hidden" name="nombre" value="{{ $jugador->nombre }}">
                                    <input type="hidden" name="apellido" value="{{ $jugador->apellido }}">
                                    <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
                                    <input type="hidden" name="idCategoria" value="{{ $partido->idCategoria }}">
                                    <div class="flex items-center space-x-2">
                                        <label for="goles" class="text-sm">Goles:</label>
                                        <input type="number" name="goles" value="{{ $jugador->goles }}"
                                            class="w-16 border-gray-300 rounded-md shadow-sm">
                                        <label for="asistencia" class="text-sm">Asistencia:</label>
                                        <input type="checkbox" name="asistencia" {{ $jugador->asistio ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        <button type="submit"
                                            class="px-2 py-1 bg-green-500 text-white rounded-md">Actualizar</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
