import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/welcome.js',
                'resources/js/admin/admin.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public_html/build', // Ruta de salida para los archivos generados
        manifest: true,              // Asegúrate de que el manifest se genere
    },
});