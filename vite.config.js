import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      // Aquí indicamos los archivos de entrada de CSS y JS
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: true, // para que recargue al guardar cambios
    }),
  ],
});
