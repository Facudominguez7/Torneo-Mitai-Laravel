@extends('Panel.admin')

@section('contenido')
    <div class="mb-5">
        <form action="{{ route($tipo . '.create') }}" method="GET" id="formSeleccion">
            <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
            <label class="block text-base font-medium text-white mb-1">Edición destino</label>
            <p class="text-sm text-indigo-200 mb-4">{{ $EdicionSeleccionada->nombre }} (ID {{ $EdicionSeleccionada->id }})</p>

            <label for="edicionfiltro" class="block text-base font-medium text-white mb-2">Edición origen</label>
            <select name="edicionfiltro" id="edicionfiltro"
                class="w-full rounded-md border border-gray-200 bg-white py-3 px-6 text-base font-medium text-gray-600 outline-none focus:border-indigo-500 focus:shadow-md mb-4">
                <option value="">-- Seleccionar edición origen --</option>
                @foreach ($ediciones as $e)
                    <option value="{{ $e->id }}" {{ request('edicionfiltro') == $e->id ? 'selected' : '' }}>
                        {{ $e->nombre }}
                    </option>
                @endforeach
            </select>

            <label for="idCategoria" class="block text-base font-medium text-white mb-2">Categoría origen</label>
            <select name="idCategoria" id="idCategoria"
                class="w-full rounded-md border border-gray-200 bg-white py-3 px-6 text-base font-medium text-gray-600 outline-none focus:border-indigo-500 focus:shadow-md mb-4" {{ request('edicionfiltro') ? '' : 'disabled' }}>
                <option value="">-- Seleccionar categoría --</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('idCategoria') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombreCategoria }}
                    </option>
                @endforeach
            </select>
            <div class="flex justify-center mt-4">
                <button type="submit" id="btnContinuar"
                    class="bg-gray-800 hover:bg-gray-900 disabled:opacity-40 disabled:cursor-not-allowed text-white py-2 px-6 rounded-full transition-all duration-300">
                    Continuar
                </button>
            </div>
        </form>
    </div>
    <script>
        const edicionSelect = document.getElementById('edicionfiltro');
        const categoriaSelect = document.getElementById('idCategoria');
        const btn = document.getElementById('btnContinuar');

        function evaluarEstado(){
            btn.disabled = !(edicionSelect.value && categoriaSelect.value);
        }

        edicionSelect.addEventListener('change', function(){
            const edicionId = this.value;
            categoriaSelect.innerHTML = '<option value="">Cargando...</option>';
            categoriaSelect.disabled = true;
            if(!edicionId){
                categoriaSelect.innerHTML = '<option value="">-- Seleccionar categoría --</option>';
                evaluarEstado();
                return;
            }
            fetch(`/Panel/categorias-por-edicion/${edicionId}`)
                .then(r => { if(!r.ok) throw new Error('Error'); return r.json(); })
                .then(data => {
                    categoriaSelect.innerHTML = '<option value="">-- Seleccionar categoría --</option>';
                    if(data.categorias?.length){
                        data.categorias.forEach(cat => {
                            const opt = document.createElement('option');
                            opt.value = cat.id; opt.textContent = cat.nombreCategoria; categoriaSelect.appendChild(opt);
                        });
                        categoriaSelect.disabled = false;
                    } else {
                        categoriaSelect.innerHTML = '<option value="">(Sin categorías)</option>';
                    }
                    evaluarEstado();
                })
                .catch(()=>{
                    categoriaSelect.innerHTML = '<option value="">Error al cargar</option>';
                    evaluarEstado();
                });
        });

        categoriaSelect.addEventListener('change', evaluarEstado);
        evaluarEstado();
    </script>
@endsection
