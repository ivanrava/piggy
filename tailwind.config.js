/** @type {import('tailwindcss').Config} */
/* eslint-env node */
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                'sans': ['Inter', ...defaultTheme.fontFamily.sans],
                'serif': ['Josefin Slab', ...defaultTheme.fontFamily.serif],
                'mono': ['Ubuntu Mono', ...defaultTheme.fontFamily.mono]
            }
        },
    },
    plugins: [],
}

