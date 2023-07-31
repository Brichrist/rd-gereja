const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


mix
  .js('resources/js/bootstrap.js', 'public/js/bootstrap.js')
  .sass('resources/sass/bootstrap.scss', 'public/css/bootstrap.css')
  .css('resources/css/app.css', 'public/css/app.css')
  .copyDirectory('resources/fonts', 'public/fonts');
