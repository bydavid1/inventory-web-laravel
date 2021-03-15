const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('dotenv').config();



mix.js('resources/js/app.js', 'public/js').vue()
    .sass('resources/scss/app.scss', 'public/css/app.css')
    .options({
      processCssUrls: false,
      postCss: [tailwindcss('./tailwind.config.js')],
    });

mix.copyDirectory('resources/assets', 'public/assets');


// mix.then(() => {
//   if (process.env.MIX_CONTENT_DIRECTION === "rtl") {
//     let command = `node ${path.resolve('node_modules/rtlcss/bin/rtlcss.js')} -d -e ".css" ./public/css/ ./public/css/`;
//     exec(command, function (err, stdout, stderr) {
//       if (err !== null) {
//         console.log(err);
//       }
//     });
//     // exec('./node_modules/rtlcss/bin/rtlcss.js -d -e ".css" ./public/css/ ./public/css/');
//   }
// });
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
