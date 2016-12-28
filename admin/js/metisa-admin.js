(function( $ ) {
	'use strict';

	$(function () {
		// var METISA_URL = 'https://askmetisa.com/';
		var METISA_URL = 'http://localhost:8000/';

		$('#oauth-authorize').click(function (ev) {
			ev.preventDefault();
			window.open(getAuthUrl(), "popupWindow", "width=600,height=600,scrollbars=yes");
		});

		// TODO: State string must be randomised to prevent CSRF attacks
		function getAuthUrl () {
			var state = 'chickennutbread';

			// Build authorization link to OAuth2 Service Provider
			var url = METISA_URL + 'oauth/authorize/';
			url += '?response_type=code&client_id=pf1flhhoOPukYmdJaI69FMXXAM0xJUTrCQsSsex7&state=';
			url += state;

			return url;
		}
	});

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
