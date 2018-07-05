var App = (function() {
	'use strict';

	App.releaseManager = function() {
		$('#git-source-auth').on('change', function() {
			$('.auth-type-container').hide();
			$('div[data-for="' + $(this).val() + '"]').show();
		});
	};
	
	return App;
})(App || {});