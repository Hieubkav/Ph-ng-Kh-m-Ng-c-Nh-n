/** @type {import('tailwindcss').Config} */
import preset from './vendor/filament/support/tailwind.config.preset'
export default {
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        'node_modules/preline/dist/*.js',
        "./node_modules/flowbite/**/*.js",
        '<path-to-vendor>/solution-forest/filament-tree/resources/**/*.blade.php',
    ],
    theme: {
        extend: {
            gridTemplateColumns: {
                'desktop': 'repeat(3, minmax(0, 1fr))',
                'tablet': 'repeat(2, minmax(0, 1fr))',
            },
            colors: {
                'medical-green': {
                    light: '#4ade80',
                    DEFAULT: '#22c55e',
                    dark: '#16a34a'
                }
            }
        },
    },
    plugins: [
        require('preline/plugin'),
        require('flowbite/plugin')
    ],
    darkMode: 'class',
}

