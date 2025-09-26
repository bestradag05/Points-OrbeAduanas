import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/chartjs/points-chart.js',
            ],
            refresh: true,
        }),
    ],
    /* server: {
        cors: {
            origin: /^https?:\/\/(?:localhost|127\.0\.0\.1|sisorbe\.orbeaduanas\.com)(?::\d+)?$/, // Permitir localhost y producción
        },
    }, */
});
