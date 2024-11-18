/** @type {import('tailwindcss').Config} */

/**
 * Tailwind CSS Configuration File
 *
 * @see
 */
module.exports = {
	important: '.settings_page_apollo',
	content: [
		'./src/**/*.{svg,css,png,jpg,js}',
		'./src/**/*.php',
		'./src/**/**/*.php',
		'./templates/**/*.php',
	],
	theme: {
		plugins: [],
	},
	corePlugins: {
		preflight: false,
	},
}
