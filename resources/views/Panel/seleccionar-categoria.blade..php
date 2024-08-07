@extends('admin')

@section('contenido')
<div class="mb-5">
    <label for="idEquipo" class="mb-3 block text-base font-medium text-white">
        Seleccionar Equipo
    </label>
    <select name="idEquipo" id="idEquipo" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
        @foreach ($equipos as $equipo)
        <option value="{{ $equipo->id }}" {{ old('idEquipo', $campeon->idEquipo) == $equipo->id ? 'selected' : '' }}>
            {{ $equipo->nombre }}
        </option>
        @endforeach
    </select>
</div>
@endsection