import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    
    // Perbaikan untuk Deployment Production (Server)
    build: {
        // Vite akan membuat manifest.json di public/build
        manifest: true,
        // Vite harus tahu bahwa semua aset diakses dari root domain
        // Ini mengatasi masalah path absolut di lingkungan server
        base: '/', 
    }
});