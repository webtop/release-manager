/**
 * Main front-end class
 * @author Paul Allsopp <pallsopp@digital-pig.com>
 */
var App = (function(App) {
	'use strict';

	App.releaseManager = function() {
		App.config();
		
		this.redirect = function(params) {
			var url = params.url;
			delete params.url;
			
			for (var n in params) {
				url += n + '=' + params[n] + '&';
			} 
			url = url.substr(0, -1);
			location.href = url;
		};
		
		return {
			redirect: this.redirect
		};
	};
	
	return App;
})(App || {});