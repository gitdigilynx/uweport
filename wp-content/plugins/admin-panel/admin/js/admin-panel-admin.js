(function( $ ) {
	'use strict';

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

jQuery(document).ready( function () {
    jQuery('#warehouse_enteries').DataTable({
       "order": [[ 0, "asc" ]],
        "pageLength" : 10,
    });
} );



function add_loader(parent_div, position_absolute = false) {
    var position = '';
    if (position_absolute == true) {
        var position = 'position-absolute';
    }
    if (!jQuery(parent_div).find('.spinner_wrapper').length) {
        jQuery(parent_div).append('<div class="spinner_wrapper"><div class="spinner_overlay"></div><div class="spinner_container ' + position + '"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div></div>');
    }
}

function remove_loader(parent_div) {
    if (jQuery(parent_div).find('.spinner_wrapper').length) {
        jQuery(parent_div).find('.spinner_wrapper').remove();
    }
}



