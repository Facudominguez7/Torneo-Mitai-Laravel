@extends('Panel.admin')

@section('contenido')
    <div class="bg-white rounded-lg p-6">
        <h1 class="text-2xl font-bold">Partidos de Fútbol</h1>
        <div class="mt-2">
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V7a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Filtrar por fecha
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V7a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div
                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <x-dropdown-link href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    role="menuitem">Hoy</x-dropdown-link>
                                <x-dropdown-link href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    role="menuitem">Mañana</x-dropdown-link>
                                <x-dropdown-link href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    role="menuitem">Esta semana</x-dropdown-link>
                                <x-dropdown-link href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    role="menuitem">Este mes</x-dropdown-link>
                            </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
    @foreach ($partidos as $p)
        <div class="grid gap-4 p-6">
            <div class="bg-card rounded-lg shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">

                    <div class="flex items-center gap-2">
                        <img src="/placeholder.svg" width="40" height="40" alt="Real Madrid Logo"
                            class="rounded-full" style="aspect-ratio: 40/40; object-fit: cover;" />
                        <div class="font-medium">{{$p->equipoLocal->nombre}}</div>
                        <div class="text-muted-foreground">vs</div>
                        <img src="/placeholder.svg" width="40" height="40" alt="Barcelona Logo" class="rounded-full"
                            style="aspect-ratio: 40/40; object-fit: cover;" />
                        <div class="font-medium">{{$p->equipoVisitante->nombre}}</div>
                    </div>
                    <div class="text-2xl font-bold">{{$p->golesEquipoLocal}} - {{$p->golesEquipoVisitante}}</div>
                </div>
                <div class="flex items-center justify-between px-6 py-2 text-muted-foreground">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 inline-block" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V7a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{$p->horario}} PM
                    </div>
                    <div>
                        <MapPinIcon className="w-4 h-4 mr-1 inline-block" />
                        Cancha {{$p->cancha}}
                      </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 inline-block" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V7a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{$p->dia->diaPartido}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="flex justify-center">
        {{ $partidos->links() }}
    </div>
@endsection
