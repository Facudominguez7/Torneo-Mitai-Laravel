@csrf
<div class="mb-5">
    <label for="nombre" class="mb-3 block text-base font-medium text-white">
        Nombre de la Edición
    </label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $edicion->nombre) }}"
        class="w-full rounded-md border border-gray-300 bg-white py-2 px-4 text-base font-medium text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" />
</div>

<div class="mb-5">
    <label for="idCategoria" class="mb-3 block text-base font-medium text-white">Seleccione una categoría para agregar los equipos correspondientes a esta edición</label>
    <select name="idCategoria" id="idCategoria"
        class="w-full rounded-md border border-gray-300 bg-white py-2 px-4 text-base font-medium text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
        <option value="">Seleccione una categoría</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}" {{ old('idCategoria') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombreCategoria }}</option>
        @endforeach
    </select>
</div>

<div class="mb-5" id="equipos-container" style="display: none;">
    @foreach ($equipos as $equipo)
        <div class="flex items-center mb-2 p-4 bg-gray-800 rounded-lg shadow-md equipo" data-categoria-id="{{ $equipo->idCategoria }}">
            <input type="checkbox" name="equipos[]" value="{{ $equipo->id }}" id="equipo-{{ $equipo->id }}"
                class="mr-2 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                {{ in_array($equipo->id, old('equipos', [])) ? 'checked' : '' }}>
            <label for="equipo-{{ $equipo->id }}" class="text-white text-sm">{{ $equipo->nombre }}</label>
        </div>
    @endforeach
</div>

<script>
    // Función que filtra y muestra solo los equipos de la categoría seleccionada
    function filtrarEquiposPorCategoria(categoriaId) {
        // Mostrar u ocultar los equipos según la categoría seleccionada
        const equipos = document.querySelectorAll('.equipo');
        equipos.forEach(function(equipo) {
            const equipoCategoriaId = equipo.getAttribute('data-categoria-id');
            if (categoriaId && equipoCategoriaId !== categoriaId) {
                equipo.style.display = 'none';  // Ocultar equipos que no coinciden con la categoría seleccionada
            } else {
                equipo.style.display = 'flex';  // Mostrar equipos que coinciden con la categoría seleccionada
            }
        });
    }

    // Evento para cuando se cambia la categoría
    document.getElementById('idCategoria').addEventListener('change', function() {
        const categoriaId = this.value;
        filtrarEquiposPorCategoria(categoriaId);

        // Mostrar los equipos solo si se selecciona una categoría
        if (categoriaId) {
            document.getElementById('equipos-container').style.display = 'block';
        } else {
            document.getElementById('equipos-container').style.display = 'none';
        }
    });

    // Inicialización al cargar la página, si ya se seleccionó una categoría
    document.addEventListener('DOMContentLoaded', function() {
        const selectedCategoriaId = document.getElementById('idCategoria').value;
        filtrarEquiposPorCategoria(selectedCategoriaId);
    });
</script>
