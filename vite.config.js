import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from 'tailwindcss';
import Icons from 'unplugin-icons/vite';
import IconsResolver from 'unplugin-icons/resolver';
import Components from 'unplugin-vue-components/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                }
            }
        }),
        Icons(),
        Components({
            resolvers: [
                IconsResolver(),
            ],
        }),
    ],
    css: {
        postcss: {
            plugins: [tailwindcss]
        }
    },
    server: {
        hmr: {
            host: 'localhost'
        }
    },
    test: {
        globals: true,
    },
    resolve: {
        alias: {
            '@/': '/resources/js'
        }
    }
});
