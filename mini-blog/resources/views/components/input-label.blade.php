@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-base text-rose-500']) }}>
    {{ $value ?? $slot }}
</label>
