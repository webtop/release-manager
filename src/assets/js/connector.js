var App = (function(App) {
	'use strict';

	App.connector = function() {
		
		this.testConnection = function(params, callback) {
			$.ajax({
				data: params,
				method: 'post',
				url: '/test-connection',
				complete: function(xhr) {
					var response = JSON.parse(xhr.responseText);
					callback(response);
				}
			});
		};
		
		return this;
	};
	
	return App;
})(App || {});