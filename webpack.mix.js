const mix = require('laravel-mix');

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

const assets = 'public/vendor/';
const vendor = 'node_modules/';
const lib = {
    'paginationjs': vendor + 'paginationjs/dist/',
};

mix.copy(lib.paginationjs + 'pagination.css', assets + 'paginationjs/css/');
mix.copy(lib.paginationjs + 'pagination.min.js', assets + 'paginationjs/js/');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
