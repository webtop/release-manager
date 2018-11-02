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
		
		this.showNotice = function(title, content, status) {
			$('#notifier').find('.alert-title').text(title);
			$('#notifier').find('.alert-body').text(content);
			
			if (status == 'success') {
				$('#notifier').removeClass('bg-warning');
				$('#notifier').removeClass('bg-danger');
				$('#notifier').addClass('bg-success');
			} else if (status == 'error') {
				$('#notifier').removeClass('bg-warning');
				$('#notifier').addClass('bg-danger');
				$('#notifier').removeClass('bg-success');
			} else {
				$('#notifier').addClass('bg-warning');
				$('#notifier').removeClass('bg-danger');
				$('#notifier').removeClass('bg-success');
			}
			App.notifier.show();
		};
		
		// If there are any posted notices, show them
		$('.unseen-notification').each(function() {
			App.showNotice($(this).attr('data-title'), $(this).text(), $(this).attr('data-status'));
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