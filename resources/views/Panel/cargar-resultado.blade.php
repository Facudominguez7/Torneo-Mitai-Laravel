@extends('Panel.admin')

@section('contenido')
    @php
        $tipo = request()->query('tipo');
    @endphp
    @if (isset($tipo) && $tipo != 'instancia_final')
        <div class="mb-5">
            <label for="nombre" class="mb-3 block text-base font-medium text-white">
                Grupo
            </label>
            <select name="idGrupo" id="idGrupo"
                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">

                <option value="{{ $partido->idGrupo }}" selected>{{ $partido->grupo->nombre }}</option>
                </option>
            </select>
        </div>
    @endif
    @if (!empty($partido))
        <div class="grid gap-6 p-1 md:p-6 bg-gray-50 w-full md:w-auto mb-5">
            <div class="bg-white rounded-lg shadow-lg overflow-x-auto md:overflow-x-visible">
                <div class="flex flex-col md:flex-row items-center justify-between md:px-6 py-4 border-b">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('fotos/equipos/' . $partido->equipoLocal->foto) }}" width="40" height="40"
                            alt="" class="rounded-full object-cover" />
                        <div class="font-medium text-lg">{{ $partido->equipoLocal->nombre }}</div>
                        <div class="text-gray-500">vs</div>
                        <img src="{{ asset('fotos/equipos/' . $partido->equipoVisitante->foto) }}" width="40"
                            height="40" alt="" class="rounded-full object-cover" />
                        <div class="font-medium text-lg">{{ $partido->equipoVisitante->nombre }}</div>
                    </div>
                    <div class="text-2xl font-bold mt-4 md:mt-0 text-center text-[--color-primary]">
                        {{ $partido->golesEquipoLocal }} - {{ $partido->golesEquipoVisitante }}
                    </div>
                    @if ($tipo === 'instancia_final')
                        <div class="text-2xl font-bold mt-4 md:mt-0 text-center text-[--color-primary]">
                            {{ $partido->penalesEquipoLocal }} - {{ $partido->penalesEquipoVisitante }}
                        </div>
                    @endif
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between px-6 py-2 text-gray-600">
                    <div class="flex items-center gap-2 mb-2 md:mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V7a1 1 0 011-1z" />
                        </svg>
                        <span class="whitespace-nowrap">{{ $partido->horario }} PM</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V7a1-1z" />
                        </svg>
                        <span class="whitespace-nowrap">Cancha {{ $partido->cancha }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route($tipo === 'instancia_final' ? 'cargar-resultado-instancia' : 'cargar-resultado', ['idPartido' => $partido->id, 'idEdicion' => $EdicionSeleccionada->id]) }}"
        method="POST">
        @csrf
        <div class="mb-5">
            <label for="golesEquipoLocal" class="mb-3 block text-base font-medium text-white">
                Goles anotados de <span class="font-bold">{{ $partido->equipoLocal->nombre }}</span>
            </label>
            <input type="number" name="golesEquipoLocal" id="golesEquipoLocal"
                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
        </div>
        <div class="mb-5">
            <label for="golesEquipoVisitante" class="mb-3 block text-base font-medium text-white">
                Goles anotados de <span class="font-bold">{{ $partido->equipoVisitante->nombre }}</span>
            </label>
            <input type="number" name="golesEquipoVisitante" id="golesEquipoVisitante"
                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
        </div>
        @if (isset($tipo) && $tipo === 'instancia_final')
            <div class="mb-5">
                <label for="penalesEquipoLocal" class="mb-3 block text-base font-medium text-white">
                    Penales anotados de <span class="font-bold">{{ $partido->equipoLocal->nombre }}</span>
                </label>
                <input type="number" name="penalesEquipoLocal" id="penalesEquipoLocal"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
            <div class="mb-5">
                <label for="penalesEquipoVisitante" class="mb-3 block text-base font-medium text-white">
                    Penales anotados de <span class="font-bold">{{ $partido->equipoVisitante->nombre }}</span>
                </label>
                <input type="number" name="penalesEquipoVisitante" id="penalesEquipoVisitante"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        @endif
        <input class="hidden" type="number" name="idEdicion" id="idEdicion" value="{{ $EdicionSeleccionada->id }}">
        <div class="px-6 py-4 flex justify-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                Cargar Resultado
            </button>
        </div>
    </form>
@endsection
