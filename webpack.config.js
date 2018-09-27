'use strict'

const path = require('path')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const UglifyJSPlugin = require('uglifyjs-webpack-plugin')
const { VueLoaderPlugin } = require('vue-loader')

// Entry points
// (each entry point will result in a bundled JS file)
const entryPoint = {
	frontend: './src/frontend/index.js'
	// add as many you need
}

// Path to public/build folder
let buildPath = path.resolve(__dirname, 'public')

var config = {
	entry: entryPoint,
	output: {
		filename: '[name].js',
		path: buildPath
	},
	devtool: 'source-map',
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules|bower_components)/,
				loader: 'babel-loader',
				query: {
					presets: ['es2015']
				}
			},
			{
				enforce: 'pre',
				test: /\.(js|vue)$/,
				exclude: /node_modules/,
				loader: 'eslint-loader',
				options: {
					formatter: require('eslint-friendly-formatter')
				}
			},
			{
				test: /\.vue$/,
				loader: 'vue-loader',
				options: {
					extractCSS: true
				}
			},
			{
				test: /\.scss$/,
				use: [
					'vue-style-loader',
					'css-loader',
					'sass-loader'
				]
			},
			{
				test: /\.css$/,
				use: [ 'style-loader', 'css-loader' ]
			}
		]
	},
	plugins: [
		new BrowserSyncPlugin({
			// Host and port
			host: 'localhost',
			port: 3000,
			// A target to proxy all BrowserSync requests to.
			// This can be a local web server, Vagrant or a docker container.
			// This is your local/VM WordPress development site.
			proxy: 'localhost'
		}),
		new VueLoaderPlugin()
	],
	optimization: {
		minimizer: [
			// Code minimization (production mode only)
			new UglifyJSPlugin({
				sourceMap: true
			})
		]
	}
}

module.exports = (env, argv) => {
	// Production mode?
	if (argv.mode === 'production') {
		config.devtool = false
		config.output.filename = '[name].min.js'
	}

	return config
}
