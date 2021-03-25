const mix = require('laravel-mix');
require('dotenv').config();

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
/*
 |--------------------------------------------------------------------------
 | Application assets
 |--------------------------------------------------------------------------
 */

mix.copyDirectory('resources/assets', 'public/assets');
mix.copyDirectory('resources/js/libs', 'public/js/libs');
mix.copyDirectory('resources/js/scripts', 'public/js/scripts');


let jssrc = 'resources/js/core/';

mix.sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/core/menu/menu-types/vertical-menu.scss', 'public/css')
  .sass('resources/sass/core/menu/menu-types/horizontal-menu.scss', 'public/css')
  .combine([jssrc + 'app-menu.js', jssrc + 'app.js', jssrc + 'components.js', jssrc + 'footer.js', jssrc + 'customizer.js'], 'public/js/app.js')
  .copy('resources/js/core/menu/horizontal-menu.js', 'public/js')
  .copy('resources/js/core/menu/vertical-menu-light.js', 'public/js')

// if (mix.inProduction()) {
//   mix.version();
//   mix.webpackConfig({
//     output: {
//       publicPath: '/demo/frest-bootstrap-laravel-admin-dashboard-template/demo-1'
//     }
//   });
//   mix.setResourceRoot("/demo/frest-bootstrap-laravel-admin-dashboard-template/demo-1");
// }
mix.version();
