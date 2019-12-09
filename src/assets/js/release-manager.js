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
			var container = $('div[data-for="' + $(this).val() + '"]');
			$('.auth-type-container').hide();
			$('input', $(container)).attr('required', 'required');
			$(container).show();
		});
		
		
		$('form#connection-config').on('submit', function(evt) {
			evt.preventDefault();
			var result = App.buildConnectionParams();
			if (result[0] === true) {
				$(this).attr('disabled', 'disabled');
				$(this).text('...testing...');
				App.testConnection(result[1], App.allowConfigSave);
			} else {
				App.notifier().showNotice('Missing Data', 'There appears to be data missing to make a connection', 'error');
			}
			return false;
		});
		
		$('button#config-save').on('click', function() {
			var params = App.buildConnectionParams();
			$(this).attr('disabled', 'disabled');
			$(this).text('...saving...');
			App.saveConnectionParams(params, App.redirect, {url: 'someurl', p1: 'this', p2: 'that'});
		});
		
		this.buildConnectionParams = function() {
			var credentials = {};
			var formValid = true;
			
			$('.auth-type-container[data-for="' + $('#git-source-auth').val() + '"]').find('input').map(function() {
				if ($.trim(this.value) == '') {
					formValid = false;
				}
				credentials[this.name] = $.trim(this.value);
			}); 
			
			if ($.trim($('#git-api-url').val()) == '') {
				formValid = false;
			}
			
			var params = {
				'git-source-select': $('#git-source-select').val(),
				'git-source-auth': $('#git-source-auth').val(),
				'git-api-url': $('#git-api-url').val(),
				'git-credentials': credentials
			};
						
			return [formValid, params]; 
		};
		
		this.allowConfigSave = function(response) {
			console.log(response);
			var allowConfigSave = false;
			if (response.success && response.warnings == '') {
				App.showNotice('Connection Test', 'Connected test succeeded', 'success');
				allowConfigSave = true;
			} else {
				// Hard errors first
				if (response.msgs.length > 0) {
					App.showNotice('Connection Error', response.msgs.join('<br />'), 'error');
				} else if (response.warnings.length > 0) {
					App.showNotice('Connection Test', 'Connected test succeeded: ' + response.warnings, 'warning');
					// Warnings should not impact saving
					allowConfigSave = true;
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