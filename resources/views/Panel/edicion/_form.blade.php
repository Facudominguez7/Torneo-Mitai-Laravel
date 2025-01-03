@csrf
<div class="mb-5">
    <label for="nombre" class="mb-3 block text-base font-medium text-white">Nombre de la Edición</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $edicion->nombre) }}"
        class="w-full rounded-md border border-gray-300 bg-white py-2 px-4 text-base font-medium text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" />
</div>

@if (isset($equipos) && isset($categorias))
    <div class="mb-5">
        <label for="idEdicion" class="mb-3 block text-base font-medium text-white">Seleccione una edición</label>
        <select name="idEdicion" id="idEdicion"
            class="w-full rounded-md border border-gray-300 bg-white py-2 px-4 text-base font-medium text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            <option value="">Seleccione una edición</option>
            @foreach ($ediciones as $edicion)
                <option value="{{ $edicion->id }}"
                    {{ old('idEdicion', $idEdicion) == $edicion->id ? 'selected' : '' }}>
                    {{ $edicion->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-5" id="categorias-container" style="{{ $categorias->isEmpty() ? 'display:none;' : '' }}">
        <label for="idCategoria" class="mb-3 block text-base font-medium text-white">Seleccione una categoría</label>
        <select name="idCategoria" id="idCategoria"
            class="w-full rounded-md border border-gray-300 bg-white py-2 px-4 text-base font-medium text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            <option value="">Seleccione una categoría</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                    {{ old('idCategoria', $idCategoria) == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombreCategoria }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-5" id="equipos-container" style="{{ $equipos->isEmpty() ? 'display:none;' : '' }}">
        @foreach ($equipos as $equipo)
            <div class="flex items-center mb-2 p-4 bg-gray-800 rounded-lg shadow-md equipo"
                data-categoria-id="{{ $equipo->idCategoria }}">
                <input type="checkbox" name="equipos[]" value="{{ $equipo->id }}" id="equipo-{{ $equipo->id }}"
                    class="mr-2 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    {{ in_array($equipo->id, old('equipos', [])) ? 'checked' : '' }}>
                <label for="equipo-{{ $equipo->id }}" class="text-white text-sm">{{ $equipo->nombre }}</label>
            </div>
        @endforeach
    </div>
    <script>
        document.getElementById('idEdicion').addEventListener('change', function() {
            const edicionId = this.value;

            if (edicionId) {
                fetch(`/Panel/categorias-por-edicion/${edicionId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al cargar las categorías');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const categoriaSelect = document.getElementById('idCategoria');
                        categoriaSelect.innerHTML = '<option value="">Seleccione una categoría</option>';

                        if (data.categorias && data.categorias.length > 0) {
                            data.categorias.forEach(categoria => {
                                const option = document.createElement('option');
                                option.value = categoria.id;
                                option.textContent = categoria.nombreCategoria;
                                categoriaSelect.appendChild(option);
                            });

                            document.getElementById('categorias-container').style.display = 'block';
                        } else {
                            alert('No se encontraron categorías para esta edición');
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar las categorías:', error);
                        alert('Error al cargar las categorías');
                    });
            } else {
                document.getElementById('categorias-container').style.display = 'none';
                document.getElementById('equipos-container').style.display = 'none';
            }
        });

        document.getElementById('idCategoria').addEventListener('change', function() {
            const categoriaId = this.value;

            if (categoriaId) {
                fetch(`/Panel/equipos-por-categoria/${categoriaId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al cargar los equipos');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const equiposContainer = document.getElementById('equipos-container');
                        equiposContainer.innerHTML = ''; // Limpiar equipos

                        if (data.equipos && data.equipos.length > 0) {
                            data.equipos.forEach(equipo => {
                                const div = document.createElement('div');
                                div.classList.add('flex', 'items-center', 'mb-2', 'p-4', 'bg-gray-800',
                                    'rounded-lg', 'shadow-md');
                                div.innerHTML = `
                                <input type="checkbox" name="equipos[]" value="${equipo.id}" id="equipo-${equipo.id}" 
                                    class="mr-2 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="equipo-${equipo.id}" class="text-white text-sm">${equipo.nombre}</label>
                            `;
                                equiposContainer.appendChild(div);
                            });

                            // Restaurar equipos seleccionados
                            restoreSelectedEquipos();

                            // Mostrar los equipos
                            equiposContainer.style.display = 'block';
                        } else {
                            alert('No se encontraron equipos para esta categoría');
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar los equipos:', error);
                        alert('Error al cargar los equipos');
                    });
            } else {
                document.getElementById('equipos-container').style.display = 'none';
            }
        });

        // Guardar equipos seleccionados en localStorage
        document.addEventListener('change', function(event) {
            if (event.target.name === 'equipos[]') {
                const selectedEquipos = JSON.parse(localStorage.getItem('selectedEquipos')) || [];
                if (event.target.checked) {
                    if (!selectedEquipos.includes(event.target.value)) {
                        selectedEquipos.push(event.target.value);
                    }
                } else {
                    const index = selectedEquipos.indexOf(event.target.value);
                    if (index > -1) {
                        selectedEquipos.splice(index, 1);
                    }
                }
                localStorage.setItem('selectedEquipos', JSON.stringify(selectedEquipos));
            }
        });

        // Restaurar equipos seleccionados desde localStorage
        function restoreSelectedEquipos() {
            const selectedEquipos = JSON.parse(localStorage.getItem('selectedEquipos')) || [];
            selectedEquipos.forEach(id => {
                const checkbox = document.getElementById(`equipo-${id}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }

        // Restaurar equipos seleccionados al cargar la página
        document.addEventListener('DOMContentLoaded', restoreSelectedEquipos);

        // Enviar todos los equipos seleccionados al servidor
        document.querySelector('form').addEventListener('submit', function() {
            const selectedEquipos = JSON.parse(localStorage.getItem('selectedEquipos')) || [];
            selectedEquipos.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'equipos[]';
                input.value = id;
                this.appendChild(input);
            });
        });
    </script>

@endif
