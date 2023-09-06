(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
	jQuery(document).ready(function($) {
	if (window.innerWidth > 992) {
		let buttonOrder = document.querySelector('.sellkit-one-page-checkout-place-order');
	    let reviewOrder = document.querySelector('.sellkit-checkout-right-column .sellkit-multistep-checkout-sidebar .woocommerce-checkout-review-order .woocommerce-checkout-review-order-table');
	    reviewOrder.parentNode.insertBefore(buttonOrder, reviewOrder.nextSibling);

	    // Memicu event kustom setelah pemindahan selesai
    	jQuery(document).trigger('sellkit:buttonMoved');
    }
    });

    jQuery(document).ready(function($) {
        var heading = $('.sellkit-checkout-order-review-heading.header.heading');
        if (heading.length && heading.text().trim() === "Your order") {
            heading.text('Your Product');
        }
    });
	
	jQuery(document).ready(function($) {
	   	var $completeOrderButton = $('.sellkit-one-page-checkout-place-order');
	    var $termsCheckbox = $('.woocommerce-terms-and-conditions-wrapper');
	    if ($completeOrderButton.length && $termsCheckbox.length) {
	        $termsCheckbox.detach().insertBefore($completeOrderButton);
	    }
	});
})( jQuery );
