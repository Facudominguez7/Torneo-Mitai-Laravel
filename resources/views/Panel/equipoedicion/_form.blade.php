@csrf
<div class="mb-5">
    <label for="idEquipo" class="mb-3 block text-base font-medium text-white">
        Seleccionar Equipo
    </label>
    <select name="idEquipo" id="idEquipo"
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
    <label for="idEdicion" class="mb-3 block text-base font-medium text-white">
        El equipo se va a agregar en esta Edicion
    </label>
    <input type="text" name="idEdicion" id="idEdicion" value="{{ $EdicionSeleccionada->nombre }}"
        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" readonly>
</div>
