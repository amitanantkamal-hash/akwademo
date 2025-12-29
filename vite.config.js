import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vSelect from "vue3-select";
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'modules/BotFlow/Resources/assets/js/app.js',

                'modules/BotFlow/Resources/assets/css/app.css',
                'modules/BotFlow/Resources/assets/css/tenant-app.css',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
                'modules/LeadManager/Resources/views/**',
                'modules/BotFlow/Resources/views/**',
            ],
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
            '@': '/resources/js',
            'vue': 'vue/dist/vue.esm-bundler.js',
            '@botflow': path.resolve(__dirname, 'modules/BotFlow/Resources/assets/js'),

        },
    },
    server: {
        watch: {
            usePolling: true,
            interval: 300,
        },
    },
});