var App = (function(App) {
	'use strict';

	App.notifier = function() {
		this.notifierConfig = {
			animation: true,
			delay: {show: 250, hide: 500},
			html: true
		};
		
		$('#notifier').css({
			left: $('.card:first').offset().left + 'px',
			right: $('.card:first').offset().left + 'px',
			maxWidth: $('.card:first').css('width')
		});
		
		$('#notifier').on('click', App.notifier.hide);
		
		this.showNotice = function(title, content) {
			$('#notifier').find('.alert-title').text(title);
			$('#notifier').find('.alert-body').text(content);
			
			App.notifier.show();
		};
		
		// If there are any unseen notices show ad then remove them
		$('.unseen-notification').each(function() {
			App.showNotice($(this).attr('data-title'), $(this).text());
			$(this).remove();
		});
		
		
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