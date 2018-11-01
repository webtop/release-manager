var App = (function(App) {
	'use strict';

	App.connector = function() {
		
		this.testConnection = function(form, submitId) {
			$.ajax({
				jqBtn: $('#' + submitId),
				data: form.serialize(),
				method: 'post',
				url: '/test-connection',
				success: function(response) {
					if (response.success) {
						
					} else {
						
					}
				},
				error: function(xhr, status, error) {
					
				},
				complete: function() {
					this.jqBtn.removeAttr('disabled');
					this.jqBtn.text('Test Connection');
				}
			});
		};
		
		return this;
	};
	
	return App;
})(App || {});