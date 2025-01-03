@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div
    x-data="{
        show: @js($show),
        showForm: false,  // Controla la visibilidad del formulario
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    <!-- Fondo oscuro cuando el modal está abierto -->
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Contenido del modal -->
    <div
        x-show="show"
        class="relative mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >

        <!-- Botón para cerrar el modal (en la esquina superior derecha) -->
        <button 
            x-on:click="show = false"
            class="absolute top-0 right-0 mt-2 mr-1 text-gray-600 hover:text-gray-600"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Imagen del torneo -->
        <div class="p-6 text-center">
            <img src="{{ asset('fotos/promo-torneo.png') }}" alt="Promoción del Torneo" class="w-full h-auto rounded-lg mb-4">
            <h2 class="text-xl font-bold mb-4">¡No te Quedes Afuera!</h2>
            <button
                class="bg-blue-500 text-white px-4 py-2 rounded hidden"
                x-on:click="showForm = true"
            >
                Quiero recibir más información
            </button>
        </div>

        <!-- Formulario para más información -->
        <div x-show="showForm" class="p-6">
            <form method="POST" action="/ruta-para-enviar-datos">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nombre:</label>
                    <input type="text" id="name" name="name" class="w-full border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="surname" class="block text-gray-700">Apellido:</label>
                    <input type="text" id="surname" name="surname" class="w-full border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700">Número de Teléfono:</label>
                    <input type="text" id="phone" name="phone" class="w-full border-gray-300 rounded-lg">
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                    Enviar Información
                </button>
            </form>
        </div>
    </div>
</div>
