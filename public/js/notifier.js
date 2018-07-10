var App = (function(App) {
	'use strict';

	App.notifier = function() {
		$().popover({
			animation: true,
			delay: {show: 250, hide: 500},
			html: false,
			placement: 'bottom',
			title: 'Error',
			trigger: 'manual',
			offset: '4px'
		});
		
		this.showNotice = function(content) {
			App.config.content = content;
			$('nav').popover('show');
		};
		
		return this;
	};
	
	return App;
})(App || {});