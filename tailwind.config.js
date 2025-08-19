import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'primary-light': '#FFD700',
                'primary': '#FFC117',
                'primary-dark': '#FFA000',
                'secondary': '#6D4C41',
                'background': '#FFF8E1',
                'surface': '#FFFFFF',
                'text-dark': '#3E2723',
                'text-light': '#795548',

                'dark-primary-light': '#FFECB3',
                'dark-primary': '#FFC107',
                'dark-primary-dark': '#FFA000',
                'dark-secondary': '#8D6E63',
                'dark-background': '#121212',
                'dark-surface': '#1E1E1E',
                'dark-text-dark': '#E0E0E0',
                'dark-text-light': '#BDBDBD',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
