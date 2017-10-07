var path = require('path');

module.exports = {
	// This is the "main" file which should include all other modules
	entry: './Private/Vuejs/TweetList.js',

	// Where should the compiled file go?
	output: {
		// To the `dist` folder
		path: path.resolve(__dirname, './Public/JavaScripts'),
		// With the filename `build.js` so it's dist/build.js
		filename: 'TweetList.js'
	},

	module: {
		// Special compilation rules
		loaders: [
			{
				// Ask webpack to check: If this file ends with .js, then apply some transforms
				test: /\.js$/,
				// Transform it with babel
				loader: 'babel-loader',
				// don't transform node_modules folder (which don't need to be compiled)
				exclude: /node_modules/
			},
			{
				test: /\.vue$/,
				loader: 'vue-loader',
				options: {
					loaders: {
						// Since sass-loader (weirdly) has SCSS as its default parse mode, we map
						// the "scss" and "sass" values for the lang attribute to the right configs here.
						// other preprocessors should work out of the box, no loader config like this necessary.
						'scss': 'vue-style-loader!css-loader!sass-loader',
						'sass': 'vue-style-loader!css-loader!sass-loader?indentedSyntax'
					}
					// other vue-loader options go here
				}
			}
		]
	}
};
