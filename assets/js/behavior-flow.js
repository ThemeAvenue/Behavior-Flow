jQuery(document).ready(function ($) {

	/**
	 * jQuery Select2
	 * http://select2.github.io/select2/
	 */

	if (jQuery().select2 && $('#bf_next_page').length) {
		$('#bf_next_page:visible').select2();
	}

});