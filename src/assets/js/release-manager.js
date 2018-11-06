var App = (function(App) {
	'use strict';

	App.releaseManager = function() {
		$('.auth-type-container').hide();
		$('select').select2();
		
		// NOTE: uncomment before deploy
		//$('#git-source-select').on('change', function()  {
		//	$('form#connection-config').find('input').each(function() {
		//		this.value = "";
		//	});
		//});
		
		$('#git-source-auth').on('change', function() {
			$('.auth-type-container').hide();
			$('div[data-for="' + $(this).val() + '"]').show();
			$('input:first', 'div[data-for="' + $(this).val() + '"]').focus();
		});
		
		$('button#connection-test').on('click', function() {
			var credentials = {};
			$(this).attr('disabled', 'disabled');
			$(this).text('...testing...');
			
			$('.auth-type-container[data-for="' + $('#git-source-auth').val() + '"]').find('input').map(function() {
				credentials[this.name] = this.value;
			}); 
			
			var params = {
				'git-source-select': $('#git-source-select').val(),
				'git-api-url': $('#git-api-url').val(),
				'git-credentials': credentials
			};
			
			if ($('#git-source-auth').val() != 'none') {
				params['git-source-auth'] = $('#git-source-auth').val();
			}
			
			App.testConnection(params, App.allowConfigSave);
		});
		
		$('button#config-save').on('click', function() {
			$(this).attr('disabled', 'disabled');
			$(this).text('...saving...');
			
			
		});
		
		this.allowConfigSave = function(response) {
			if (response.success) {
				App.showNotice('Connection Test', 'Connected test succeeded', 'success');
				$('button#config-save').removeClass('hidden');
				$('button#config-save').focus();
			} else {
				App.showNotice('Connection Error', response.msgs.join('<br />'), response.severity);
			}
			
			$('button#connection-test').removeAttr('disabled');
			$('button#connection-test').text('Test Connection');
		};
		
		return this;
	};
	
	return App;
})(App || {});