/**
 * Main front-end class
 * @author Paul Allsopp <pallsopp@digital-pig.com>
 */
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
		
		$('#git-source-select').on('change', function(evt) {
			var option = $('option:selected', evt.target);
			$('#git-api-url').val($(option).attr('data-api-url'));
			$('#git-file-url').val($(option).attr('data-file-url'));
		});
		
		$('#git-source-auth').on('change', function() {
			$('.auth-type-container').hide();
			$('div[data-for="' + $(this).val() + '"]').show();
		});
		
		$('button#connection-test').on('click', function() {
			var result = App.buildConnectionParams();
			if (result[0] === true) {
				$(this).attr('disabled', 'disabled');
				$(this).text('...testing...');
				App.testConnection(result[1], App.allowConfigSave);
			} else {
				App.notifier().showNotice('Missing Data', 'There appears to be data missing to make a connection', 'error');
			}
		});
		
		$('button#config-save').on('click', function() {
			var params = App.buildConnectionParams();
			$(this).attr('disabled', 'disabled');
			$(this).text('...saving...');
			App.saveConnectionParams(params, App.redirect, {url: 'someurl', p1: 'this', p2: 'that'});
		});
		
		this.buildConnectionParams = function() {
			var credentials = {};
			var formValid = false;
			
			$('.auth-type-container[data-for="' + $('#git-source-auth').val() + '"]').find('input').map(function() {
				if ($(this.value).trim().length > 0) {
					credentials[this.name] = $.trim(this.value);
				}
			}); 
			
			var params = {
				'git-source-select': $('#git-source-select').val(),
				'git-api-url': $('#git-api-url').val(),
				'git-credentials': credentials
			};
			
			if ($('#git-source-auth').val() != 'none') {
				params['git-source-auth'] = $('#git-source-auth').val();
			}
			
			if ($.trim(params['git-api-url']) != '') {
				formValid = true;
			}
			
			return [formValid, params]; 
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