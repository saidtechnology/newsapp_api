// webpack.mix.js
const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js')
    .vue({
        version: 3,
        options: {
            compilerOptions: {
                isCustomElement: tag => tag.startsWith('vue-')
            }
        }
    })
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js'),
                'vue': 'vue/dist/vue.esm-bundler.js'
            }
        }
    });