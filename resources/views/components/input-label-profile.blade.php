@props(['value'])

<label {{ $attributes->merge(['class' => 'mb-2 mt-2 text-black text-xl']) }}>
    {{ $value ?? $slot }}
</label>
