App = {
	init: function() {
		// Change all our select boxes into select2 boxes
		$('select').select2();
		
		$('#select-auth-type').on('change', function() {
			$('.auth-type').hide();
			$('#auth-type-' + $(this).val()).show();
		});
	}
};