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

mix.js([
    'resources/js/app.js',
    'resources/js/custom.js'
	], 'public/js/app.js')
  .js([
    'resources/js/sb-admin-2.min.js',
    'resources/vendor/datatables/dataTables.bootstrap4.min.js',
    'resources/vendor/datatables/jquery.dataTables.min.js',
    //'resources/vendor/css-filters-polyfill/contentloaded.js',
    //'resources/vendor/css-filters-polyfill/cssParser.js',
    //'resources/vendor/css-filters-polyfill/css-filters-polyfill.js',
  ], 'public/js/vendor.js')
  .copyDirectory('resources/vendor/css-filters-polyfill/htc', 'public/js/css-filters-polyfill/htc')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/app_dark.scss', 'public/css');

if( mix.inProduction() )
  mix.version();
