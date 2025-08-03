import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'primary-light': '#FFD700',
                'primary': '#FFC107',
                'primary-dark': '#FFA000',
                'secondary': '#6D4C41',
                'background': '#FFF8E1',
                'surface': '#FFFFFF',
                'text-dark': '#3E2723',
                'text-light': '#795548',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
