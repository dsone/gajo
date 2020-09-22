const mix = require('laravel-mix');
require('mix-tailwindcss');

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

mix.js('./resources/js/app.js', './public/js/app.js')
	.version();

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
	.version();
