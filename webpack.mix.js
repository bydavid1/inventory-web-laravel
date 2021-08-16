const mix = require('laravel-mix');
const glob = require('glob')
const path = require('path')
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

function mixAssetsDir(path, callback) {
    (glob.sync('resources/' + path) || []).forEach(file => {
        file = file.replace(/[\\\/]+/g, '/');
        callback(file, file.replace('resources', 'public'));
    });
}

// Scrips
mixAssetsDir('js/scripts/**/*.js', (src, dest) => {
    mix.scripts(src, dest)
});


// Menus
mixAssetsDir('js/core/menu/!(_)*.js', (src, dest) => {
    mix.scripts(src, dest);
});

// Plugins sass
mixAssetsDir('sass/plugins/!(_)*.scss', (src, dest) => {
    mix.sass(src, dest.replace(/(\\|\/)sass(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'));
});

// Theme Core stylesheets
mixAssetsDir('sass/core/**/!(_)*.scss', (src, dest) => {
    mix.sass(src, dest.replace(/(\\|\/)sass(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'))
});

//Copy assets
mix.copyDirectory('resources/assets', 'public/assets');
// Copy vendors
mix.copyDirectory('resources/vendors', 'public/vendors');

let jssrc = 'resources/js/core/';

mix.sass('resources/sass/app.scss', 'public/css')
  .combine([jssrc + 'app-menu.js',
    jssrc + 'app.js',
    jssrc + 'components.js',
    jssrc + 'footer.js',
    jssrc + 'customizer.js'],
    'public/js/core/app.js')

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
