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
            fontFamily: {
                cairo: ['Cairo'],

            },
            colors: {

                'custom-gray': '#DDDEE5',
                'custom2-gray': '#C3C3C3',
                'custom3-gray': '#7C8594',
            },

        },
    },

    plugins: [forms],
};
