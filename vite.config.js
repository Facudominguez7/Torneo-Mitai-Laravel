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
        outDir: '../public_html/build',  // La carpeta build ahora se encuentra en public_html
        manifest: true,               // Asegúrate de generar el manifest.json
        emptyOutDir: true,            // Limpia la carpeta antes de generar los archivos
  },
});