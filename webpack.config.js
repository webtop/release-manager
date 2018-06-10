const path = require("path");
const webpack = require("webpack");
const bundlePath = path.resolve(__dirname, "./src/assets/js/");

module.exports = {
	mode : 'development',
	entry : './src/assets/js/jsx/index.js',
	module : {
		rules : [{
			test : /\.(js|jsx)$/,
			exclude : /(node_modules|bower_components|bundle\.js)/,
			loader : 'babel-loader',
			options : {
				presets : [ 'env' ]
			}
		}]
	},
	resolve: { 
		extensions: ['*', '.js', '.jsx'] 
	},
	output : {
		path : bundlePath,
		filename : "bundle.js"
	}
};
