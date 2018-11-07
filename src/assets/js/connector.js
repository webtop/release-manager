var App = (function(App) {
	'use strict';

	/**
	 * Capture the global AJAX start event to show the loader
	 */
	$(document).ajaxStart(function() {
		App.showLoader();
	});
	
	/**
	 * Capture the global AJAX stop event to hide the loader
	 */
	$(document).ajaxStop(function() {
		App.hideLoader()
	});
	
	/**
	 * Capture the global AJAX error event to show errors
	 */
	$(document).ajaxError(function(evt, xhr, settings, error) {
		App.showNotice('Event Error', error, 'error');
		App.hideLoader();
	});
	
	App.connector = function() {
		
		this.showLoader = function() {
			console.log('showing loader');
			$('#loader').show();
		};
		
		this.hideLoader = function() {
			console.log('hiding loader');
			$('#loader').hide();
		};
		
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
		
		this.saveConnectionParams = function(params, callback, callbackProperties) {
			$.ajax({
				data: params,
				method: 'post',
				url: '/save-connection-params',
				complete: function(xhr) {
					if (typeof callbackProperties == 'undefined') {
						callbackProperties = JSON.parse(xhr.responseText);
					}
					
					callback(callbackProperties);
				}
			});
		};
		
		App.hideLoader();
		return this;
	};
	
	return App;
})(App || {});