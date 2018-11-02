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
						App.notifier().showNotice('Connection Test', 'Connected test succeeded', 'success');
					} else {
						App.notifier().showNotice('Connection Test Failed', success.msg, 'error');
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