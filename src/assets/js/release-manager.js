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
		
		return this;
	};
	
	return App;
})(App || {});