import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    1: '#eefcf9',
                    2: '#c5f7ed',
                    3: '#9df1e0',
                    4: '#75ebd3',
                    5: '#4de5c6',
                    6: '#2be0bb',
                },
                'black-custom': '#0D0D0D',
            }
        },
    },

    plugins: [forms],
};
/* Paleta original.. */
/* primary: {
    1: '#36BFB1',
    2: '#038C73',
    3: '#02735E',
    4: '#014034',
}, */

/* Paleta nueva... */
/*
#b394ef
#a884ed
#9d75eb
#976ce9
#8c5ce7
#814de5
  */
