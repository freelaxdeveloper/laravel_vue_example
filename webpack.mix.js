let mix = require('laravel-mix');

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
// mix.config.webpackConfig.output = {
//   chunkFilename: 'js/[name].bundle.js',
//   publicPath: '/',
// };
mix.webpackConfig({
  output: {
      publicPath: '/',
      chunkFilename: 'js/[name].[chunkhash].js',
  },
});

mix
  .js('resources/assets/js/App/app.js', 'public/js').version()
  .js('resources/assets/js/Push/app.js', 'public/js/push.js').version()
  .js('resources/assets/js/Widget/main.js', 'public/js/widget.js').version()
  .js('resources/assets/js/YouTube/main.js', 'public/js/youtube.js').version()
  .sass('resources/assets/sass/app.scss', 'public/css').version();

mix.copyDirectory('resources/assets/img', 'public/img');