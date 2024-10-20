import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vuetify from "vite-plugin-vuetify";
import { fileURLToPath, URL } from "url";

export default defineConfig({
    plugins: [
        laravel({
            publicDirectory: 'public',
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template:{
                transformAssetUrls: {
                    base:null,
                    includeAbsolute: false,
                },
            },
        }),
        vuetify({autoImport:true}),
    ],
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("./resources/js", import.meta.url)),
        },
    },
});
