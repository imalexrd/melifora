@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary text-sm font-medium leading-5 text-text-dark focus:outline-none focus:border-primary-dark transition duration-150 ease-in-out dark:border-dark-primary dark:text-dark-text-dark'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-text-light hover:text-text-dark hover:border-primary-light focus:outline-none focus:text-text-dark focus:border-primary-light transition duration-150 ease-in-out dark:text-dark-text-light dark:hover:text-dark-text-dark dark:hover:border-dark-primary-light dark:focus:text-dark-text-dark dark:focus:border-dark-primary-light';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
