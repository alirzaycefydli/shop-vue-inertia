import {defineConfig} from 'vite';
import inertia from '@inertiajs/vite'
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import {bunny} from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import ui from '@nuxt/ui/vite'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        inertia({
            ssr: false,
        }),
        vue(),
        tailwindcss(),
        ui({
            router: 'inertia'
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
