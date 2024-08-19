import daisyui from "daisyui";

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            maxHeight: {
                128: "32rem",
                144: "36rem",
            },
            zIndex: {
                9999: "9999",
            },
        },
    },
    plugins: [daisyui],
    daisyui: {
        // include only dark and light theme
        themes: false,
        // name of the theme for dark mode
        darkTheme: "dark",
    },
};
