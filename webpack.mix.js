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

mix.options({
      processCssUrls: false,
});

if (mix.inProduction()) {
   mix.js('resources/js/app.js', 'public/assets')
      .sass('resources/sass/app.scss', 'public/assets')
      .version();
} else {
   mix.js('resources/js/app.js', 'public/assets/dev')
      .sass('resources/sass/app.scss', 'public/assets/dev')
      .browserSync('localhost:8080');
}