const mix = require('laravel-mix');
const path = require('path');
require("dotenv").config();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/src/plugin/axios.js', 'public/js/src/plugin')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
            '@components': path.resolve(__dirname, 'resources/js/views/components'),
            '@pages': path.resolve(__dirname, 'resources/js/views/pages'),
            '@layouts': path.resolve(__dirname, 'resources/js/views/layouts'),
            '@views': path.resolve(__dirname, 'resources/js/views'),
            '@src': path.resolve(__dirname, 'resources/js/src'),
        },
        extensions: ['.js', '.vue', '.json']
    }
});