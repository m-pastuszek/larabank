@props(['value'])

<label {{ $attributes->merge(['class' => 'block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2']) }}>
    {{ $value ?? $slot }}
</label>
