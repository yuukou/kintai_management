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

mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/attendance.js', 'public/js')
  .js('resources/js/clock.js', 'public/js')
  .js('resources/js/mypage.js', 'public/js')
  .js('resources/js/common/geolocation.js', 'public/js')
  .js('resources/js/common/distance.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/attendance.scss', 'public/css')
  .sass('resources/sass/mypage.scss', 'public/css')
  .sass('resources/sass/register_complete.scss', 'public/css').
version();