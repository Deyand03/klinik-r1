import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/utility/navbar_beranda.js', 'resources/js/utility/calendar_jadwal_admin.js'],
            refresh: true,
        }),
    ],
});
