var App = (function(App) {
	'use strict';

	App.config = function() {
		$('.auth-type-container').hide();
		$('select').select2();
		
		$('#git-source-select').on('change', function()  {
			$('form#connection-config').find('input').each(function() {
				this.value = "";
			});
		});
		
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
		
		$('#connection-test, #config-save').on('click', (evt) => {
			$(evt.target).closest('form').find('button[type="submit"]').removeClass('active');
			$(evt.target).addClass('active');
		});
		
		$('form#connection-config').on('submit', function(evt) {
			evt.preventDefault();
			var result = App.buildConnectionParams();
			if (result[0] === true) {
				if ($('#connection-test').hasClass('active')) {
					$('#connection-test').attr('disabled', 'disabled');
					$('#connection-test').text('...testing...');
					App.testConnection(result[1], App.allowConfigSave);
				} else if ($('#config-save').hasClass('active')) {
					$('#config-save').attr('disabled', 'disabled');
					$('#config-save').text('...saving...');
					App.saveConnectionParams(result[1], App.redirect, {url: '/repos'});
				} else {
					return false;
				}
			} else {
				App.notifier().showNotice('Missing Data', 'There appears to be data missing to make a connection', 'error');
			}
			return false;
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
				$('button#config-save').trigger('focus');
			}
			
			$('button#connection-test').removeAttr('disabled');
			$('button#connection-test').text('Test Connection');
		};
		
		return {
			'allowConfigSave': this.allowConfigSave
		};
	}
	
	return App;
})(App || {});