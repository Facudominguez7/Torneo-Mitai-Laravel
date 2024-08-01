/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        colors: {
            primary: "rgb(var(--color-primary)",
            secondary: "rgb(var(--color-secondary)",
            oro: {
                DEFAULT: '#FFD700',
                '50': '#FFF9E6',
                '100': '#FFF2CC',
                '200': '#FFE699',
                '300': '#FFD966',
                '400': '#FFCC33',
                '500': '#FFBF00',
                '600': '#CC9900',
                '700': '#997300',
                '800': '#664D00',
                '900': '#332600',
              },
        },
        extend: {},
    },
    plugins: [require("flowbite/plugin")],
};
