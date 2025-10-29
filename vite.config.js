import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/vendor.js'
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
                'resources/views/**/*.blade.php',
                'app/Http/Controllers/**',
            ],
        }),
    ],
});
