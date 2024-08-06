<button {{ $attributes->merge(['type' => 'submit', 'class' => 'rounded-3xl bg-[--color-primary] bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-blue-500']) }}>
    {{ $slot }}
</button>
