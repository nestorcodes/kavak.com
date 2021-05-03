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
    'datatables': vendor + 'datatables.net-bs4/',
    'fontawesome': vendor + '@fortawesome/fontawesome-free/',
    'overlay': vendor + 'gasparesganga-jquery-loading-overlay/dist/',
    'paginationjs': vendor + 'paginationjs/dist/',
    'toastr': vendor + 'toastr/build/',
};

mix.copy(lib.datatables + 'css', assets + 'datatables/css');
mix.copy(lib.datatables + 'js', assets + 'datatables/js');

mix.copy(lib.fontawesome + 'css/', assets + 'fontawesome/css/');
mix.copy(lib.fontawesome + 'js/', assets + 'fontawesome/js/');
mix.copy(lib.fontawesome + 'webfonts/', assets + 'fontawesome/webfonts/');

mix.copy(lib.overlay, assets + 'overlay/js/');

mix.copy(lib.paginationjs + 'pagination.css', assets + 'paginationjs/css/');
mix.copy(lib.paginationjs + 'pagination.min.js', assets + 'paginationjs/js/');

mix.copy(lib.toastr + 'toastr.min.js', assets + 'toastr/js/');
mix.copy(lib.toastr + 'toastr.js.map', assets + 'toastr/js/');
mix.copy(lib.toastr + 'toastr.min.css', assets + 'toastr/css/');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
