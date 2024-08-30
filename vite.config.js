import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { glob } from 'glob';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Dynamically get all CSS files
                ...glob.sync('resources/{css,sass,scss}/**/*.{css,sass,scss}'),
                // Dynamically get all JS files
                ...glob.sync('resources/js/**/*.js'),
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
            '@': '/resources/js',
        },
    },
});
