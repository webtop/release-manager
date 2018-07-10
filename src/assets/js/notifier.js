var App = (function(App) {
	'use strict';

	App.notifier = function() {
		this.notifierConfig = {
			animation: true,
			delay: {show: 250, hide: 500},
			html: true
		};
		
		$('#notifier').css({
			position: 'absolute',
			zIndex: 1000,
			top: 0,
			left: $('.card:first').offset().left + 'px',
			right: $('.card:first').offset().left + 'px',
			maxWidth: $('.card:first').css('width'),
			opacity: 0,
			cursor: 'pointer'
		});
		
		$('#notifier').on('click', App.notifier.hide);
		
		this.showNotice = function(title, content) {
			$('#notifier').find('.alert-title').text(title);
			$('#notifier').find('.alert-body').text(content);
			
			App.notifier.show();
		};
		
		return this;
	};
	
	App.notifier.show = function() {
		if (App.notifierConfig.animation) {
			$('#notifier').animate({
				opacity: 1,
				top: '66px'
			});
		} else {
			$('#notifier').show();
		}
		return this;
	};
	
	App.notifier.hide = function() {
		if (App.notifierConfig.animation) {
			$('#notifier').animate({
				opacity: 0,
				top: 0
			});
		} else {
			$('#notifier').hide();
		}
		return this;
	};
	
	
	return App;
})(App || {});