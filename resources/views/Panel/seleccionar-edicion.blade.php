@extends('Panel.admin')

@section('contenido')
    <div class="mb-5">
        <form action="{{ route($tipo . '.create') }}" method="GET">
            <input type="hidden" name="idEdicion" value="{{ $EdicionSeleccionada->id }}">
            <label for="Edicion" class="block text-base font-medium text-white mb-3">
                Selecciona la Edicion
            </label>
            <select name="edicionfiltro" id="edicionfiltro"
                class="w-full rounded-md border border-gray-200 bg-white py-3 px-6 text-base font-medium text-gray-600 outline-none focus:border-indigo-500 focus:shadow-md mb-3">
                @foreach ($ediciones as $e)
                    <option value="{{ $e->id }}" {{ request('idEdicion') == $e->id ? 'selected' : '' }}>
                        {{ $e->nombre }}
                    </option>
                @endforeach
            </select>
            <label for="idCategoria" class="block text-base font-medium text-white mb-3">
                Selecciona la Categoria
            </label>
            <select name="idCategoria" id="idCategoria"
                class="w-full rounded-md border border-gray-200 bg-white py-3 px-6 text-base font-medium text-gray-600 outline-none focus:border-indigo-500 focus:shadow-md mb-3">
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('idCategoria') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombreCategoria }}
                    </option>
                @endforeach
            </select>
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white py-2 px-4 rounded-full transition-all duration-300 md:py-3 md:px-6 md:rounded-lg">
                    Continuar
                </button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('idEdicion').addEventListener('change', function() {
            var idEdicion = this.value;
            var idEdicion = document.querySelector('input[name="edicionfiltro"]').value;
            var url = "{{ route('seleccionar-edicion') }}";
            window.location.href =
                `${url}?idCategoria=${idCategoria}&idEdicion=${idEdicion}&tipo={{ $tipo }}`;
        });
    </script>
@endsection
