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

mix.copyDirectory('node_modules/jquery/dist', 'public/vendor/jquery')
    .copyDirectory('node_modules/bootstrap/dist', 'public/vendor/bootstrap')
    .copyDirectory('node_modules/owl.carousel/dist', 'public/vendor/owl.carousel')
    .copyDirectory('node_modules/font-awesome', 'public/vendor/font-awesome')
    .copyDirectory('node_modules/bootstrap-notify', 'public/vendor/bootstrap-notify')
    .copy('resources/assets/frontend/js/main.js', 'public/js/main.js')
    .copy('resources/assets/frontend/css/styles.css', 'public/css/styles.css')
    .copy('resources/assets/frontend/css/simple.css', 'public/css/simple.css')
    .copyDirectory('resources/assets/frontend/images/avatars', 'public/upload/avatars')
    .copyDirectory('resources/assets/frontend/images/user_covers', 'public/upload/user_covers')
    .copyDirectory('resources/assets/frontend/images/story_covers', 'public/upload/story_covers');

mix.copyDirectory('vendor/bower_components', 'public/bower_components');
mix.js('resources/assets/custom.js', 'public/js');
mix.copyDirectory('resources/assets/custom.css', 'public/css');
