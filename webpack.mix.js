const { mix } = require('laravel-mix');

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
 
if (mix.inProduction()) {
	mix.version();
} else {
	mix.browserSync('slidemonster.local');
}

mix.js('resources/assets/js/app.js', 'public/js/app.js')
   .js('resources/assets/js/embed.js', 'public/js/embed.js')
   .sass('resources/assets/sass/app.scss', 'public/css/app.css')
   .combine(['resources/assets/css/front.css'], 'public/css/front.css');
