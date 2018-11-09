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
			var params = App.buildConnectionParams();
			App.testConnection(params, App.allowConfigSave);
		});
		
		$('button#config-save').on('click', function() {
			$(this).attr('disabled', 'disabled');
			$(this).text('...saving...');
			
			var params = App.buildConnectionParams();
			App.saveConnectionParams(params, App.redirect, {url: 'someurl', p1: 'this', p2: 'that'});
		});
		
		this.buildConnectionParams = function() {
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
			
			return params;
		};
		
		this.allowConfigSave = function(response) {
			console.log(response);
			var allowConfigSave = false;
			if (response.success && response.warnings == '') {
				App.showNotice('Connection Test', 'Connected test succeeded', 'success');
				allowConfigSave = true;
			} else {
				if (response.warnings) {
					App.showNotice('Connection Test', 'Connected test succeeded: ' + response.warnings, response.severity);
					allowConfigSave = true;
				} else if (response.msgs) {
					App.showNotice('Connection Error', response.msgs.join('<br />'), response.severity);
				} else {
					App.showNotice('Connection Error', 'Unknown response', 'error');
				}
			}
			
			if (allowConfigSave) {
				$('button#config-save').removeClass('hidden');
				$('button#config-save').focus();
			}
			
			$('button#connection-test').removeAttr('disabled');
			$('button#connection-test').text('Test Connection');
		};
		
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
			allowConfigSave: this.allowConfigSave,
			redirect: this.redirect
		};
	};
	
	return App;
})(App || {});