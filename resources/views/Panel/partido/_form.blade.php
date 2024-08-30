@csrf
@if (isset($GrupoSeleccionado))
    <div class="mb-5">
        <label for="nombre" class="mb-3 block text-base font-medium text-white">
            Grupo
        </label>
        <select name="idGrupo" id="idGrupo"
            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">

            <option value="{{ $GrupoSeleccionado->id }}" selected>{{ $GrupoSeleccionado->nombre }}
            </option>
        </select>
    </div>
@else
    <input class="hidden" type="number" name="idGrupo" id="idGrupo" value="{{ $idGrupo }}">
@endif
@if (isset($CategoriaSeleccionada))
    <div class="mb-5">
        <label for="categoría" class="mb-3 block text-base font-medium text-white">
            Categoría
        </label>
        <select id="idCategoria" name="idCategoria"
            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">

            <option value="{{ $CategoriaSeleccionada->id }}" selected>{{ $CategoriaSeleccionada->nombreCategoria }}
            </option>
        </select>
    </div>
@else
    <input class="hidden" type="number" name="idCategoria" id="idCategoria" value="{{ $idCategoria }}">
@endif
<div class="mb-5">
    <label for="idEquipo" class="mb-3 block text-base font-medium text-white">
        Seleccionar Equipo Local
    </label>
    <select name="idEquipoLocal" id="idEquipoLocal"
        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
        @foreach ($equipos as $equipo)
            <option value="{{ $equipo->id }}"
                {{ old('idEquipo', $equipo->id) == $equipo->id ? 'selected' : '' }}>
                {{ $equipo->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-5">
    <label for="idEquipo" class="mb-3 block text-base font-medium text-white">
        Seleccionar Equipo Visitante
    </label>
    <select name="idEquipoVisitante" id="idEquipoVisitante"
        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
        @foreach ($equipos as $equipo)
            <option value="{{ $equipo->id }}"
                {{ old('idEquipo', $equipo->id) == $equipo->id ? 'selected' : '' }}>
                {{ $equipo->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-5">
    <label for="idFechas" class="mb-3 block text-base font-medium text-white">
        Seleccionar Fecha
    </label>
    <select name="idFechas" id="idFechas"
        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
        @foreach ($fechas as $f)
            <option value="{{ $f->id }}"
                {{ old('idFechas', $f->id) == $f->id ? 'selected' : '' }}>
                {{ $f->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-5">
    <label for="idDia" class="mb-3 block text-base font-medium text-white">
        Seleccionar Dia
    </label>
    <select name="idDia" id="idDia"
        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
        @foreach ($dias as $d)
            <option value="{{ $d->id }}"
                {{ old('idDia', $d->id) == $d->id ? 'selected' : '' }}>
                {{ $d->diaPartido }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-5">
    <label for="horario" class="mb-3 block text-base font-medium text-white">
        Horario
    </label>
    <input type="text" name="horario" id="horario" value="{{old('horario', $partido->horario)}}"
        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
         />
</div>
<div class="mb-5">
    <label for="cancha" class="mb-3 block text-base font-medium text-white">
        Cancha
    </label>
    <input type="text" name="cancha" id="cancha" value="{{old('cancha', $partido->cancha)}}"
        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
         />
</div>
<input class="hidden" type="number" name="idEdicion" id="idEdicion" value="{{ $EdicionSeleccionada->id }}">

