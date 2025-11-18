import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        // HANYA GUNAKAN PLUGIN LARAVEL
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        // HAPUS tailwindcss() DI SINI UNTUK MENGHINDARI KONFLIK
    ],
    
    // Konfigurasi Tambahan untuk Deployment (Mencegah Vite Manifest Not Found)
    build: {
        manifest: true,
        base: '/', // Memastikan path aset selalu dimulai dari root domain
    }
});