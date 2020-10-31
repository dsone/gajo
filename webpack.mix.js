const mix = require('laravel-mix');
require('mix-tailwindcss');
require('laravel-mix-purgecss');

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

mix.js('./resources/js/app.js', './public/js/app.js').version();
mix.js('./resources/js/options.js', './public/js/options.js').version();
mix.js('./resources/js/profile.js', './public/js/profile.js').version();

mix.webpackConfig({
	module: {
		rules: [{
			test: /\.js?$/,
			use: [{
				loader: 'babel-loader',
				options: mix.config.babel()
			}]
		}]
	}
});

mix.sass('./resources/sass/app.scss', './public/css/app.css')
	.tailwind()
	.purgeCss({
		enabled: mix.inProduction(),
		folders: [ 'resources/views' ],
		extensions: [ 'html', 'js', 'php' ],
	})
	.version();
