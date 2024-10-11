import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/frontoffice/app.css',
                'resources/js/lotteryBackground.js',
            ],
            refresh: true,
        }),
    ],
});
