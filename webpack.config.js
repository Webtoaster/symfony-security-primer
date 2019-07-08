let Encore = require('@symfony/webpack-encore');

// Manual implementation of the environment since Webpack and PHPStorm have a couple of shortcomings.
if (!Encore.isRuntimeEnvironmentConfigured()) {
	Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore


/**
 * Set Paths
 * .setOutputPath('public/build/')
 * .setPublicPath('/build')
 */
	.setOutputPath('public/build/')
	.setPublicPath('/build')
	
	
	/**
	 * If you are using a CDN, then configure here.
	 * .setManifestKeyPrefix('build/')
	 */
	
	/**
	 * ENTRIES
	 *
	 * Add 1 entry for each "page" of your app
	 * (including one that's included on every page - e.g. "app")
	 *
	 * Each entry will result in one JavaScript file (e.g. app.js)
	 * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
	 */
	.addEntry('app', './assets/js/app.js')
	.addEntry('app_register', './assets/js/app_register.js')
	.addEntry('app_security', './assets/js/app_security.js')
	
	.addStyleEntry('app', './assets/css/app.scss')
	.addStyleEntry('app_register', './assets/css/app_register.scss')
	.addStyleEntry('app_security', './assets/css/app_security.scss')
	
	/**
	 * Future Entries
	 * .addEntry('app_dashboard', './assets/js/app_dashboard.js')
	 * .addEntry('', './assets/js/.js')
	 *
	 */
	
	
	/**
	 * Split into Smaller Files.
	 */
	.splitEntryChunks()
	
	// will require an extra script tag for runtime.js
	// but, you probably want this, unless you're building a single-page app
	
	/**
	 * Runtime Chunks.
	 * .disableSingleRuntimeChunk()
	 * .enableSingleRuntimeChunk()
	 */
	.enableSingleRuntimeChunk()
	
	
	/*
	 * FEATURE CONFIG
	 *
	 * Enable & configure other features below. For a full
	 * list of features, see:
	 * https://symfony.com/doc/current/frontend.html#adding-more-features
	 *
	 * .cleanupOutputBeforeBuild()
	 * .enableBuildNotifications()
	 * .enableSourceMaps(!Encore.isProduction())
	 */
	.cleanupOutputBeforeBuild()
	.enableBuildNotifications()
	.enableSourceMaps(!Encore.isProduction())
	
	/**
	 * Hashed File Names
	 * .enableVersioning(Encore.isProduction())
	 *
	 */
	.enableVersioning(Encore.isProduction())
	
	/**
	 * Babel Configurations
	 * Enables @babel/preset-env polyfills
	 *
	 */
	.configureBabel(() => {
	}, {
		useBuiltIns: 'usage',
		corejs: 3
	})
	
	/**
	 * Enables SASS File Support
	 * .enableSassLoader()
	 * .enablePostCssLoader()
	 */
	.enableSassLoader()
	.enablePostCssLoader()
	
	
	
	/**
	 * Paths for Copied Files out of the Assets directory to public/build.
	 */
	.copyFiles({
		from: './assets/images',
		to: 'images/[path][name].[hash:8].[ext]'
	})
	
	
	/**
	 * If using type scripts
	 * .enableTypeScriptLoader()
	 */
	
	
	// uncomment to get integrity="..." attributes on your script & link tags
	// requires WebpackEncoreBundle 1.4 or higher
	
	
	/**
	 * To use integrity hashes
	 * .enableIntegrityHashes()
	 */
	
	/**
	 * To fix problems with JQUery Plugins
	 * .autoProvidejQuery()
	 */
	.autoProvidejQuery()

	/**
	 * For using the API platform.
	 * .enableReactPreset()
	 */


;

module.exports = Encore.getWebpackConfig();
