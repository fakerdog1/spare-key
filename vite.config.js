import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { glob } from 'glob';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...glob.sync('resources/{css,sass,scss}/**/*.{css,sass,scss}'),
                ...glob.sync('resources/js/**/*.js'),
                ...glob.sync('resources/js/**/*.vue'),
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
            '@': path.resolve(__dirname, 'resources/js'),
            'vue': 'vue/dist/vue.esm-bundler.js',
        },
    },
});