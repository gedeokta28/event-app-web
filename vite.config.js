import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/datatable.js",
                "resources/scss/datatable.scss",
                "resources/js/toastify.js",
                "resources/scss/toastify.scss",
            ],
            refresh: true,
        }),
    ],
});
