/**
 * Laravel Mix
 * https://laravel-mix.com/docs/6.0/installation
 *
 * Laravel Mix provides a clean, fluent API for defining basic webpack build steps for your Laravel application.
 * By default, we are compiling the Sass file for the application as well as bundling up all the JS files.
 *
 * @see https://laravel-mix.com/docs/6.0/installation
 * @see https://laravel-mix.com/docs/6.0/what-is-mix
 * @see https://laravel-mix.com/docs/6.0/basic-example
 */

/**
 * Import modules.
 */
const mix = require('laravel-mix');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const { glb } = require('laravel-mix-glob');
const postcss = require('postcss');

/**
 * Set the public path for the assets.
 *
 * @see https://laravel-mix.com/docs/6.0/basic-example#output-directory
 */
mix
	.setPublicPath('./assets');

/**
 * Mix Sass.
 *
 * Mix provides a clean, fluent API for defining basic webpack build steps for your application.
 * @see https://laravel-mix.com/docs/6.0/sass
 * @see https://www.npmjs.com/package/laravel-mix-glob
 */
mix
	.sass(
		glb.src('src/**/Static/styles/**/*.s.scss'),
		glb.out({
			baseMap: '',
			outMap: './css',
			specifier: 's',
		})
	)
	.options({
		postCss: [
			require('css-declaration-sorter')({
				order: 'smacss'
			})
		],
		autoprefixer: {
			options: {
				browsers: [
					'last 6 versions',
				]
			}
		},
	});

/**
 * Mix Javascript.
 *
 * Mix provides a clean, fluent API for defining basic webpack build steps for your application.
 * @see https://laravel-mix.com/docs/6.0/concatenation-and-minification
 * @see https://www.npmjs.com/package/laravel-mix-glob
 */
mix
	.js(
		glb.src('src/**/Static/js/**/*.s.js'),
		glb.out({
			baseMap: '',
			outMap: './js',
			specifier: 's',
		}),
	);

/**
 * Mix Options.
 *
 * Mix provides a variety of options to customize the Webpack configuration.
 * @see https://laravel-mix.com/docs/6.0/options.
 */
mix
	.options({
		processCssUrls: false,
		postCss: [

			require('postcss-nested-ancestors'),
			require('postcss-nested'),
			require('postcss-import'),
			require('autoprefixer'),

		]
	});

mix
	.webpackConfig({
		plugins: [
			new CopyWebpackPlugin({
				patterns: [
					{ from: "src/Admin/Static/images", to: "admin/images", noErrorOnMissing: true },
					{ from: "src/Admin/Static/icons", to: "admin/icons", noErrorOnMissing: true },
					{ from: "src/Admin/Static/fonts", to: "admin/fonts", noErrorOnMissing: true },

					{ from: "src/Frontend/Static/images", to: "public/images", noErrorOnMissing: true },
					{ from: "src/Frontend/Static/icons", to: "public/icons", noErrorOnMissing: true },
					{ from: "src/Frontend/Static/fonts", to: "public/fonts", noErrorOnMissing: true },
				],
			}),
		],
	});

/**
 * Mix BrowserSync
 *
 * BrowserSync makes your tweaking and testing faster by synchronizing file changes and interactions across multiple devices.
 * @see https://laravel-mix.com/docs/6.0/browsersync.
 */
mix
	.browserSync({
		proxy: 'http://matterwp.local',
		open: 'external',
		port: 3000,
		files: ['*.php', 'src/**/**/*', 'templates/**/**/*'],
		reloadDelay: 1000
	});

/**
 * Mix Notifications.
 *
 * @see https://laravel-mix.com/docs/6.0/notifications
 */
mix
	.disableNotifications();
