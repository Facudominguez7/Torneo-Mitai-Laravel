@csrf
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

<div class="mb-5">
    <label for="idCopa" class="mb-3 block text-base font-medium text-white">
        Seleccionar Copa
    </label>
    <select name="idCopa" id="idCopa" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
        @foreach ($copas as $copa)
        <option value="{{ $copa->id }}" {{ old('idCopa', $campeon->idCopa) == $copa->id ? 'selected' : '' }}>
            {{ $copa->nombre }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-5">
    <label for="idEdicion" class="mb-3 block text-base font-medium text-white">
        Edición
    </label>
    <select name="idEdicion" id="idEdicion" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
        @foreach ($ediciones as $edicion)
        <option value="{{ $edicion->id }}" {{ old('idEdicion', $campeon->idEdicion) == $edicion->id ? 'selected' : '' }}>
            {{ $edicion->nombre }}
        </option>
        @endforeach
    </select>
</div>