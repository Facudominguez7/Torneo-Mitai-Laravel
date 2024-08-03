@props(['value'])

<label {{ $attributes->merge(['class' => 'mb-2 mt-2 text-white text-xl']) }}>
    {{ $value ?? $slot }}
</label>
