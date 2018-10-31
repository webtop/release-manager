var App = (function(App) {
	'use strict';

	App.releaseManager = function() {
		$('.auth-type-container').hide();
		$('select').select2();
		
		$('#git-source-auth').on('change', function() {
			$('.auth-type-container').hide();
			$('div[data-for="' + $(this).val() + '"]').show();
			$('input:first', 'div[data-for="' + $(this).val() + '"]').focus();
		});
		
		$('button#connection-test').on('click', function() {
			$(this).attr('disabled', 'disabled');
			$(this).text('...testing...');
			App.connector().testConnection($('form#connection-config'), 'connection-test');
		});
		
		return {};
	};
	
	return App;
})(App || {});