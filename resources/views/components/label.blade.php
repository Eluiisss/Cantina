@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:main-color-yellow-text transition duration-500']) }}>
    {{ $value ?? $slot }}
</label>
