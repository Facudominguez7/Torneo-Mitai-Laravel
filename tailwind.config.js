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
        },
        extend: {},
    },
    plugins: [require("flowbite/plugin")],
};
