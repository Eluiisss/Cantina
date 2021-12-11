@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm main-color-blue-text dark:main-color-yellow-text transition duration-500']) }}>
    {{ $value ?? $slot }}
</label>
