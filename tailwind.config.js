/** @type {import('tailwindcss').Config} */
module.exports = {

    daisyui: {
        themes: [
            {
                mytheme: {
                    "primary": "#22d3ee",
                    "secondary": "#f000b8",
                    "accent": "#1dcdbc",
                    "neutral": "#2b3440",
                    "base-100": "#444346",
                    "info": "#3abff8",
                    "success": "#86efac",
                    "warning": "#fbbd23",
                    "error": "#f87272",
                },
            },
            "dark",
            "cupcake",
            "cyberpunk",
        ],
    },

    content: ["./src/**/*.{html,js,twig}"],
    theme: {
        extend: {},
    },
    plugins: [require("daisyui")],
}