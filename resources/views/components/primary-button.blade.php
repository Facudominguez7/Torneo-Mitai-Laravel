<button {{ $attributes->merge(['type' => 'submit', 'class' => 'rounded-3xl bg-yellow-200 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-700']) }}>
    {{ $slot }}
</button>
