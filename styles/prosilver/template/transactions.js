;(function($, window, document) {
	$('#new_transaction_button').click(function () {
		var $newTransaction = $('#new_transaction');

		$newTransaction.slideToggle('fast');
		phpbb.ajaxCallbacks.alt_text.call(this);

		if ($newTransaction.is(':visible')) {
			$('#to_user').focus();
		}
		return false;
	});

})(jQuery, window, document);
