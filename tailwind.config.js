/** @type {import('tailwindcss').Config} */
/* eslint-env node */
const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

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
        colors: {
            pink: {
                50: '#B3A0A0',
                100:'#AF8E8D',
                200:'#A88180',
                300:'#A07575',
                400:'#956666',
                500:'#8C5959',
                600:'#824D4D',
                700:'#7C4444',
                800:'#733C3C',
                900:'#6D3636',
                950:'#622C2C',
            },
            red: colors.red,
            green: colors.emerald,
            gray: colors.gray,
            slate: colors.slate,
            stone: colors.stone,
            black: colors.black,
            white: colors.white,
            blue: colors.sky,
            transparent: colors.transparent,
        }
    },
    plugins: [],
}

