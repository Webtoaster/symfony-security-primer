let Encore = require('@symfony/webpack-encore');

//  Manual implementation of the environment since Webpack and PHPStorm have a couple of shortcomings.
if (!Encore.isRuntimeEnvironmentConfigured()) {
	Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
//  Set Paths
	.setOutputPath('public/build/')
	.setPublicPath('/build')
	
	// Use CDNs
	//.setManifestKeyPrefix('build/')
	
	/**
	 * ENTRY CONFIG
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
	
	
	
	
	
	
	
	// .addEntry('app_dashboard', './assets/js/app_dashboard.js')
	// .addEntry('', './assets/js/.js')
	
	// Split into Smaller Files.
	.splitEntryChunks()
	
	// will require an extra script tag for runtime.js
	// but, you probably want this, unless you're building a single-page app
	.enableSingleRuntimeChunk()
	//.disableSingleRuntimeChunk()
	
	/*
	 * FEATURE CONFIG
	 *
	 * Enable & configure other features below. For a full
	 * list of features, see:
	 * https://symfony.com/doc/current/frontend.html#adding-more-features
	 */
	.cleanupOutputBeforeBuild()
	.enableBuildNotifications()
	.enableSourceMaps(!Encore.isProduction())
	
	// Enables hashed filenames (e.g. app.abc123.css)
	.enableVersioning(Encore.isProduction())
	
	// Enables @babel/preset-env polyfills
	.configureBabel(() => {
	}, {
		useBuiltIns: 'usage',
		corejs: 3
	})
	
	// Enable Sass
	.enableSassLoader()
	.enablePostCssLoader()
	
	.copyFiles({
		from: './assets/images',
		to: 'images/[path][name].[hash:8].[ext]'
	})
	
	// uncomment if you use TypeScript
	//.enableTypeScriptLoader()
	
	// uncomment to get integrity="..." attributes on your script & link tags
	// requires WebpackEncoreBundle 1.4 or higher
	//.enableIntegrityHashes()
	
	// uncomment if you're having problems with a jQuery plugin
	.autoProvidejQuery()

//  uncomment if you use API Platform Admin (composer req api-admin)
//  .enableReactPreset()
//  .addEntry('admin', './assets/js/admin.js')

;

module.exports = Encore.getWebpackConfig();
