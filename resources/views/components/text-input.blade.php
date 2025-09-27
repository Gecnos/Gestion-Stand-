@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => '
    border-gray-300
    rounded-lg
    shadow-sm
    focus:border-gray-500  {{-- Bordure neutre au focus --}}
    focus:ring-gray-500   {{-- Anneau neutre au focus --}}
    
    {{-- Conserver les classes de base si vous utilisez le mode sombre, sinon vous pouvez les retirer --}}
    dark:border-gray-700 dark:bg-white dark:text-gray-800
    w-full
',
]) !!}>
