module.exports = {
	/**
	 * Specify the PostCSS plugins to use. Some trickery can come when specifying the order that
	 * PostCSS plugins run in. Some plugins are required to run before others will work as intended.
	 */
	plugins: {
		/**
		 * This plugin can consume local files, node modules or web_modules. To resolve path of an @import rule, it
		 * can look into root directory or local modules.
		 * @see https://github.com/postcss/postcss-import
		 */
		'postcss-import': {},
		/**
		 * Adds support for nested declarations, we use the bundled tailwindcss/nesting plugin, which is
		 * a PostCSS plugin that wraps postcss-nested or postcss-nesting and acts as a compatibility layer
		 * to make sure your nesting plugin of choice properly understands Tailwind’s custom syntax like @apply and @screen.
		 * @ee https://tailwindcss.com/docs/using-with-preprocessors#nesting
		 */
		'tailwindcss/nesting': {},
		/**
		 * A utility-first CSS framework that scans all of our files, and only generate styles
		 * and classes that we use. It's fast, flexible, and reliable — with zero-runtime.
		 * @see https://tailwindcss.com/docs/installation
		 */
		tailwindcss: { config: './.dev/tailwind.config.js' },

		/**
		 * Plugin to parse CSS and add vendor prefixes to CSS rules using values from
		 * Can I Use. It is recommended by Google and used in Twitter and Alibaba.
		 * @see https://github.com/postcss/autoprefixer
		 */
		autoprefixer: {},

		/**
		 * Plugin to combine and sort CSS media queries with mobile first or desktop first methods.
		 * @see https://github.com/solversgroup/postcss-sort-media-queries
		 */
		'postcss-sort-media-queries': {},

		/**
		 * Automatically detects and combines duplicated css selectors so you don't have to 😄
		 * Needs to run after 'postcss-sort-media-queries'.
		 * @see https://github.com/ChristianMurphy/postcss-combine-duplicated-selectors
		 */
		'postcss-combine-duplicated-selectors': { removeDuplicatedValues: true },
	},
}
