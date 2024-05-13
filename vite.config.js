import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from "@rollup/plugin-inject";

export default defineConfig({
    plugins: [
        inject({
            $: "jquery",
        }),

        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
    ],

    resolve: {
        alias: {
            "~": "node_modules/",
        },
    },
});
