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
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/project.js', 'public/js');

mix.js('resources/js/prompt.js', 'public/js');

mix.js('resources/js/setting.js', 'public/js');

mix.js('resources/js/description.js', 'public/js');

mix.js('resources/js/chat.js', 'public/js');

mix.js('resources/js/profile.js', 'public/js');
