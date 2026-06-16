import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                rose: '#d63384',
                deep: '#2c1b18',
                soft: '#fff5f7',
                muted: '#6c757d',
            },

            fontFamily: {
                playfair: ['Playfair Display', 'serif'],
                poppins: ['Poppins', 'sans-serif'],
                vibes: ['Great Vibes', 'cursive'],
            },

            boxShadow: {
                soft: '0 4px 20px rgba(0,0,0,0.08)',
            },

            borderRadius: {
                xl2: '1.5rem',
            },
        },
    },

    plugins: [],
}
