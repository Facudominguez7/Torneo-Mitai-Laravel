@extends('Panel.admin')
@section('detalle')
    <div class="border rounded-lg p-1 lg:w-full lg:mt-0 lg:mr-5 w-full flex justify-start flex-col bg-gray-100 mt-2">
        <h2 class="text-center mb-3 font-bold text-xl">{{ $nombreGrupo }}</h2>
        <table class="border-collapse w-auto">
            <thead>
                <tr>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                        Equipos
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equiposGrupo as $eg)
                    <tr
                        class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-1 lg:mb-0">
                        <td
                            class="w-full lg:w-auto p-0 lg:p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            {{ $eg->nombreEquipo }}
                        </td>
                    </tr>
                @endforeach

                @if (count($equiposGrupo) === 0)
                    <tr>
                        <td colspan='2'>No hay equipos registrados para este grupo.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
